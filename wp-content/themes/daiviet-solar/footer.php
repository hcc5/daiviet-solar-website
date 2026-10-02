<?php if (!defined('ABSPATH')) exit; ?>
</main>

<footer class="dvs-footer">
  <div class="dvs-container dvs-footer__grid">
    <div class="dvs-footer__col">
      <a class="dvs-logo dvs-logo--footer" href="<?php echo esc_url(home_url('/')); ?>">
        <span class="dvs-logo__mark" aria-hidden="true">☀</span>
        <span class="dvs-logo__text"><?php bloginfo('name'); ?></span>
      </a>
      <p class="dvs-footer__desc">Đại Việt Solar tư vấn, thiết kế, thi công và vận hành hệ thống điện năng lượng mặt trời cho nhà dân và doanh nghiệp trên toàn quốc.</p>
      <div class="dvs-footer__social">
        <?php if ($zalo = get_theme_mod('dvs_zalo', 'https://zalo.me/0978021216')) : ?>
          <a href="<?php echo esc_url($zalo); ?>" target="_blank" rel="noopener">Zalo</a>
        <?php endif; ?>
        <?php if ($fb = get_theme_mod('dvs_facebook', 'https://www.facebook.com/ctydaiviet.tbdn')) : ?>
          <a href="<?php echo esc_url($fb); ?>" target="_blank" rel="noopener">Facebook</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="dvs-footer__col">
      <h3>Giải pháp</h3>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/cong-nghe/')); ?>">Công nghệ</a></li>
        <li><a href="<?php echo esc_url(home_url('/san-pham/')); ?>">Sản phẩm</a></li>
        <li><a href="<?php echo esc_url(home_url('/quy-trinh-lap-dat/')); ?>">Quy trình lắp đặt</a></li>
        <li><a href="<?php echo esc_url(home_url('/bao-hanh-bao-duong/')); ?>">Bảo hành &amp; bảo dưỡng</a></li>
      </ul>
    </div>

    <div class="dvs-footer__col">
      <h3>Cấu hình đề xuất</h3>
      <ul>
        <li><a href="<?php echo esc_url(home_url('/cau-hinh-nha-dan/')); ?>">Cho nhà dân</a></li>
        <li><a href="<?php echo esc_url(home_url('/cau-hinh-doanh-nghiep/')); ?>">Cho doanh nghiệp</a></li>
        <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Tin tức &amp; kiến thức</a></li>
        <li><a href="<?php echo esc_url(home_url('/lien-he/')); ?>">Liên hệ tư vấn</a></li>
      </ul>
    </div>

    <div class="dvs-footer__col">
      <h3>Liên hệ</h3>
      <ul class="dvs-footer__contact">
        <li>📍 <?php echo esc_html(get_theme_mod('dvs_address', 'Ninh Bình, Việt Nam')); ?></li>
        <li>📞 <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', get_theme_mod('dvs_hotline', '0978021216'))); ?>"><?php echo esc_html(get_theme_mod('dvs_hotline', '0978 021 216')); ?></a></li>
        <li>✉️ <a href="mailto:<?php echo esc_attr(get_theme_mod('dvs_email', 'lienhe@daivietsolar.vn')); ?>"><?php echo esc_html(get_theme_mod('dvs_email', 'lienhe@daivietsolar.vn')); ?></a></li>
      </ul>
    </div>
  </div>

  <div class="dvs-footer__bottom">
    <div class="dvs-container">
      &copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. Đã đăng ký bản quyền.
    </div>
  </div>
</footer>

<div class="dvs-float-rail" aria-label="Kênh liên hệ nhanh">
  <?php $dvs_fb_url = get_theme_mod('dvs_facebook', 'https://www.facebook.com/ctydaiviet.tbdn'); ?>
  <?php if ($dvs_fb_url) : ?>
  <a class="dvs-float-rail__item dvs-float-rail__item--fb" href="<?php echo esc_url($dvs_fb_url); ?>" target="_blank" rel="noopener" aria-label="Fanpage Facebook Đại Việt Solar">
    <span aria-hidden="true">f</span>
  </a>
  <?php endif; ?>
  <?php $dvs_zalo_url = get_theme_mod('dvs_zalo', 'https://zalo.me/0978021216'); ?>
  <?php if ($dvs_zalo_url) : ?>
  <a class="dvs-float-rail__item dvs-float-rail__item--zalo" href="<?php echo esc_url($dvs_zalo_url); ?>" target="_blank" rel="noopener" aria-label="Chat Zalo với Đại Việt Solar">
    <span aria-hidden="true">Zalo</span>
  </a>
  <?php endif; ?>
  <a class="dvs-float-rail__item dvs-float-rail__item--phone" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', get_theme_mod('dvs_hotline', '0978021216'))); ?>" aria-label="Gọi tư vấn ngay">
    <span aria-hidden="true">📞</span>
  </a>
  <a class="dvs-float-rail__item dvs-float-rail__item--mail" href="mailto:<?php echo esc_attr(get_theme_mod('dvs_email', 'lienhe@daivietsolar.vn')); ?>" aria-label="Gửi email cho Đại Việt Solar">
    <span aria-hidden="true">✉️</span>
  </a>
</div>

<?php wp_footer(); ?>
</body>
</html>
