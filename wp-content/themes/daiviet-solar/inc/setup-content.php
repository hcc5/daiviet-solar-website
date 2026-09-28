<?php
/**
 * Tu dong tao cac trang + menu + permalink khi theme duoc kich hoat.
 * Giup admin co du trang ngay khi len site, khong can tu tao thu cong.
 */

if (!defined('ABSPATH')) exit;

function dvs_page_definitions() {
    return [
        'cong-nghe' => [
            'title' => 'Công nghệ',
            'excerpt' => 'Công nghệ tấm pin, biến tần và giám sát hệ thống điện mặt trời mà Đại Việt Solar đang triển khai.',
        ],
        'san-pham' => [
            'title' => 'Sản phẩm',
            'excerpt' => 'Các dòng thiết bị điện mặt trời và giải pháp trọn gói Đại Việt Solar đang cung cấp.',
        ],
        'quy-trinh-lap-dat' => [
            'title' => 'Quy trình lắp đặt',
            'excerpt' => 'Quy trình khảo sát, thiết kế, thi công và nghiệm thu hệ thống điện mặt trời tại Đại Việt Solar.',
        ],
        'bao-hanh-bao-duong' => [
            'title' => 'Bảo hành & bảo dưỡng',
            'excerpt' => 'Chính sách bảo hành thiết bị và lịch bảo dưỡng định kỳ giúp hệ thống vận hành ổn định lâu dài.',
        ],
        'cau-hinh-nha-dan' => [
            'title' => 'Cấu hình cho nhà dân',
            'excerpt' => 'Gợi ý cấu hình hệ thống điện mặt trời theo nhu cầu sử dụng điện của hộ gia đình.',
        ],
        'cau-hinh-doanh-nghiep' => [
            'title' => 'Cấu hình cho doanh nghiệp',
            'excerpt' => 'Giải pháp điện mặt trời cho doanh nghiệp từ quy mô nhỏ đến nhà máy, khu công nghiệp.',
        ],
        'lien-he' => [
            'title' => 'Liên hệ',
            'excerpt' => 'Thông tin liên hệ và biểu mẫu đăng ký tư vấn miễn phí từ Đại Việt Solar.',
        ],
    ];
}

function dvs_ensure_pages() {
    $created_ids = [];
    foreach (dvs_page_definitions() as $slug => $def) {
        $existing = get_page_by_path($slug);
        if ($existing) {
            $created_ids[$slug] = $existing->ID;
            continue;
        }
        $id = wp_insert_post([
            'post_title'   => $def['title'],
            'post_name'    => $slug,
            'post_excerpt' => $def['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ]);
        if (!is_wp_error($id) && $id) {
            $created_ids[$slug] = $id;
        }
    }
    return $created_ids;
}

function dvs_ensure_menu($page_ids) {
    $menu_name = 'Menu chính Đại Việt Solar';
    $menu = wp_get_nav_menu_object($menu_name);
    if (!$menu) {
        $menu_id = wp_create_nav_menu($menu_name);
    } else {
        $menu_id = $menu->term_id;
    }

    $existing_items = wp_get_nav_menu_items($menu_id);
    if (!empty($existing_items)) {
        // Menu already populated, don't duplicate.
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
        return;
    }

    $order = ['cong-nghe', 'san-pham', 'quy-trinh-lap-dat', 'bao-hanh-bao-duong', 'cau-hinh-nha-dan', 'cau-hinh-doanh-nghiep', 'lien-he'];
    $position = 1;
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'Trang chủ',
        'menu-item-url'    => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-position' => $position++,
    ]);
    foreach ($order as $slug) {
        if (empty($page_ids[$slug])) continue;
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'     => dvs_page_definitions()[$slug]['title'],
            'menu-item-object-id' => $page_ids[$slug],
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
            'menu-item-position'  => $position++,
        ]);
    }
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => 'Tin tức',
        'menu-item-url'    => home_url('/blog/'),
        'menu-item-status' => 'publish',
        'menu-item-position' => $position++,
    ]);

    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

function dvs_ensure_permalinks() {
    if (get_option('permalink_structure') !== '/%postname%/') {
        update_option('permalink_structure', '/%postname%/');
        update_option('rewrite_rules', '');
        flush_rewrite_rules();
    }
    // Blog list at /blog/
    if (get_option('show_on_front') !== 'page') {
        // Keep default "posts" front but ensure a stable /blog/ base for the post index.
        update_option('page_for_posts', 0);
    }
}

function dvs_after_switch_theme() {
    $page_ids = dvs_ensure_pages();
    dvs_ensure_menu($page_ids);
    dvs_ensure_permalinks();
}
add_action('after_switch_theme', 'dvs_after_switch_theme');

/**
 * Also run once on init if the marker option is missing — covers the case
 * where the theme is already active (e.g. set via WP-CLI/docker without
 * triggering the switch_theme hook).
 */
function dvs_maybe_bootstrap() {
    if (get_option('dvs_bootstrapped')) return;
    dvs_after_switch_theme();
    update_option('dvs_bootstrapped', 1);
}
add_action('init', 'dvs_maybe_bootstrap');
