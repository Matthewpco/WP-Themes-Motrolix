<?php 
$related_ids = get_crp_posts($post->ID); 
$related = query_posts(array('post_type' => 'post', 'post__in' => $related_ids));

 ?>

<h4 class="heading related">
	<i class="icon-hand-right"></i>You may also like...
</h4>

<?php if ( have_posts() ): ?>
<ul class="entry-related group">
	
	<?php while ( have_posts() ) : the_post(); ?>
	<li class="related">
		<article <?php post_class(); ?>>
			<a href="<?php the_permalink(); ?>">
				
				<?php if ( !air_related_posts::get_option('hide-thumbnail') ): ?>
					<span class="entry-thumbnail">
						<?php if ( has_post_thumbnail() ): ?>
							<?php the_post_thumbnail('size-thumbnail-medium'); ?>
						<?php else: ?>
							<img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.png" alt="<?php the_title() ;?>" />
						<?php endif; ?>
						<?php if ( has_post_format('video') ) echo'<span class="thumb-icon"><i class="icon-play"></i></span>'; ?>
						<?php if ( has_post_format('audio') ) echo'<span class="thumb-icon"><i class="icon-volume-up"></i></span>'; ?>
					</span>
				<?php endif; ?>

				<span class="rel-entry-title"><?php the_title(); ?></span>
			</a>
		</article>
	</li><!--/.related-->
	<?php endwhile; ?>

</ul><!--/.entry-related-->
<?php endif; ?>

<?php wp_reset_query(); ?>
