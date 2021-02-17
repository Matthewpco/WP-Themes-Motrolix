<?php
  $stickies = get_option( 'sticky_posts' );
  if (!empty($stickies)):
?>
<ul class="entry-sticky-list-group">
  <?php
    $sticky_post_args = array(
      'ignore_sticky_posts' => 1,
      'post__in' => $stickies,
    );
    $sticky_post_query = new WP_Query( $sticky_post_args );
    while ( $sticky_post_query->have_posts() ): $sticky_post_query->the_post(); ''
  ?>
  <li class="entry-sticky-item">
    <article id="entry-<?php the_ID(); ?>">
      <a
        href="<?php the_permalink() ?>"
        title="<?php the_title() ?>"
        style="background-image:url('<?php echo has_post_thumbnail() ? the_post_thumbnail_url('large') : get_template_directory_uri() . '/img/placeholder.png' ?>'">
        <div class="entry-sticky-item-featured-tag">Featured Story</div>
      	<div class="entry-sticky-item-inner">
          <?php if ( !wpb_option('post-hide-date') ): ?><div class="entry-sticky-item-date"> &mdash; <?php the_time('M j, Y'); ?> <?php if ( !wpb_option('post-hide-detailed-date') ): ?><?php _e('at','typegrid'); ?> <?php the_time('g:i a'); ?><?php endif; ?></div><?php endif; ?>
          <div class="entry-sticky-item-title"><?php the_title() ?></div>
        </div>
        <div class="entry-sticky-item-cta-tag">Watch Here</div>
      </a>
    </article>
  </li>
  <?php endwhile ?>
</ul>
<?php endif ?>
