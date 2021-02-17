<?php
// function to get url variables
function get_url_var($name)
{
    $strURL = $_SERVER['REQUEST_URI'];
    $arrVals = explode("/",$strURL);
    $found = 0;
    foreach ($arrVals as $index => $value)
    {
        if($value == $name) $found = $index;
    }
    // var_dump($arrVals);
    // var_dump($found);
    return ($found == 0) ? 0 : $arrVals[$found + 1];
    return $arrVals[$found + 1];
}
// get cat slugs from URL
$cat_slugs = $_GET['cats'];
if (!$cat_slugs && $cat_slugs == null) return $posts;
$cat_slugs_arr = explode(',', $cat_slugs);
$cats = array();
// query categories
foreach ($cat_slugs_arr as $key => $cat_slug) {
  $cats[$key] = get_category_by_slug($cat_slug);
  // exit immediately if any category is ever not found
  if ($cats[$key] == false) return $posts;
}
// compile (and trim) title
$title = '';
$cats_array_query = array();
foreach ($cats as $key => $cat) {
  $title.= $cat->name;
  if ($cat != end($cats))
      $title.= ' - ';
  array_push($cats_array_query, $cat->slug);
}
// change post title
$post->post_title = trim($title);
$title = trim($title);
// var_dump($post);
//
// var_dump($cats_array_query);
// go ahead and get header
get_header();
?>

<div class="main group <?php echo wpb_option('general-sidebar','sidebar-right'); ?>">
	<div class="content-part">
		<div class="pad group">

      <!-- title -->
      <div class="page-title">
    		<h2><i class="icon-folder-open"></i><?php _e('Categories:','typegrid'); ?> <span><?php echo $title ?></span></h2>
    	</div>	<!-- title -->

      <!-- query -->
      <?php
        global $wp_query, $wp_the_query;
        $ppp = get_option('posts_per_page');
        $wp_query = new WP_Query (
          array (
            'post_type' => 'post',
            'category_name' => implode('+', $cat_slugs_arr),
            'offset' => intval(get_url_var('page')) * $ppp
          )
        )
      ?> <!-- query -->

			<?php
				if ( wpb_option('blog-standard-archive') ) {
					get_template_part('partials/loop-alt'); }
				else {
					get_template_part('partials/loop'); }
			?>

		</div><!--/.pad-->
	</div><!--/.content-part-->

	<div class="sidebar">
		<?php get_sidebar(); ?>
	</div><!--/.sidebar-->

</div><!--/.main-->

<?php get_footer(); ?>
