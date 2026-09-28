<?php if (!defined('ABSPATH')) exit; get_header(); ?>

<section class="dvs-page-hero">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Tin tức &amp; kiến thức</span>
    <h1><?php the_archive_title(); ?></h1>
  </div>
</section>

<section class="dvs-section">
  <div class="dvs-container">
    <?php if (have_posts()) : ?>
      <div class="dvs-grid dvs-grid--3">
        <?php while (have_posts()) : the_post(); ?>
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
        <?php endwhile; ?>
      </div>
      <div class="dvs-pagination"><?php the_posts_pagination(); ?></div>
    <?php else : ?>
      <p>Chưa có bài viết nào.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
