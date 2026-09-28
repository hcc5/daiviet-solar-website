<?php if (!defined('ABSPATH')) exit; get_header(); ?>

<section class="dvs-section dvs-404">
  <div class="dvs-container">
    <h1>404</h1>
    <p>Xin lỗi, không tìm thấy trang bạn yêu cầu.</p>
    <a class="dvs-btn dvs-btn--primary" href="<?php echo esc_url(home_url('/')); ?>">Về trang chủ</a>
  </div>
</section>

<?php get_footer(); ?>
