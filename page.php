<?php get_header(); ?>
<?php while ( have_posts() ): the_post(); ?>

<div class="main group <?php echo wpb_option('general-sidebar','sidebar-right'); ?>">

	<div class="content-part">
		<div class="pad">
			<article id="entry-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>
			
				<?php if ( wpb_breadcrumbs_enabled() ): ?>
					<?php echo wpb_breadcrumbs()."</br>"; ?>
				<?php endif; ?>
				
				<?php get_template_part('partials/page-image'); ?>
				
			<div id="ads-header-wrapper"><!--/.ads-header-->
				<div id="ad-header-container-center">
				<h3>Sponsored Links</h3>
					<?php if (1==1) { ?>
					<script>var ad_data = get_ad_size('below-content');
							document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
					<?php } ?>
				</div>		
			</div><!--/.ads-header-->
			
			</br>
				<?php get_template_part('partials/page-title'); ?>
				
				<div class="text">
					<?php the_content(); ?>
					<div class="clear"></div>
				</div>			
			</article>
			</br>
			<div id="ads-header-wrapper"><!--/.ads-header-->
				<div id="ad-header-container-center">
				<h3>Sponsored Links</h3>
					<?php if (1==1) { ?>
					<script>var ad_data = get_ad_size('below-content');
							document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
					<?php } ?>
				</div>		
			</div><!--/.ads-header-->
			</br>
			
		<?php if (1==0) { ?>			
			<div id="ads-header-wrapper"><!--/.ads-header-->
				<div id="ad-header-container-center">
				<h3>Sponsored Links</h3>

					<script>var ad_data = get_ad_size('loop-center-content');
						document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
				</div>		
			</div><!--/.ads-header-->

			<?php //comments_template(); ?>
		
			<div id="ads-header-wrapper"><!--/.ads-header-->
				<div id="ad-header-container-center">
				<h3>Sponsored Links</h3>
					<script>var ad_data = get_ad_size('loop-center-content');
						document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
					<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
					
				</div>		
			</div><!--/.ads-header-->
		<?php } ?>
			
		</div><!--/.pad-->
	</div><!--/.content-part-->
	
	<div class="sidebar">	
		<?php get_sidebar(); ?>
	</div><!--/.sidebar-->

</div><!--/.main-->

<?php endwhile; ?>
<?php get_footer(); ?>
