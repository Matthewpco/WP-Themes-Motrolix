<ul class="entry-list group">

	<?php $i = 1; echo '<li class="entry-row">'; while ( have_posts() ): the_post(); ?>

	<article id="entry-<?php the_ID(); ?>" <?php post_class('entry group'); ?>>
		<div class="entry-inner">
			<div class="entry-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php if ( has_post_thumbnail() ): ?>
						<?php the_post_thumbnail('size-thumbnail-medium'); ?>
					<?php else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/img/placeholder.png" alt="<?php the_title(); ?>" />
					<?php endif; ?>
					<?php if ( has_post_format('video') ) echo'<span class="thumb-icon"><i class="icon-play"></i></span>'; ?>
					<?php if ( has_post_format('audio') ) echo'<span class="thumb-icon"><i class="icon-volume-up"></i></span>'; ?>
				</a>
				<?php if ( !wpb_option('post-hide-comments') ): ?><a class="entry-comments" href="<?php comments_link(); ?>"><i class="icon-comments-alt"></i><?php comments_number( '0', '1', '%' ); ?></a><?php endif; ?>
			</div><!--/.entry-thumbnail-->

			<ul class="entry-meta">
				<?php if ( !wpb_option('post-hide-categories') ): ?><li class="category"><?php _e('in','typegrid'); ?> <?php the_category(' &middot; '); ?></li><?php endif; ?>
				<?php if ( !wpb_option('post-hide-date') ): ?><li class="date"> &mdash; <?php the_time('j M, Y'); ?> <?php if ( !wpb_option('post-hide-detailed-date') ): ?><?php _e('at','typegrid'); ?> <?php the_time('g:i a'); ?><?php endif; ?></li><?php endif; ?>
			</ul><!--/.entry-meta-->

			<div class="clear"></div>

			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h2><!--/.entry-title-->

			<div class="text">
				<div class="excerpt">
					<?php the_excerpt(); ?>
					<?php if ( wpb_option('excerpt-more-link-enable') ): ?>
						<div class="more-link-wrap">
							<a class="more-link" href="<?php the_permalink(); ?>">
								<i class="icon-share-alt"></i><span><?php echo wpb_option('read-more', __('(more...)','typegrid')); ?></span>
							</a>
						</div>
					<?php endif; ?>
				</div><!--/.excerpt-->
			</div><!--/.text-->

		</div><!--/.entry-inner-->
	</article><!--/.entry-->

	<?php if($i % 2 == 0) { echo '</li><li class="entry-row">'; }	$i++; endwhile;	echo '</li>'; ?>

</ul><!--/.entry-list-->
