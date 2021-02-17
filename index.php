<?php get_header(); ?>

<div class="main group <?php echo wpb_option('general-sidebar','sidebar-right'); ?>">

	<div class="content-part">
		<div class="pad group">

			<?php if ( wpb_option('featured-slider-enable') || wpb_option('highlights-enable') ) { get_template_part('partials/featured'); } ?>

			<?php if ( is_home() && !is_paged() ): ?>
				<?php if ( wpb_option('home-widgets-top') ): ?>
				<?php if ( wpb_option('home-widgets-top-title') ): ?><div class="page-title"><h4><i class="icon-arrow-right"></i><?php echo wpb_option('home-widgets-top-title'); ?></h4></div><?php endif; ?>
				<div id="spot-top" class="home-widgets group">
					<ul class="grid one-half"><?php dynamic_sidebar('widget-home-top-1'); ?></ul>
					<ul class="grid one-half last"><?php dynamic_sidebar('widget-home-top-2'); ?></ul>
				</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php get_template_part('partials/page-title'); ?>

			<?php
				if ( wpb_option('blog-standard-home') ) {
					get_template_part('partials/loop-alt'); }
				else {
          get_template_part('partials/loop-sticky-categories');
					get_template_part('partials/loop-sticky-posts');
					get_template_part('partials/loop');
        }
			?>

			<?php if ( is_home() && !is_paged() ): ?>
				<?php if ( wpb_option('home-widgets-bottom') ): ?>
				<?php if ( wpb_option('home-widgets-bottom-title') ): ?><div class="page-title"><h4><i class="icon-arrow-right"></i><?php echo wpb_option('home-widgets-bottom-title'); ?></h4></div><?php endif; ?>
				<div id="spot-bottom" class="home-widgets group">
					<ul class="grid one-half"><?php dynamic_sidebar('widget-home-bottom-1'); ?></ul>
					<ul class="grid one-half last"><?php dynamic_sidebar('widget-home-bottom-2'); ?></ul>
				</div>
				<?php endif; ?>
			<?php endif; ?>

		</div><!--/.pad-->
	</div><!--/.content-part-->

	<div class="sidebar">
		<?php get_sidebar(); ?>
	</div><!--/.sidebar-->

</div><!--/.main-->

<?php get_footer(); ?>
