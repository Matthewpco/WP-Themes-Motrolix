<?php
/*
Template Name: Recall
*/
?>
<?php get_header(); ?>
<?php while ( have_posts() ): the_post(); ?>

<div class="main sidebar-right group">

	<div class="content-part">
		<div class="pad">
			<article id="entry-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>

				<?php if ( wpb_breadcrumbs_enabled() ): ?>
					<?php echo wpb_breadcrumbs()."</br>"; ?>
				<?php endif; ?>

				<?php get_template_part('partials/page-image'); ?>

				<div id="featured-image-wrapper"><!--/.ads-header-->
					<div id="featured-image-container">
					<h3>Sponsored Links</h3>
					<?php if (1==1) { ?>
						<script>var ad_data = get_ad_size('intelligence-content');
								document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
							<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>
					<?php } ?>
					</div>
				</div><!--/.ads-header-->
				</br>

				<?php get_template_part('partials/page-title'); ?>

				<div class="text">
          <?php $model_year_text = str_replace(' Recalls', '', get_the_title()); ?>
          <p>See below for all <?php echo $model_year_text ?> recalls.</p>
					<?php the_content(); ?>
					<div class="clear"></div>
				</div>

				<?php
					$children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0&depth=1');
					if ($children) { ?>
					<ul>
					<?php echo $children; ?>
					</ul>
          <br><br><br>
			<div id="ads-content-wrapper"><!--/.ads-header-->
				<div id="ad-content-container">
				<h3>Sponsored Links</h3>
					<script>var ad_data = get_ad_size('comments');
						document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>
				</div>
			</div><!--/.ads-header-->


				<?php } ?>

			</article>
			</br>
			</br>

			<?php if ( air_related_posts::get_option('enable') ) { get_template_part('partials/related-posts'); } ?>
			</br></br>

			<div id="ads-content-wrapper"><!--/.ads-header-->
				<div id="ad-content-container">
				<h3>Sponsored Links</h3>
					<script>var ad_data = get_ad_size('comments');
						document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>
				</div>
			</div><!--/.ads-header-->

		</div><!--/.pad-->
	</div><!--/.content-part-->

	<div class="sidebar">
		<?php get_sidebar(); ?>
	</div><!--/.sidebar-->

</div><!--/.main-->

<?php endwhile; ?>

<?php get_footer(); ?>
