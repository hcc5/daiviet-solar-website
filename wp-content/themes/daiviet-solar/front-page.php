<?php
if (!defined('ABSPATH')) exit;
get_header();
?>

<section class="dvs-hero">
  <div class="dvs-container dvs-hero__grid">
    <div class="dvs-hero__content">
      <span class="dvs-eyebrow">Giải pháp điện mặt trời trọn gói</span>
      <h1>Chủ động nguồn điện sạch,<br>tối ưu chi phí mỗi tháng</h1>
      <p class="dvs-hero__lead">Đại Việt Solar tư vấn – thiết kế – thi công – vận hành hệ thống điện năng lượng mặt trời cho nhà ở, doanh nghiệp và nhà xưởng, sử dụng thiết bị chính hãng, bảo hành minh bạch.</p>
      <div class="dvs-hero__actions">
        <a class="dvs-btn dvs-btn--primary dvs-btn--lg" href="<?php echo esc_url(home_url('/lien-he/')); ?>">Nhận tư vấn miễn phí</a>
        <a class="dvs-btn dvs-btn--ghost dvs-btn--lg" href="<?php echo esc_url(home_url('/quy-trinh-lap-dat/')); ?>">Xem quy trình lắp đặt</a>
      </div>
      <div class="dvs-hero__stats">
        <div><strong>10+</strong><span>năm kinh nghiệm ngành điện</span></div>
        <div><strong>100%</strong><span>thiết bị chính hãng, đủ CO/CQ</span></div>
        <div><strong>24/7</strong><span>hỗ trợ kỹ thuật sau lắp đặt</span></div>
      </div>
    </div>
    <div class="dvs-hero__visual" aria-hidden="true">
      <div class="dvs-hero__panel-card">
        <span class="dvs-hero__sun">☀</span>
        <div class="dvs-hero__panel-grid">
          <?php for ($i = 0; $i < 6; $i++) : ?><span></span><?php endfor; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="dvs-section dvs-why">
  <div class="dvs-container">
    <h2 class="dvs-section__title">Vì sao chọn Đại Việt Solar</h2>
    <p class="dvs-section__subtitle">Cam kết rõ ràng ở từng bước, từ tư vấn đến hậu mãi.</p>
    <div class="dvs-grid dvs-grid--3">
      <div class="dvs-card">
        <div class="dvs-card__icon">🛠️</div>
        <h3>Kỹ thuật chuẩn quốc tế</h3>
        <p>Đội ngũ kỹ sư được đào tạo bài bản, thi công theo tiêu chuẩn an toàn điện và kỹ thuật lắp đặt quốc tế.</p>
      </div>
      <div class="dvs-card">
        <div class="dvs-card__icon">📄</div>
        <h3>Minh bạch hợp đồng</h3>
        <p>Báo giá chi tiết theo hạng mục, hợp đồng rõ ràng, không phát sinh chi phí ẩn trong quá trình thi công.</p>
      </div>
      <div class="dvs-card">
        <div class="dvs-card__icon">🔧</div>
        <h3>Hậu mãi tận tâm</h3>
        <p>Bảo hành thiết bị chính hãng, lịch bảo dưỡng định kỳ và đội ngũ kỹ thuật phản hồi nhanh khi cần hỗ trợ.</p>
      </div>
    </div>
  </div>
</section>

<section class="dvs-section dvs-tech dvs-section--alt">
  <div class="dvs-container dvs-split">
    <div class="dvs-split__text">
      <span class="dvs-eyebrow">Công nghệ</span>
      <h2>Hệ thống thông minh, giám sát theo thời gian thực</h2>
      <p>Mỗi hệ thống điện mặt trời do Đại Việt Solar triển khai đều được tính toán công suất tối ưu theo mái, theo nhu cầu sử dụng và tích hợp ứng dụng giám sát sản lượng điện theo thời gian thực trên điện thoại.</p>
      <ul class="dvs-checklist">
        <li>Tấm pin hiệu suất cao, chống chịu thời tiết khắc nghiệt</li>
        <li>Biến tần (inverter) thông minh, tự động tối ưu điểm công suất</li>
        <li>Ứng dụng giám sát sản lượng điện, cảnh báo sự cố từ xa</li>
        <li>Tương thích hệ thống lưu trữ pin (BESS) khi cần dùng điện ban đêm</li>
      </ul>
      <a class="dvs-link-arrow" href="<?php echo esc_url(home_url('/cong-nghe/')); ?>">Tìm hiểu chi tiết công nghệ →</a>
    </div>
    <div class="dvs-split__visual" aria-hidden="true">
      <div class="dvs-stat-card">
        <div class="dvs-stat-card__row"><span>Hiệu suất chuyển đổi</span><strong>≥ 21%</strong></div>
        <div class="dvs-stat-card__row"><span>Tuổi thọ tấm pin</span><strong>25+ năm</strong></div>
        <div class="dvs-stat-card__row"><span>Giám sát</span><strong>Theo thời gian thực</strong></div>
      </div>
    </div>
  </div>
</section>

<section class="dvs-section dvs-products">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Sản phẩm &amp; giải pháp</span>
    <h2 class="dvs-section__title">Giải pháp cho từng nhu cầu</h2>
    <div class="dvs-grid dvs-grid--4">
      <a class="dvs-tile" href="<?php echo esc_url(home_url('/san-pham/')); ?>">
        <span class="dvs-tile__icon">🏠</span>
        <h3>Điện mặt trời áp mái dân dụng</h3>
        <p>Cho nhà phố, biệt thự, nhà cấp 4 — tối ưu diện tích mái sẵn có.</p>
      </a>
      <a class="dvs-tile" href="<?php echo esc_url(home_url('/san-pham/')); ?>">
        <span class="dvs-tile__icon">🏭</span>
        <h3>Điện mặt trời cho nhà xưởng</h3>
        <p>Giảm chi phí điện sản xuất, tận dụng mái xưởng diện tích lớn.</p>
      </a>
      <a class="dvs-tile" href="<?php echo esc_url(home_url('/san-pham/')); ?>">
        <span class="dvs-tile__icon">🔋</span>
        <h3>Hệ thống lưu trữ (BESS)</h3>
        <p>Lưu điện dùng ban đêm hoặc dự phòng khi mất điện lưới.</p>
      </a>
      <a class="dvs-tile" href="<?php echo esc_url(home_url('/san-pham/')); ?>">
        <span class="dvs-tile__icon">📈</span>
        <h3>Điện mặt trời trang trại năng lượng</h3>
        <p>Dự án quy mô lớn, tư vấn đầu tư và khai thác vận hành dài hạn.</p>
      </a>
    </div>
  </div>
</section>

<section class="dvs-section dvs-process dvs-section--alt">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Quy trình</span>
    <h2 class="dvs-section__title">4 bước triển khai rõ ràng</h2>
    <div class="dvs-steps">
      <div class="dvs-step"><span class="dvs-step__num">01</span><h3>Khảo sát &amp; tư vấn</h3><p>Khảo sát mái, đo nhu cầu sử dụng điện, đề xuất công suất phù hợp.</p></div>
      <div class="dvs-step"><span class="dvs-step__num">02</span><h3>Thiết kế &amp; báo giá</h3><p>Bản vẽ kỹ thuật, dự toán chi phí và thời gian hoàn vốn cụ thể.</p></div>
      <div class="dvs-step"><span class="dvs-step__num">03</span><h3>Thi công &amp; lắp đặt</h3><p>Đội kỹ thuật thi công theo tiến độ cam kết, giám sát an toàn chặt chẽ.</p></div>
      <div class="dvs-step"><span class="dvs-step__num">04</span><h3>Nghiệm thu &amp; bàn giao</h3><p>Kiểm tra vận hành, hướng dẫn sử dụng và bàn giao hồ sơ bảo hành.</p></div>
    </div>
    <a class="dvs-link-arrow" href="<?php echo esc_url(home_url('/quy-trinh-lap-dat/')); ?>">Xem chi tiết quy trình lắp đặt →</a>
  </div>
</section>

<section class="dvs-section dvs-configs">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Cấu hình đề xuất</span>
    <h2 class="dvs-section__title">Từ nhà dân đến doanh nghiệp quy mô lớn</h2>
    <div class="dvs-grid dvs-grid--2">
      <div class="dvs-config-card">
        <h3>Nhà dân</h3>
        <p>Hệ 3–10kWp phù hợp hộ gia đình 4–6 người, giảm đáng kể hoá đơn tiền điện hàng tháng.</p>
        <a class="dvs-btn dvs-btn--outline" href="<?php echo esc_url(home_url('/cau-hinh-nha-dan/')); ?>">Xem cấu hình nhà dân</a>
      </div>
      <div class="dvs-config-card dvs-config-card--dark">
        <h3>Doanh nghiệp</h3>
        <p>Hệ từ vài chục đến hàng nghìn kWp cho văn phòng, nhà xưởng, khu công nghiệp.</p>
        <a class="dvs-btn dvs-btn--outline dvs-btn--outline-light" href="<?php echo esc_url(home_url('/cau-hinh-doanh-nghiep/')); ?>">Xem cấu hình doanh nghiệp</a>
      </div>
    </div>
  </div>
</section>

<section class="dvs-section dvs-warranty dvs-section--alt">
  <div class="dvs-container dvs-split">
    <div class="dvs-split__visual" aria-hidden="true">
      <div class="dvs-stat-card">
        <div class="dvs-stat-card__row"><span>Bảo hành tấm pin</span><strong>12 năm</strong></div>
        <div class="dvs-stat-card__row"><span>Bảo hành biến tần</span><strong>5–10 năm</strong></div>
        <div class="dvs-stat-card__row"><span>Bảo dưỡng định kỳ</span><strong>2 lần/năm</strong></div>
      </div>
    </div>
    <div class="dvs-split__text">
      <span class="dvs-eyebrow">Bảo hành &amp; bảo dưỡng</span>
      <h2>Đồng hành lâu dài sau khi lắp đặt</h2>
      <p>Đại Việt Solar cung cấp chính sách bảo hành minh bạch cho từng thiết bị và lịch bảo dưỡng định kỳ để hệ thống luôn vận hành ở hiệu suất tối ưu trong suốt vòng đời sử dụng.</p>
      <a class="dvs-link-arrow" href="<?php echo esc_url(home_url('/bao-hanh-bao-duong/')); ?>">Xem chính sách bảo hành →</a>
    </div>
  </div>
</section>

<?php
$recent = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true]);
if ($recent->have_posts()) :
?>
<section class="dvs-section dvs-blog">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Tin tức &amp; kiến thức</span>
    <h2 class="dvs-section__title">Bài viết mới nhất</h2>
    <div class="dvs-grid dvs-grid--3">
      <?php while ($recent->have_posts()) : $recent->the_post(); ?>
        <a class="dvs-post-card" href="<?php the_permalink(); ?>">
          <?php if (has_post_thumbnail()) : ?>
            <div class="dvs-post-card__thumb"><?php the_post_thumbnail('dvs-card'); ?></div>
          <?php endif; ?>
          <div class="dvs-post-card__body">
            <span class="dvs-post-card__date"><?php echo esc_html(get_the_date()); ?></span>
            <h3><?php the_title(); ?></h3>
            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="dvs-cta">
  <div class="dvs-container dvs-cta__inner">
    <div>
      <h2>Sẵn sàng chuyển sang điện mặt trời?</h2>
      <p>Để lại thông tin, đội ngũ kỹ thuật Đại Việt Solar sẽ liên hệ khảo sát và báo giá miễn phí trong 24 giờ.</p>
    </div>
    <a class="dvs-btn dvs-btn--primary dvs-btn--lg" href="<?php echo esc_url(home_url('/lien-he/')); ?>">Đăng ký khảo sát ngay</a>
  </div>
</section>

<?php get_footer(); ?>
