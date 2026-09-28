<?php if (!defined('ABSPATH')) exit; get_header(); ?>

<section class="dvs-page-hero dvs-page-hero--post">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Tin tức &amp; kiến thức</span>
    <?php while (have_posts()) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <div class="dvs-post-meta">
        <span><?php echo esc_html(get_the_date()); ?></span>
        <span>·</span>
        <span><?php the_author(); ?></span>
      </div>
    <?php endwhile; rewind_posts(); ?>
  </div>
</section>

<section class="dvs-section">
  <div class="dvs-container dvs-prose dvs-prose--narrow">
    <?php while (have_posts()) : the_post(); ?>
      <?php if (has_post_thumbnail()) : ?>
        <div class="dvs-prose__thumb"><?php the_post_thumbnail('dvs-hero'); ?></div>
      <?php endif; ?>
      <?php the_content(); ?>
      <?php
      wp_link_pages([
        'before' => '<div class="dvs-pagination">',
        'after'  => '</div>',
      ]);
      ?>
    <?php endwhile; ?>

    <div class="dvs-post-cta">
      <h3>Cần tư vấn giải pháp điện mặt trời?</h3>
      <a class="dvs-btn dvs-btn--primary" href="<?php echo esc_url(home_url('/lien-he/')); ?>">Nhận tư vấn miễn phí</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
