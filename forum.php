<?php get_header(); ?>
<?php while ( have_posts() ): the_post(); ?>

<div class="main group <?php echo wpb_option('general-sidebar','sidebar-right'); ?>">

	<div class="content-part">
		<div class="pad">
			<article id="entry-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>
			
			
				<?php get_template_part('partials/page-image'); ?>
				
				
				<?php get_template_part('partials/page-title'); ?>
				
				<div class="text">
					<?php the_content(); ?>
					<div class="clear"></div>
				</div>			
			</article>
						

			<?php comments_template(); ?>
		
			<div id="ads-content-wrapper"><!--/.ads-header-->
				<div id="ad-content-container">
				<h3>Sponsored Links</h3>
					<div id='div-gpt-ad-content-four';'>
						<script>
							googletag.cmd.push(function() { googletag.display('div-gpt-ad-content-four'); });
						</script>
					</div>
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
