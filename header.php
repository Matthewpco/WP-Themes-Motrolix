<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- conditional title -->
  <?php global $combo_cats_names; ?>
  <?php if (is_page('combo-categories')): ?>
    <title><?php echo implode(' ', $combo_cats_names) ?> News, Info, Gossip & More | GM Authority</title>
  <?php else: ?>
    <title><?php wp_title(''); ?></title>
  <?php endif; ?>
  <!-- output for combo categories meta -->
  <?php if (is_page('combo-categories')): ?>
    <meta name="description" content="See <?php echo implode(' ', $combo_cats_names) ?> News, Info, Gossip & More">
  <?php endif; ?>
	<script src="/blog/sysmenu.min.js"></script>
	<script>
		MicroModal.init();
		//MicroModal.show('modal-1');
	</script>
	<script>
		// This function returns a normalized screen size to match the TypeGrid theme.
		function get_ad_size($position) {
			var $adsense_helper = 'src="https://pagead2.googlesyndication.com/pagead/show_ads.js"';
			switch($position) {
			// AB testing for responsive
				case "header-logo-center_ab":
					// Logo area in header.  Disappears when size is less then 700 via CSS
					var $width = window.innerWidth || document.documentElement.clientWidth;
					//var $switcher = (new Date().getTime() % 2);
					var $switcher = 1;
					//alert($switcher);
					if ( $switcher == 0 ) { // Non Responsive Ad
						if ($width >= 1050 ) { return '<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-7194783345442697" data-ad-slot="4873542961"></ins>'; }
						else if ($width >= 800 ) { return '<ins class="adsbygoogle" style="display:inline-block;width:468px;height:60px" data-ad-client="ca-pub-7194783345442697" data-ad-slot="4811202363"></ins>'; }
						else { return ''; }
					} else {				// Responsive Ad
						if ($width >= 800 ) { return '<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7194783345442697" data-ad-slot="2505235180" data-ad-format="auto" data-full-width-responsive="true"></ins>'; }
						else { return ''; }
					}
					break;
					/* The logo-center and bottom-center work together.  When the page is too small for the header,
					it drops down under the second nav bar.
					The actual display code for these ad locations are in this file (header.php) */
				case "header-logo-center":
					// Logo area in header.  Disappears when size is less then 700 via CSS
					var $width = window.innerWidth || document.documentElement.clientWidth;
					if ($width >= 1050 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "4873542961";  google_ad_width = 728;  google_ad_height = 90;', $adsense_helper]; }
					else if ($width >= 800 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "4811202363";  google_ad_width = 468;  google_ad_height = 60;', $adsense_helper]; }
					else { return ['','']; }
					break;
					/* The home-featured and below-image-center displays an ad below the featured articles on the home page,
					as well as an ad below the featured article on a post. */
				case "home-featured":
				case "intelligence-content":	// Ad code is located in page-templates/intelligence.php
				case "below-image-center":
					// Area under featured articles on home page and below article on single
					var $addiv = document.getElementById("featured-image-wrapper").clientWidth;
					if ($addiv >= 720 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "5181557166";  google_ad_width = 728;  google_ad_height = 90;', $adsense_helper]; }
					else if ($addiv >= 328 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "3401280366";  google_ad_width = 336;  google_ad_height = 280;', $adsense_helper]; }
					else if ($addiv < 328 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "2242304768";  google_ad_width = 300;  google_ad_height = 250;', $adsense_helper]; }
					else { return ['','']; }
					break;
				case "below-content":	// Ad placed below content in article, after 1st article on home page
				case "header-replace-center":
					// Below article in single and after 1st article on home.  Only appears when size is less than 700 via CSS
					var $width = window.innerWidth || document.documentElement.clientWidth;
					if ($width >= 728 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "3411313564";  google_ad_width = 728;  google_ad_height = 90;', $adsense_helper]; }
					else if ($width < 728 && $width >= 336 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "3401280366";  google_ad_width = 336;  google_ad_height = 280;', $adsense_helper]; }
					else if ($width < 336 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "2242304768";  google_ad_width = 300;  google_ad_height = 250;', $adsense_helper]; }
					else { return ['','']; }
					break;
				case "home-loop":
				case "comments":
				case "footer":
					// Every 4 articles on home page
					var $addiv = document.getElementById("ads-content-wrapper").clientWidth;
					if ($addiv >= 720 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "5181557166";  google_ad_width = 728;  google_ad_height = 90;', $adsense_helper]; }
					else if ($addiv >= 328 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "3401280366";  google_ad_width = 336;  google_ad_height = 280;', $adsense_helper]; }
					else if ($addiv < 328 ) { return ['google_ad_client = "ca-pub-7194783345442697";  google_ad_slot = "2242304768";  google_ad_width = 300;  google_ad_height = 250;', $adsense_helper]; }
					else { return ['','']; }
					break;
				}
			}
	</script>
<script>
  (function() {
    var useSSL = 'https:' == document.location.protocol;
    var src = (useSSL ? 'https:' : 'http:') +
        '//www.googletagservices.com/tag/js/gpt.js';
    document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
  })();
</script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-7194783345442697",
    enable_page_level_ads: true
  });
</script>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic|Fjalla+One' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
		<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/ie/selectivizr.js"></script>
	<![endif]-->
		<?php wp_head(); ?>
	<!-- User Heat Tag -->
<script type="text/javascript">
(function(add, cla){window['UserHeatTag']=cla;window[cla]=window[cla]||function(){(window[cla].q=window[cla].q||[]).push(arguments)},window[cla].l=1*new Date();var ul=document.createElement('script');var tag = document.getElementsByTagName('script')[0];ul.async=1;ul.src=add;tag.parentNode.insertBefore(ul,tag);})('//uh.nakanohito.jp/uhj2/uh.js', '_uhtracker');_uhtracker({id:'uhVV1kPl54'});
</script>
	<!-- End User Heat Tag -->
</head>
<body <?php body_class(); ?>>
<?php echo wpb_page_background_image(); ?>
<div class="body-wrapper">
	<header id="header">
		<?php if ( has_nav_menu( 'header' ) ): ?>
			<nav class="nav-container group mtmb-fixed" id="nav-header">
				<div class="container">
					<?php echo mtmb_get_searchbox().mtmb_get_menu_to_insert(); ?>
					<div class="nav-toggle" id="nav-header-toggle"><i class="icon-reorder"></i></div>
					<div class="nav-wrap">
						<?php wp_nav_menu( array('theme_location'=>'header','menu_class'=>'nav container group','container'=>'','menu_id'=>'','fallback_cb'=>FALSE) ); ?>
					</div>
				</div>
			</nav><!--/#nav-header-->
		<?php endif; ?>
		<div class="container">
			<div id="header-logo-wrapper"><!--/.logo-header-->
				<div id="header-logo-container-left">
					<?php echo wpb_site_name(); ?>
				</div>
				<div id="header-logo-container-center">
				<h3>Sponsored Links</h3>
					<?php if (1==1) { ?>
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<script>var ad_data = get_ad_size('header-logo-center_ab');
						// Line 167 and 168 were added to replace the parser blocking document.write function on 169
						var d1 = document.getElementById('header-logo-container-center');
						d1.insertAdjacentHTML('beforeend', ad_data)
						//	document.write(ad_data);
						</script>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					<?php } ?>
				</div>
				<div id="header-logo-container-right">
					<?php echo wpb_social_media_links(array('id'=>'header-social','class'=>'social-module')); ?>
				</div>
			</div><!--/.logo-header-->
			<?php if ( is_home() || is_single() || is_archive() ) get_template_part('partials/newsflash'); ?>
			<?php if ( has_nav_menu( 'subheader' ) ): ?>
				<nav class="nav-container group" id="nav-subheader">
					<div class="nav-toggle" id="nav-subheader-toggle"><i class="icon-reorder"></i></div>
					<div class="nav-wrap">
						<?php wp_nav_menu( array('theme_location'=>'subheader','menu_class'=>'nav container group','container'=>'','menu_id'=>'','fallback_cb'=>FALSE) ); ?>
					</div>
				</nav><!--/#nav-subheader-->
			<?php endif; ?>
		</div><!--/.container-->
	</header><!--/#header-->
	<!-- Protect modal -->
	<style>
	.modal[aria-hidden='true'] { display: none; }
	.modal {
	  font-family: -apple-system, BlinkMacSystemFont, avenir next, avenir, helvetica neue, helvetica, ubuntu, roboto, noto, segoe ui, arial, sans-serif;
	  diplay: block!important;
	  style="clear:both;"
	  z-index: 9999;
	  }
	.modal__overlay {
	  position: fixed;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background: rgba(0,0,0,0.85);
	  display: flex!important;
	  justify-content: center;
	  align-items: center;
	  z-index: 9998;
	}
	.modal__container {
	  background-color: #fff;
	  padding: 30px;
	  max-width: 500px;
	  max-height: 100vh;
	  border-radius: 4px;
	  overflow-y: auto;
	  box-sizing: border-box;
	  z-index: 9000;
	}
	.modal__header {
	  display: flex!important;
	  justify-content: space-between;
	  align-items: center;
	  z-index: 9000;
	}
	.modal__title {
	  margin-top: 0;
	  margin-bottom: 0;
	  font-weight: 600;
	  font-size: 1.25rem;
	  line-height: 1.25;
	  color: #00449e;
	  box-sizing: border-box;
	  z-index: 9000;
	}
	.modal__content {
	  margin-top: 2rem;
	  margin-bottom: 2rem;
	  line-height: 1.5;
	  color: rgba(0,0,0,.8);
	  z-index: 9000;
	}
	</style>
	<div class="modal micromodal-bounce" id="modal-1" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1">
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title" aria-describedby="modal-1-content">
				<div role="document">
				<header class="modal__header">
					<h3 class="modal__title" id="modal-1-title">AdBlocker Detected!</h3>
				</header>
				<main class="modal__content" id="modal-1-content">
					<p> We know, advertisements are annoying and slow down the internet. Unfortunately, this is how we pay the bills and our authors.
						We would love for you to enjoy our content, we've worked hard on providing it.  Please whitelist our site in your adblocker, refresh the page, and enjoy!</p>
				</main>
				<footer class="modal__footer">
				</footer>
				</div>
			</div>
		</div>
	</div>
	<div id="page">
		<div class="container">
			<div class="container-inner">
