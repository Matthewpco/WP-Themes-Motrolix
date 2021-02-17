<?php
/*
Template Name: Subscription
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

				
				<?php get_template_part('partials/page-title'); ?>
				
				<div class="text">
					<?php the_content(); ?>
					<div class="clear"></div>
				</div>	
		
			</article>

	
		</div><!--/.pad-->
	</div><!--/.content-part--> 
	


</div><!--/.main-->

<?php endwhile; ?>
<?php get_footer(); ?>
