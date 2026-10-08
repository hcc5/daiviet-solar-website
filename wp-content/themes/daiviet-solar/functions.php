<?php
/**
 * Dai Viet Solar theme functions
 */

if (!defined('ABSPATH')) exit;

define('DVS_VERSION', '1.4.0');
define('DVS_DIR', get_template_directory());
define('DVS_URI', get_template_directory_uri());

/** Theme setup */
function dvs_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');

    register_nav_menus([
        'primary' => __('Menu chính', 'daiviet-solar'),
        'footer'  => __('Menu chân trang', 'daiviet-solar'),
    ]);
}
add_action('after_setup_theme', 'dvs_setup');

/** Styles & scripts */
function dvs_assets() {
    wp_enqueue_style('dvs-fonts', 'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap', [], null);
    wp_enqueue_style('dvs-style', DVS_URI . '/assets/css/style.css', [], DVS_VERSION);
    wp_enqueue_script('dvs-main', DVS_URI . '/assets/js/main.js', [], DVS_VERSION, true);
    if (is_page_template('page-cong-cu-tinh-dien.php')) {
        wp_enqueue_script('dvs-dien-calc', DVS_URI . '/assets/js/dien-calc.js', [], DVS_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'dvs_assets');

/** Image sizes */
add_image_size('dvs-card', 640, 420, true);
add_image_size('dvs-hero', 1400, 900, true);

/** Excerpt length & more */
add_filter('excerpt_length', fn($len) => 28);
add_filter('excerpt_more', fn($more) => '…');

/** Basic on-page SEO: meta description + Open Graph + canonical + LocalBusiness schema */
function dvs_seo_head() {
    $description = '';
    if (is_front_page()) {
        $description = 'Đại Việt Solar — tư vấn, thiết kế, thi công và vận hành hệ thống điện năng lượng mặt trời cho nhà dân và doanh nghiệp. Thiết bị chính hãng, bảo hành rõ ràng, thi công chuẩn kỹ thuật.';
    } elseif (is_singular()) {
        global $post;
        if ($post) {
            $description = has_excerpt($post) ? wp_strip_all_tags(get_the_excerpt($post)) : wp_trim_words(wp_strip_all_tags($post->post_content), 30);
        }
    } elseif (is_category() || is_tag() || is_archive()) {
        $description = wp_strip_all_tags(term_description());
    }
    $description = trim(preg_replace('/\s+/', ' ', $description));
    if ($description) {
        printf('<meta name="description" content="%s" />' . "\n", esc_attr(mb_substr($description, 0, 160)));
    }

    $canonical = is_front_page() ? home_url('/') : (is_singular() ? get_permalink() : (is_home() ? home_url('/blog/') : home_url(add_query_arg([], $_SERVER['REQUEST_URI'] ?? ''))));
    printf('<link rel="canonical" href="%s" />' . "\n", esc_url($canonical));

    $title = wp_get_document_title();
    $ogimg = '';
    if (is_singular() && has_post_thumbnail()) {
        $ogimg = get_the_post_thumbnail_url(get_the_ID(), 'dvs-hero');
    }
    echo '<meta property="og:type" content="' . (is_singular() && !is_front_page() ? 'article' : 'website') . '" />' . "\n";
    printf('<meta property="og:title" content="%s" />' . "\n", esc_attr($title));
    if ($description) printf('<meta property="og:description" content="%s" />' . "\n", esc_attr(mb_substr($description, 0, 200)));
    printf('<meta property="og:url" content="%s" />' . "\n", esc_url($canonical));
    if ($ogimg) printf('<meta property="og:image" content="%s" />' . "\n", esc_url($ogimg));
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";

    if (is_front_page()) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
            'description' => $description,
            'telephone' => get_theme_mod('dvs_hotline', ''),
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'VN',
            ],
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'dvs_seo_head', 1);

/** Register site-wide options used in header/footer (hotline, email, address, zalo) via Customizer */
function dvs_customize_register($wp_customize) {
    $wp_customize->add_section('dvs_contact', ['title' => __('Thông tin liên hệ Đại Việt Solar', 'daiviet-solar'), 'priority' => 30]);

    $fields = [
        'dvs_hotline'    => ['label' => 'Hotline', 'default' => '0978 021 216'],
        'dvs_email'      => ['label' => 'Email', 'default' => 'lienhe@daivietsolar.vn'],
        'dvs_address'    => ['label' => 'Địa chỉ', 'default' => 'Ninh Bình, Việt Nam'],
        'dvs_zalo'       => ['label' => 'Link Zalo', 'default' => 'https://zalo.me/0978021216'],
        'dvs_facebook'   => ['label' => 'Link Facebook', 'default' => 'https://www.facebook.com/ctydaiviet.tbdn'],
    ];
    foreach ($fields as $id => $f) {
        $wp_customize->add_setting($id, ['default' => $f['default'], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($id, ['label' => $f['label'], 'section' => 'dvs_contact', 'type' => 'text']);
    }
}
add_action('customize_register', 'dvs_customize_register');

/**
 * Contact form handler — stores submission as a custom post type entry
 * (so it's visible in wp-admin and reachable via REST API for automation)
 * and redirects back with a status flag.
 */
function dvs_register_lead_cpt() {
    register_post_type('dvs_lead', [
        'label' => 'Yêu cầu tư vấn',
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => ['title', 'editor', 'custom-fields'],
        'capability_type' => 'post',
        'map_meta_cap' => true,
    ]);
}
add_action('init', 'dvs_register_lead_cpt');

function dvs_handle_contact_form() {
    if (empty($_POST['dvs_contact_nonce']) || !wp_verify_nonce($_POST['dvs_contact_nonce'], 'dvs_contact_submit')) {
        wp_safe_redirect(add_query_arg('dvs_status', 'error', wp_get_referer() ?: home_url('/lien-he/')));
        exit;
    }

    $name  = isset($_POST['dvs_name']) ? sanitize_text_field(wp_unslash($_POST['dvs_name'])) : '';
    $phone = isset($_POST['dvs_phone']) ? sanitize_text_field(wp_unslash($_POST['dvs_phone'])) : '';
    $email = isset($_POST['dvs_email_field']) ? sanitize_email(wp_unslash($_POST['dvs_email_field'])) : '';
    $type  = isset($_POST['dvs_type']) ? sanitize_text_field(wp_unslash($_POST['dvs_type'])) : '';
    $note  = isset($_POST['dvs_note']) ? sanitize_textarea_field(wp_unslash($_POST['dvs_note'])) : '';

    if (empty($name) || empty($phone)) {
        wp_safe_redirect(add_query_arg('dvs_status', 'error', wp_get_referer() ?: home_url('/lien-he/')));
        exit;
    }

    $post_id = wp_insert_post([
        'post_type'    => 'dvs_lead',
        'post_title'   => sprintf('%s - %s', $name, $phone),
        'post_content' => $note,
        'post_status'  => 'publish',
    ]);

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, 'phone', $phone);
        update_post_meta($post_id, 'email', $email);
        update_post_meta($post_id, 'loai_nhu_cau', $type);

        $admin_email = get_theme_mod('dvs_email', get_option('admin_email'));
        $subject = 'Yêu cầu tư vấn mới từ website: ' . $name;
        $body = "Tên: {$name}\nSĐT: {$phone}\nEmail: {$email}\nNhu cầu: {$type}\nGhi chú: {$note}";
        wp_mail($admin_email, $subject, $body);
    }

    wp_safe_redirect(add_query_arg('dvs_status', 'success', home_url('/lien-he/')));
    exit;
}
add_action('admin_post_nopriv_dvs_contact_submit', 'dvs_handle_contact_form');
add_action('admin_post_dvs_contact_submit', 'dvs_handle_contact_form');

/** Load auto-setup (pages, menu, permalinks) */
require DVS_DIR . '/inc/setup-content.php';
