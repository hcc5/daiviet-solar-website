<?php if (!defined('ABSPATH')) exit; get_header(); ?>

<section class="dvs-page-hero">
  <div class="dvs-container">
    <h1><?php the_title(); ?></h1>
  </div>
</section>

<section class="dvs-section">
  <div class="dvs-container dvs-prose">
    <?php while (have_posts()) : the_post(); ?>
      <?php if (has_post_thumbnail()) : ?>
        <div class="dvs-prose__thumb"><?php the_post_thumbnail('dvs-hero'); ?></div>
      <?php endif; ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</section>

<?php get_footer(); ?>
