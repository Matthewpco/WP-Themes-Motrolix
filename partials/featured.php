<?php
// Query featured entries
$featured = new WP_Query(
	array(
		'no_found_rows'				=> FALSE,
		'update_post_meta_cache'	=> FALSE,
		'update_post_term_cache'	=> FALSE,
		'ignore_sticky_posts'		=> 1,
		'posts_per_page'			=> wpb_option('featured-slider-number'),
		'cat'						=> wpb_option('featured-slider-category')
	)
);
$highlights = new WP_Query(
	array(
		'no_found_rows'				=> TRUE,
		'update_post_meta_cache'	=> FALSE,
		'update_post_term_cache'	=> FALSE,
		'ignore_sticky_posts'		=> 1,
		'posts_per_page'			=> 3,
		'cat'						=> wpb_option('highlights-category')
	)
);
?>

<?php if ( is_home() && !is_paged() ): ?>
	
	<?php if ( wpb_option('featured-heading') || wpb_option('featured-subheading') ): ?>
	<div class="page-title">
		<h4><i class="icon-pushpin"></i><?php echo wpb_option('featured-heading'); ?> <span><?php echo wpb_option('featured-subheading'); ?></span></h4>
	</div><!--/page-title-->
	<?php endif; ?>
	
	<?php if ( wpb_option('featured-slider-enable') ): ?>	
	<script type="text/javascript">
		// Specific flexslider code for custom directionNav markup
		jQuery(window).load(function() {
			var $featured = jQuery('.flex-featured .flexslider');
			$featured
			.flexslider({
				animation: "slide",
				controlsContainer: ".flex-container",
				slideshow: true,
				directionNav: false,
				controlNav: false,
				pauseOnHover: true,
				slideshowSpeed: 7000,
				animationDuration: 600,
				smoothHeight: true,
				touch: false
			});
			jQuery('.featured .flex-next').click(function($){
				$.preventDefault();
				$featured.flexslider('next');
			});
			jQuery('.featured .flex-prev').click(function($){
				$.preventDefault();
				$featured.flexslider('prev');
			});
			jQuery('.slides').addClass('loaded');
		});
	</script>
	<div class="featured group">
		<div class="flex-container flex-featured">
			<div class="flexslider">
				<ul class="slides">				
					<?php while ( $featured->have_posts() ): $featured->the_post(); ?>
					<li <?php post_class('entry'); ?>>
						<div class="entry-thumbnail">
							<?php if ( has_post_thumbnail() ): ?>
							<?php the_post_thumbnail('size-thumbnail-large'); ?>
							<?php else: ?>
								<img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.png" alt="<?php the_title_attribute(); ?>" />
							<?php endif; ?>
							<?php if ( has_post_format('video') ) echo'<span class="thumb-icon"><i class="icon-play"></i></span>'; ?>
							<?php if ( has_post_format('audio') ) echo'<span class="thumb-icon"><i class="icon-volume-up"></i></span>'; ?>

							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>
							<?php if ( !wpb_option('post-hide-comments') ): ?><a class="entry-comments" href="<?php comments_link(); ?>"><i class="icon-comments-alt"></i><?php comments_number( '0', '1', '%' ); ?></a><?php endif; ?>
						</div>
					</li>
					<?php endwhile; ?>			
				</ul>
				<?php if ($featured->found_posts > 1): ?>
				<ul class="flex-direction-nav">
					<li><a href="#" class="flex-prev"><i class="icon-chevron-left"></i></a></li>
					<li><a href="#" class="flex-next"><i class="icon-chevron-right"></i></a></li>
				</ul>
				<?php endif; ?>
			</div>
		</div><!--/.flex-container-->
	</div>
	<?php endif; ?>
	
	<?php if ( wpb_option('highlights-enable') ): ?>	
	<div class="highlights">
		<ul class="group">
			<?php while ( $highlights->have_posts() ): $highlights->the_post(); ?>
				<li id="entry-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>	
					<div class="entry-inner">
						<div class="entry-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php if ( has_post_thumbnail() ): ?>
									<?php the_post_thumbnail('size-thumbnail-small'); ?>
								<?php else: ?>
									<img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.png" alt="<?php the_title(); ?>" />
								<?php endif; ?>
								<?php if ( has_post_format('video') ) echo'<span class="thumb-icon"><i class="icon-play"></i></span>'; ?>
								<?php if ( has_post_format('audio') ) echo'<span class="thumb-icon"><i class="icon-volume-up"></i></span>'; ?>
							</a>
							<?php if ( !wpb_option('post-hide-comments') ): ?><a class="entry-comments" href="<?php comments_link(); ?>"><i class="icon-comments-alt"></i><?php comments_number( '0', '1', '%' ); ?></a><?php endif; ?>
						</div><!--/.entry-thumbnail-->
						
						<ul class="entry-meta">
							<?php if ( !wpb_option('post-hide-categories') ): ?><li class="category">In <?php the_category(' &middot; '); ?></li><?php endif; ?>
						</ul><!--/.entry-meta-->
						
						<div class="clear"></div>

						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h2><!--/.entry-title-->
				
					</div><!--/.entry-inner-->	
				</li><!--/.entry-->
			<?php endwhile; ?>
		</ul>
	</div>
	<div class="clear"></div> 
	<?php endif; ?>
	
	<div class="hr featured"></div>
	
		<div id="featured-image-wrapper"><!--/.ads-header-->
			<div id="featured-image-container">
			 <h3>Sponsored Links</h3> 
			<?php if (1==1) { ?>
			<script>var ad_data = get_ad_size('home-featured');
				document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
			<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>	
			<?php } ?>
		</div>		
	</div><!--/.ads-header-->

	<div class="hr featured"></div>
<?php endif; ?>
