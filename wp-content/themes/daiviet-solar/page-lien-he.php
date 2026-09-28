<?php if (!defined('ABSPATH')) exit; get_header();
$status = isset($_GET['dvs_status']) ? sanitize_text_field($_GET['dvs_status']) : '';
?>

<section class="dvs-page-hero">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Liên hệ</span>
    <h1>Đăng ký khảo sát &amp; tư vấn miễn phí</h1>
    <p class="dvs-page-hero__lead">Để lại thông tin, đội ngũ kỹ thuật Đại Việt Solar sẽ liên hệ lại trong vòng 24 giờ.</p>
  </div>
</section>

<section class="dvs-section">
  <div class="dvs-container dvs-contact-grid">
    <div class="dvs-contact-form">
      <?php if ($status === 'success') : ?>
        <div class="dvs-alert dvs-alert--success">Cảm ơn bạn! Yêu cầu tư vấn đã được gửi, đội ngũ Đại Việt Solar sẽ liên hệ lại sớm nhất.</div>
      <?php elseif ($status === 'error') : ?>
        <div class="dvs-alert dvs-alert--error">Vui lòng điền đầy đủ Họ tên và Số điện thoại trước khi gửi.</div>
      <?php endif; ?>

      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="dvs-form">
        <input type="hidden" name="action" value="dvs_contact_submit">
        <?php wp_nonce_field('dvs_contact_submit', 'dvs_contact_nonce'); ?>

        <label class="dvs-form__field">
          <span>Họ và tên *</span>
          <input type="text" name="dvs_name" required>
        </label>

        <label class="dvs-form__field">
          <span>Số điện thoại *</span>
          <input type="tel" name="dvs_phone" required>
        </label>

        <label class="dvs-form__field">
          <span>Email</span>
          <input type="email" name="dvs_email_field">
        </label>

        <label class="dvs-form__field">
          <span>Nhu cầu</span>
          <select name="dvs_type">
            <option value="Nhà dân">Điện mặt trời nhà dân</option>
            <option value="Doanh nghiệp">Điện mặt trời doanh nghiệp</option>
            <option value="Bảo hành/Bảo dưỡng">Bảo hành / bảo dưỡng hệ thống hiện có</option>
            <option value="Khác">Khác</option>
          </select>
        </label>

        <label class="dvs-form__field">
          <span>Ghi chú thêm</span>
          <textarea name="dvs_note" rows="4" placeholder="Địa chỉ, diện tích mái, hóa đơn điện trung bình..."></textarea>
        </label>

        <button type="submit" class="dvs-btn dvs-btn--primary dvs-btn--lg">Gửi yêu cầu tư vấn</button>
      </form>
    </div>

    <div class="dvs-contact-info">
      <h3>Thông tin liên hệ</h3>
      <ul class="dvs-footer__contact">
        <li>📍 <?php echo esc_html(get_theme_mod('dvs_address', 'Ninh Bình, Việt Nam')); ?></li>
        <li>📞 <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', get_theme_mod('dvs_hotline', '0978021216'))); ?>"><?php echo esc_html(get_theme_mod('dvs_hotline', '0978 021 216')); ?></a></li>
        <li>✉️ <a href="mailto:<?php echo esc_attr(get_theme_mod('dvs_email', 'lienhe@daivietsolar.vn')); ?>"><?php echo esc_html(get_theme_mod('dvs_email', 'lienhe@daivietsolar.vn')); ?></a></li>
      </ul>
      <p class="dvs-contact-info__note">Làm việc từ 8:00 – 17:30, Thứ Hai – Thứ Bảy.</p>
    </div>
  </div>
</section>

<?php get_footer(); ?>
