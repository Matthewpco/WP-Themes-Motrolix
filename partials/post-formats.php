<?php $meta = get_post_custom($post->ID); // Get Post Meta ?>

<?php if ( has_post_format( 'audio' ) ): // Post Format: Audio
	$formats = array();
	foreach ( explode('|','mp3|ogg') as $format ) {
		if ( isset($meta['_audio_'.$format.'_url']) ) {
			$format = ($format=='ogg')?'oga':$format;
			// Change mp3 to m4a if necessary
			if ( $format == 'mp3' ) {
				if ( strstr($meta['_audio_mp3_url'][0],'.m4a') ) {
					$format = 'm4a';
				}
			}
			$formats[] = $format;
		}
	}
	
	$images = wpb_post_images();

	if ( !empty($images) && (1==count($images)) && !has_post_thumbnail() ) {
		$imagesize = wp_get_attachment_image_src($images[0]->ID,'size-format');
		$imagesize['title'] = $images[0]->post_excerpt;
	} elseif ( has_post_thumbnail() ) {
		$img_id = get_post_thumbnail_id();
		$imagesize['title'] = get_post_field('post_excerpt', $img_id);
	}
?>

	<?php if ( !empty($formats) ): ?>
	<script type="text/javascript"> 
	jQuery(document).ready(function(){
		if(jQuery().jPlayer) {
			jQuery("#jquery_jplayer_<?php the_ID(); ?>").jPlayer({
				ready: function () {
					jQuery(this).jPlayer("setMedia", {
						<?php if(in_array('mp3',$formats)) { echo 'mp3: "'.$meta['_audio_mp3_url'][0].'",'."\n"; } ?>
						<?php if(in_array('m4a',$formats)) { echo 'm4a: "'.$meta['_audio_mp3_url'][0].'",'."\n"; } ?>
						<?php if(in_array('oga',$formats)) { echo 'oga: "'.$meta['_audio_ogg_url'][0].'",'."\n"; } ?>
					});
				},
				swfPath: "<?php echo get_template_directory_uri() ?>/js",
				cssSelectorAncestor: "#jp_interface_<?php the_ID(); ?>",
				supplied: "<?php echo implode(',',$formats); ?>"
			});
		}
	});
	</script>
	<?php endif; ?>

	<div class="entry-format">		
		<div class="image-container">
		<?php echo isset($meta['_image_url'][0])?'<a href="'.$meta['_image_url'][0].'">':''; ?>
			<?php if ( has_post_thumbnail() ) { the_post_thumbnail('size-thumbnail-large'); } ?>
			<?php if ( isset($imagesize) && !has_post_thumbnail() ) { echo '<img src="'.$imagesize[0].'" alt="'.$images[0]->post_title.'" >'; } ?>
		<?php echo isset($meta['_image_url'][0])?'</a>':''; ?>
		
		<?php if ( isset($imagesize['title']) && $imagesize['title'] ): ?>
			<div class="flex-caption"><?php echo $imagesize['title']; ?></div>
		<?php endif; ?>
		</div>
		
		<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer"></div>
		<div class="jp-audio">
			<div id="jp_interface_<?php the_ID(); ?>" class="jp-interface">
				<ul class="jp-controls">
					<li><a href="#" class="jp-play" tabindex="1"><i class="icon-play"></i></a></li>
					<li><a href="#" class="jp-pause" tabindex="1"><i class="icon-pause"></i></a></li>
					<li><a href="#" class="jp-mute" tabindex="1"><i class="icon-volume-up"></i></a></li>
					<li><a href="#" class="jp-unmute" tabindex="1"><i class="icon-volume-down"></i></a></li>
				</ul>
				<div class="jp-progress-container">
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
				</div>
				<div class="jp-volume-bar-container">
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>


<?php if ( has_post_format( 'gallery' ) ): // Post Format: Gallery ?>
<?php $images = wpb_post_images(); ?>
	
	<?php if ( !empty($images) ): ?>
	<script type="text/javascript">
		// Specific flexslider code for custom directionNav markup
		jQuery(window).load(function() {
			var $slider = jQuery('.flex-single .flexslider');
			$slider
			.flexslider({
				animation: "fade",
				controlsContainer: ".flex-container",
				slideshow: true,
				directionNav: false,
				controlNav: true,
				pauseOnHover: true,
				slideshowSpeed: 7000,
				animationDuration: 600,
				smoothHeight: true,
				touch: false
			});
			jQuery('.flex-next').click(function($){
				$.preventDefault();
				$slider.flexslider('next');
			});
			jQuery('.flex-prev').click(function($){
				$.preventDefault();
				$slider.flexslider('prev');
			});
			jQuery('.slides').addClass('loaded');
		}); 
	</script>
	<?php endif; ?>

	<div class="entry-format">
		<?php if ( !empty($images) ): ?>
		<div class="flex-container flex-single">
			<div class="flexslider" id="slider-<?php the_ID(); ?>">
				<ul class="slides">
					<?php foreach ( $images as $image ): ?>
						<li>
							<?php $imagesize = wp_get_attachment_image_src($image->ID,'size-format'); ?>
							<img src="<?php echo $imagesize[0]; ?>" alt="<?php echo $image->post_title; ?>">
							
							<?php if ( $image->post_excerpt ): ?>
								<div class="flex-caption"><?php echo $image->post_excerpt; ?></div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php if (count($images) > 1): ?>
				<ul class="flex-direction-nav">
					<li><a href="#" class="flex-prev"><i class="icon-chevron-left"></i></a></li>
					<li><a href="#" class="flex-next"><i class="icon-chevron-right"></i></a></li>
				</ul>
				<?php endif; ?>
			</div>
		</div><!--/.flex-container-->
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php
				// **************************************************************************************************************************//
				// Andrew Froehlich		4/7/2013
				// By default, there is no post format in our posts.
				// This theme only includes the featured image in the article if its of type 'image'
				// We want the image displayed regardles.  We also needed to childize single.php so this would work.
				// get_post_format returns false for posts with no format set (Standard)
				// **************************************************************************************************************************//
?>			
<?php //if ( has_post_format( 'image' ) ): // Post Format: Image ?>
<?php if ( has_post_format( 'image' ) || get_post_format() === false): // Post Format: Image ?>
	<?php $images = wpb_post_images();
		if ( !empty($images) && (1==count($images)) && !has_post_thumbnail() ) {
			$imagesize = wp_get_attachment_image_src($images[0]->ID,'size-thumbnail-large');
			$imagesize['title'] = $images[0]->post_excerpt;
		} elseif ( has_post_thumbnail() ) {
			$img_id = get_post_thumbnail_id();
			$imagesize['title'] = get_post_field('post_excerpt', $img_id);
		}
	?>

	<div class="entry-format">
		<div class="image-container">
			<div id="image-social-single">
			<?php echo isset($meta['_image_url'][0])?'<a href="'.$meta['_image_url'][0].'">':''; ?>
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('size-thumbnail-large'); } ?>
				<?php if ( isset($imagesize) && !has_post_thumbnail() ) { echo '<img src="'.$imagesize[0].'" alt="'.$images[0]->post_title.'" >'; } ?>
			<?php echo isset($meta['_image_url'][0])?'</a>':''; ?>
			
			<?php if ( isset($imagesize['title']) && $imagesize['title'] ): ?>
				<div class="flex-caption"><?php echo $imagesize['title']; ?></div>
			<?php endif; ?>
			</div>
			<?php get_template_part('partials/sharrre'); ?> 		
		</div>
	</div>
	
	
	<div id="featured-image-wrapper"><!--/.ads-header-->
		<div id="featured-image-container">
		<h3>Sponsored Links</h3>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Below Featured -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-7194783345442697"
				 data-ad-slot="7564661180"
				 data-ad-format="auto"
				 data-full-width-responsive="true"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>		
	</div><!--/.ads-header-->
	</br>
<?php endif; ?>

<?php if ( has_post_format( 'video' ) ): // Post Format: Video ?>
	<div class="entry-format">
		<?php 
		if ( isset($meta['_video_url'][0]) && !empty($meta['_video_url'][0]) ) {
			global $wp_embed;
			$video = $wp_embed->run_shortcode('[embed]'.$meta['_video_url'][0].'[/embed]');
			echo "<div class=\"video-container\">".$video."</div><br>";
		} elseif ( isset($meta['_video_embed_code'][0]) && !empty($meta['_video_embed_code'][0]) ) {
			echo "<div class=\"video-container\">".$meta['_video_embed_code'][0]."</div><br>";
		}
		?>
	</div>
	
		<div id="featured-image-wrapper"><!--/.ads-header-->
		<div id="featured-image-container">
		<h3>Sponsored Links</h3>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Below Featured -->
			<ins class="adsbygoogle"
				 style="display:block"
				 data-ad-client="ca-pub-7194783345442697"
				 data-ad-slot="7564661180"
				 data-ad-format="auto"
				 data-full-width-responsive="true"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>		
	</div><!--/.ads-header-->
	</br>
	
<?php endif; ?>

<?php if ( has_post_format( 'quote' ) ): // Post Format: Quote ?>
	<div class="entry-format">
		<div class="quote-bg">
			<i class="icon-quote-right"></i>
			<blockquote>
				<?php echo isset($meta['_quote'][0])?wpautop($meta['_quote'][0]):''; ?>
			</blockquote>
			<p class="quote-author"><?php echo (isset($meta['_quote_author'][0])?'&mdash; '.$meta['_quote_author'][0]:''); ?></p>
		</div>
	</div>
<?php endif; ?>

<?php if ( has_post_format( 'chat' ) ): // Post Format: Chat ?>
	<div class="entry-format">
		<div class="chat-bg">
			<i class="icon-comments-alt"></i>
			<blockquote>
				<?php echo (isset($meta['_chat'][0])?wpautop($meta['_chat'][0]):''); ?>
			</blockquote>
		</div>
	</div>
<?php endif; ?>

<?php if ( has_post_format( 'link' ) ): // Post Format: Link ?>
	<div class="entry-format">
		<p>
			<a href="<?php echo (isset($meta['_link_url'][0])?$meta['_link_url'][0]:'#'); ?>">
				<i class="icon-link"></i>
				<?php echo (isset($meta['_link_title'][0])?$meta['_link_title'][0]:get_the_title()); ?> &rarr;
			</a>
		</p>
	</div>
<?php endif; ?>
