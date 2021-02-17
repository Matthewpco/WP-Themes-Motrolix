<?php get_header(); ?>
<?php while ( have_posts() ): the_post(); ?>
		
<div class="main group <?php echo wpb_option('general-sidebar','sidebar-right'); ?>">
		
	<div class="content-part">
		<div class="pad group">
			
			<article id="entry-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>	
				
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>	
					<?php if ( !wpb_option('post-hide-comments-single') ): ?><a class="entry-comments" href="<?php comments_link(); ?>"><i class="icon-comments-alt"></i><?php comments_number( '0', '1', '%' ); ?></a><?php endif; ?>
					<ul class="entry-meta group">
						<?php if ( !wpb_option('post-hide-author-single') ): ?><li class="entry-author"><?php _e('by','typegrid'); ?> <?php the_author_posts_link(); ?></li><?php endif; ?>
						<?php if ( !wpb_option('post-hide-categories-single') ): ?><li class="category"><?php _e('in','typegrid'); ?> <?php the_category(' &middot; '); ?></li><?php endif; ?>
						<?php if ( !wpb_option('post-hide-date-single') ): ?><li class="date"> &mdash; <?php the_time('M j, Y'); ?> <?php if ( !wpb_option('post-hide-detailed-date') ): ?><?php _e('at','typegrid'); ?> <?php the_time('g:i a'); ?><?php endif; ?></li><?php endif; ?>
					</ul>
					<div class="clear"></div>
				</header>
				
				<?php 
				// **************************************************************************************************************************//
				// Andrew Froehlich		4/7/2013
				// By default, there is no post format in our posts.
				// This theme only includes the featured image in the article if its of type 'image'
				// We want the image displayed regardles.  We also needed to add partials/post-formats.php so this would work.
				// **************************************************************************************************************************//

				//if ( get_post_format() ) { get_template_part('partials/post-formats'); }
				get_template_part('partials/post-formats');
				?>
				
				<div class="entry-part text <?php if ( wpb_option('single-share-disable')) { echo 'no-share' ; } ?>">		
					<?php the_content(); ?>
									<?php wp_link_pages(array('before'=>'<div class="entry-page-links">'.__('Pages:','typegrid'),'after'=>'</div>')); ?>
					<div class="clear"></div>
					<?php //get_template_part('partials/sharrre'); ?> 
				</div>
				
				<div class="clear"></div>
				
				<?php if ( !wpb_option('post-hide-tags-single') ): // Post Tags ?>
					<?php the_tags('<p class="entry-tags"><span>'.__('Tags:','typegrid').'</span> ','','</p>'); ?>
				<?php endif; ?>

				<div id="featured-image-wrapper"><!--/.ads-header-->
					<div id="featured-image-container">
					<h3>Sponsored Links</h3>
					<?php if (1==1) { ?>
						<script>var ad_data = get_ad_size('header-replace-center');
							document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>	
					<?php } ?>
					</div>		
				</div><!--/.ads-header-->
				<?php if ( is_active_sidebar( 'widget-bottom_article' ) ) : ?>
					<?php dynamic_sidebar( 'widget-bottom_article' ); ?>
				<?php endif; ?>
				</br>
				<?php if ( wpb_option('post-enable-author-block') ): // Post Author Block ?>
					<div class="clear"></div>
					<div class="entry-author-block group">
						<div class="entry-author-avatar"><?php echo get_avatar(get_the_author_meta('user_email'),'160'); ?></div>
						<p class="entry-author-name">&mdash; <?php the_author_meta('display_name'); ?></p>
						<p class="entry-author-description"><?php the_author_meta('description'); ?></p>
					</div>
				<?php endif; ?>
					
			</article>
					<div id="header-bottom-wrapper"><!--/.ads-header-->
				<!--<div id="header-bottom-container-left">
					<script>var ad_data = get_ad_size('header-bottom-left');
							document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
				</div>-->
				<div id="header-bottom-container-center">
					<h3>Sponsored Links</h3>
					<?php if (1==1) { ?>
					<script>var ad_data = get_ad_size('header-bottom-center');
							document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
					<?php } ?>
				</div>
				<!--<div id="header-bottom-container-right">
					<script>var ad_data = get_ad_size('header-bottom-right');
							document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>			
				</div>-->
			</div><!--/.ads-header-->
				
			<?php if ( wpb_option('single-postnav') == '1' ): ?>
			<ul class="entry-browse group">
				<li class="previous"><?php previous_post_link('%link', '<i class="icon-chevron-left"></i><strong>'.__('Previous story', 'typegrid').'</strong> <span>%title</span>'); ?></li>
				<li class="next"><?php next_post_link('%link', '<i class="icon-chevron-right"></i><strong>'.__('Next story', 'typegrid').'</strong> <span>%title</span>'); ?></li>
			</ul>
			<?php endif; ?>
			
			<?php if ( air_related_posts::get_option('enable') ) { get_template_part('partials/related-posts'); } ?>
			<br>
			<div id="ads-content-wrapper"><!--/.ads-header-->
				<div id="ad-content-container">
				<?php if (1==1) { ?>
					<script>var ad_data = get_ad_size('comments');
						document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>	
				<?php } ?>
				</div>		
			</div><!--/.ads-header-->
			
			<?php comments_template(); ?>
			<br>
			<div id="ads-content-wrapper"><!--/.ads-header-->
				<div id="ad-content-container">
				<?php if (1==1) { ?>
					<script>var ad_data = get_ad_size('comments');
						document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
				<?php } ?>
				</div>		
			</div><!--/.ads-header-->

		</div><!--/.pad-->
	</div><!--/.content-part-->
	
	<div class="sidebar">	
		<?php get_sidebar(); ?>
	</div><!--/.sidebar-->

</div><!--/.main-->

<?php endwhile;?>
<?php get_footer(); ?>
