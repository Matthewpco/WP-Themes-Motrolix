<?php if ( (comments_open() && wpb_comments_enabled()) || have_comments() ): ?>
<div id="comments">

	<?php if ( comments_open() && wpb_comments_enabled() && ('top'==wpb_option('comments-form-location')) ): ?>
		<div id="response">
			<?php comment_form(); ?>
		</div>
	<?php endif; ?>

	<?php if ( have_comments() ): ?>
	
		<h4 class="heading"><i class="icon-comments-alt"></i><?php printf( _n('%1$s Comment','%1$s Comments',get_comments_number(),'typegrid'), number_format_i18n(get_comments_number()) ); ?></h4>
	
		<ol class="commentlist group">
			<?php wp_list_comments( array('avatar_size'=>120,'walker'=> new Walker_Comment_Custom,'type'=>'comment')); //, 'walker'=>'Walker_Comment_Custom' ?>
			
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option('page_comments') ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav">
			<div class="nav-previous"><?php previous_comments_link(); ?></div>
			<div class="nav-next"><?php next_comments_link(); ?></div>
			<div class="clear"></div>
		</nav><!--/#comment-nav-->
		<?php endif; ?>
		
	<?php endif; ?>

	<?php if ( comments_open() && wpb_comments_enabled() && ('bottom'==wpb_option('comments-form-location')) ): ?>
		<div id="response">
			<?php comment_form(); ?>
		</div>
	<?php endif; ?>

</div><!--/#comments-->
<?php endif; ?>
