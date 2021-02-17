			</div><!--/.container-inner-->
		</div><!--/.container-->
	</div><!--/#page-->
	
	<div class="clear"></div>
	 
	<footer id="footer">
			
		<?php if ( wpb_option('footer-widget-ads') ): ?>
		<div class="ads-footer group">
			<div class="container">
				<div class="grid one-full">
					<ul><?php dynamic_sidebar('widget-ads-footer'); ?></ul>
				</div>
			</div>
		</div><!--/.ads-footer-->
		<?php endif; ?>
			
		<div class="container">
			
			<div id="footer-content" class="pad group">
				
			<div id="ads-content-wrapper"><!--/.ads-header-->
				<div id="ad-content-container">
				<h3 style="color: white;">Sponsored Links</h3>
					<script>var ad_data = get_ad_size('footer');
						document.write('<script type="text/javascript"> ' + ad_data[0] + '<' + '\/script>'); </script>
						<script> document.write('<script type="text/javascript" ' + ad_data[1] + '><' + '\/script>'); </script>		
				</div>	
			</div><!--/.ads-header-->
			
			</div>

			<?php if ( wpb_option('footer-widgets') ): ?>
			<div id="footer-widgets" class="pad group">
				<div class="grid one-third">
					<ul><?php dynamic_sidebar('widget-footer-1'); ?></ul>
				</div>
				<div class="grid one-third">
					<ul><?php dynamic_sidebar('widget-footer-2'); ?></ul>
				</div>
				<div class="grid one-third last">
					<ul><?php dynamic_sidebar('widget-footer-3'); ?></ul>
				</div>
			</div>
			<?php endif; ?>	

		</div><!--/.container--> 
		
		<?php if ( has_nav_menu( 'footer' ) ): ?>
			<nav class="nav-container group" id="nav-footer">
				<div class="nav-toggle" id="nav-footer-toggle"><i class="icon-reorder"></i></div>
				<div class="nav-wrap">
					<?php wp_nav_menu( array('theme_location'=>'footer','menu_class'=>'nav container group','container'=>'','menu_id'=>'','fallback_cb'=>FALSE) ); ?>
				</div>
			</nav><!--/#nav-footer-->
		<?php endif; ?>
		
		<div id="footer-bottom">
			<div class="container">
				<div class="pad group">
					<p id="copyright"><?php echo str_replace("#YEAR#", date("Y"), wpb_footer_text()); ?></p>
					<a id="to-top" href="#"><i class="icon-angle-up"></i></a>
				</div>
			</div>
		</div><!--/#footer-bottom-->
		
	</footer><!--/#footer-->
	
</div><!--/.body-wrapper-->
<?php wp_footer(); ?>
</body>
	<script>
	jQuery(function(){
		if(typeof adsbygoogle.loaded === "undefined" && window.location.href.indexOf("#comment-") < 1) {
			// MicroModal.show('modal-1')
			
			if(typeof(_gaq) != "undefined") {
				_gaq.push(['_trackEvent', 'Revenue', 'Scammers'])
			}
		}
	})
	</script>
</html>
</html>
</html>
