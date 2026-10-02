<?php if (!defined('ABSPATH')) exit; ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="dvs-skip-link screen-reader-text" href="#main">Bỏ qua đến nội dung chính</a>

<div class="dvs-topbar">
  <div class="dvs-container dvs-topbar__inner">
    <div class="dvs-topbar__contact">
      <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', get_theme_mod('dvs_hotline', '0978021216'))); ?>">
        <span class="dvs-icon">📞</span> <?php echo esc_html(get_theme_mod('dvs_hotline', '0978 021 216')); ?>
      </a>
      <a href="mailto:<?php echo esc_attr(get_theme_mod('dvs_email', 'lienhe@daivietsolar.vn')); ?>">
        <span class="dvs-icon">✉️</span> <?php echo esc_html(get_theme_mod('dvs_email', 'lienhe@daivietsolar.vn')); ?>
      </a>
    </div>
    <div class="dvs-topbar__right">
      <span class="dvs-topbar__tag">Năng lượng sạch — Đầu tư một lần, tiết kiệm nhiều năm</span>
      <div class="dvs-topbar__social">
        <?php $dvs_fb_top = get_theme_mod('dvs_facebook', 'https://www.facebook.com/ctydaiviet.tbdn'); ?>
        <?php if ($dvs_fb_top) : ?>
          <a href="<?php echo esc_url($dvs_fb_top); ?>" target="_blank" rel="noopener" aria-label="Facebook Đại Việt Solar">f</a>
        <?php endif; ?>
        <?php $dvs_zalo_top = get_theme_mod('dvs_zalo', 'https://zalo.me/0978021216'); ?>
        <?php if ($dvs_zalo_top) : ?>
          <a href="<?php echo esc_url($dvs_zalo_top); ?>" target="_blank" rel="noopener" aria-label="Zalo Đại Việt Solar">Z</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<header class="dvs-header" id="site-header">
  <div class="dvs-container dvs-header__inner">
    <a class="dvs-logo" href="<?php echo esc_url(home_url('/')); ?>">
      <?php if (has_custom_logo()) : the_custom_logo(); else : ?>
        <span class="dvs-logo__mark" aria-hidden="true">☀</span>
        <span class="dvs-logo__text"><?php bloginfo('name'); ?></span>
      <?php endif; ?>
    </a>

    <nav class="dvs-nav" aria-label="Menu chính">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'dvs-nav__list',
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

    <div class="dvs-header__cta">
      <a class="dvs-btn dvs-btn--ghost" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', get_theme_mod('dvs_hotline', '0978021216'))); ?>">Gọi tư vấn</a>
      <a class="dvs-btn dvs-btn--primary" href="<?php echo esc_url(home_url('/lien-he/')); ?>">Đăng ký khảo sát</a>
    </div>

    <button class="dvs-nav-toggle" id="dvs-nav-toggle" aria-expanded="false" aria-controls="dvs-mobile-nav">
      <span></span><span></span><span></span>
      <span class="screen-reader-text">Mở menu</span>
    </button>
  </div>

  <div class="dvs-mobile-nav" id="dvs-mobile-nav">
    <?php
    wp_nav_menu([
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => 'dvs-mobile-nav__list',
      'fallback_cb'    => false,
    ]);
    ?>
    <a class="dvs-btn dvs-btn--primary dvs-mobile-nav__cta" href="<?php echo esc_url(home_url('/lien-he/')); ?>">Đăng ký khảo sát miễn phí</a>
  </div>
</header>

<main id="main" class="dvs-main">
