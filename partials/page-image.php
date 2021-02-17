<?php if ( has_post_thumbnail() ): ?>
<div class="page-image">
	<?php $image_id = get_post_thumbnail_id(); ?>
	<?php if (is_page_template('page-templates/full-width.php')) :?>
		<?php $image = wpb_dynamic_resize($image_id,'','1060','442',TRUE); ?>
	<?php else: ?>
		<?php $image = wpb_dynamic_resize($image_id,'','720','300',TRUE); ?>
	<?php endif; ?>
	<img src="<?php echo $image['url']; ?>" />	
	<div class="page-image-text">
		<?php //echo wpb_post_thumbnail_caption(); ?>
	</div>
</div><!--/.page-image-->
<?php endif; ?>	