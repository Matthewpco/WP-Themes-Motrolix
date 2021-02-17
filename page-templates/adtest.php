<?php
/*
Template Name: AdTest
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
				
				</br>
				
				<?php get_template_part('partials/page-title'); ?>
				
				<div class="text">
					<?php the_content(); ?>
					<div class="clear"></div>
				</div>	
				
				<?php
				// Working example ad
				/*
				<!-- TAG START { player: "Generic Outstream Demo (ad only)", owner: "BeOn", for: "BeOn" } -->
				<div class="vdb_player vdb_568927c7e4b098feda361f34554203dbe4b064656db31e16">
				<script type="text/javascript" src="//delivery.vidible.tv/jsonp/
				pid=568927c7e4b098feda361f34/554203dbe4b064656db31e16.js"></script>
				</div>
				<!-- TAG END { date: 01/03/16 } -->
				*/
				?>
					
				<!-- TAG START { player: "19069-826203-Motrolix Outstream Desktop", owner: "ONE Video by AOL", for: "ONE Video by AOL" - BEINJS } -->
				<div id="57ca4bdfcc52c750f052f4ee" class="vdb_player vdb_57ca4bdfcc52c750f052f4ee56bcd17ce4b018167fea5539">
				<script type="text/javascript" src="//delivery.vidible.tv/jsonp/
				pid=57ca4bdfcc52c750f052f4ee/56bcd17ce4b018167fea5539_bein.js"></script>
				</div><!-- TAG END { date: 09/03/16 } -->
				<?php
					$children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0&depth=5');
					if ($children) { ?>
					<ul>
					</br>
					
					</br>
					<div class="page-title">
						<h1><?php echo wpb_page_title(); ?> Pages</h1>
					</div>
				
					<?php echo $children; ?>
					</ul>
				<?php } ?>
		
			</article>
			</br>
			</br>
			
			<?php if ( air_related_posts::get_option('enable') ) { get_template_part('partials/related-posts'); } ?>
			</br></br>	

	
		</div><!--/.pad-->
	</div><!--/.content-part--> 
	
	<div class="sidebar">	
		<?php get_sidebar(); ?>
	</div><!--/.sidebar-->

</div><!--/.main-->

<?php endwhile; ?>
<?php get_footer(); ?>
