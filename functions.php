<?php

// Remove a couple columns from the Media Library
add_action('admin_head', 'remove_media_attachement_fields');

function remove_media_attachement_fields() {
  echo '<style>
.setting[data-setting="caption"]
 {
  display: none!important;
}
  </style>';
}

// Tell the WP cURL handle to use TLS 1.2
function lab_http_api_curl($handle) {
    curl_setopt($handle, CURLOPT_SSLVERSION, 6);
}
add_action('http_api_curl', 'lab_http_api_curl', PHP_INT_MAX, 1);

// Remove Gutenburg
add_filter('use_block_editor_for_post', '__return_false', 10);

// Remove smart quotes
// remove_filter(‘the_content’, ‘wptexturize’);
// remove_filter(‘the_title’, ‘wptexturize’);

// Add a custom user role for inputting Salesnumbers
$result = add_role( 'salesnumbers', __(
'Salesnumbers' ),
array( ) );

function add_salesnumber_cap()
{
    $role = get_role('salesnumbers');
    $role->add_cap('read', true);
    $role->add_cap('unfiltered_html', true);
    $role->add_cap('edit_pages', true);
    $role->add_cap('publish_pages', true);
    $role->add_cap('upload_files', true);
    $role->add_cap('edit_published_pages', true);
    $role->add_cap('edit_others_pages', true);



    $role->add_cap('salesnumbers', true);
    $adminrole = get_role('administrator');
    $adminrole->add_cap('salesnumbers', true);


    $editorrole = get_role('editor');
    $editorrole->add_cap('salesnumbers', true);

}
add_action('init', 'add_salesnumber_cap', 11);

// Function to wrap [table= shortcodes so they scroll
if( !function_exists("motrolix_table_styler")){
	function motrolix_table_styler($content){

	// Find [table id=XXX /]
                $table_start=0;
                $table_end=0;
                $last_table_start=0;
                $table_text="";
                $table_text_new="";
                $table_count=0;
                $new_content=$content;

                $table_count = substr_count($new_content, '[table id=');

                for ($x=0; $x<$table_count; $x++)
                {
                        $table_start = 0; //Start pointer over each iteration

                        $table_start = strpos($new_content, '[table id=', $last_table_start);
						$table_end = strpos($new_content,"]",$table_start);
						$table_text = substr($new_content,$table_start, $table_end-$table_start+1);
						$new_content =str_replace($table_text,"<div style=\"overflow: scroll;\">".$table_text."</div>",$new_content);

                        $last_table_start=$table_end;
                }


		return $new_content;
	}
	add_filter('the_content', 'motrolix_table_styler', 2);
}

/* Add admin bar restrictions */
add_action('init', 'remove_admin_bar');

function remove_admin_bar() {

	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

/* Remove various image types we don't like */
function filter_myme_types($mime_types){
//	$mime_types['avi'] = 'video/avi'; //Adding avi extension
        unset($mime_types['png']);
        unset($mime_types['bmp']);
        unset($mime_types['tiff']);
        unset($mime_types['psd']);
        return $mime_types;
}

add_filter('upload_mimes', 'filter_myme_types', 1, 1);


/* Add featured image thumbnail to RSS feeds */
function add_featured_image_to_feed($content) {
	global $post;
	if ( has_post_thumbnail( $post->ID ) ){
		$content = '' . get_the_post_thumbnail( $post->ID, 'size-thumbnail-small' ) . '<br/>' . $content;
	}
	return $content;
}

add_filter('the_excerpt_rss', 'add_featured_image_to_feed', 1000, 1);
add_filter('the_content_feed', 'add_featured_image_to_feed', 1000, 1);

/* Remove Tags */
add_action('init', 'remove_tags');
function remove_tags(){
    register_taxonomy('post_tag', array());
}

/**
 * Fetch related posts as an array.
 * @return array Array of Post IDs
 */
function get_crp_posts($postid = FALSE, $limit = FALSE, $strict_limit = TRUE) {
	global $wpdb, $post, $single;

	$post = (empty($postid)) ? get_post($postid) : $post;

	// Make sure the post is not from the future
	$time_difference = get_option('gmt_offset');
	$now = gmdate("Y-m-d H:i:s",(time()+($time_difference*3600)));

	$stuff = addslashes($post->post_title);

	// Limit the related posts by time
	$current_date = strtotime ( '-120 DAY' , strtotime ( $now ) );
	$current_date = date ( 'Y-m-d H:i:s' , $current_date );

	// Create the SQL query to fetch the related posts from the database
	if ((is_int($post->ID))&&($stuff != '')) {
		$sql = "SELECT DISTINCT ID "
		. " FROM ".$wpdb->posts." WHERE "
		. "MATCH (post_title) AGAINST ('".$stuff."') "
		. "AND post_date <= '".$now."' "
		. "AND post_date >= '".$current_date."' "
		. "AND post_status = 'publish' "
		. "AND post_type = 'post' "
		. "AND ID != ".$post->ID." ";
		$sql .= "LIMIT 3";
		$results = $wpdb->get_results($sql);
	} else {
		$results = false;
	}

	$related_ids = array();
	foreach ($results as $result) {
		$related_ids[] = $result->ID;
	}

	return $related_ids;
}

register_sidebar(array(
	'id'			=> 'widget-bottom_article',
	'name'			=> 'Bottom of Article',
	'before_widget'	=> '<li id="%1$s" class="widget %2$s">',
	'after_widget'	=> '</li>',
	'before_title'	=> '<h3 class="widget-title fix"><span>',
	'after_title'	=> '</span></h3>',
));

register_sidebar(array(
	'id'			=> 'widget-top_article',
	'name'			=> 'Top of Article',
	'before_widget'	=> '<li id="%1$s" class="widget %2$s">',
	'after_widget'	=> '</li>',
	'before_title'	=> '<h3 class="widget-title fix"><span>',
	'after_title'	=> '</span></h3>',
));

// The following function fixes the shortcode button  missing after 3.9.1 WP update.

function shortcode_add_mce_button()
{
if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) )   // check user permissions
{
return;
}

if ( 'true' == get_user_option( 'rich_editing' ) ) // WYSIWYG enabled?
{
add_filter( 'mce_external_plugins', 'shortcode_add_tinymce_plugin' );
add_filter( 'mce_buttons', 'shortcode_register_mce_button' );
}
}
add_action('admin_head', 'shortcode_add_mce_button');

function shortcode_add_tinymce_plugin( $plugin_array ) // script for the new button
{
$plugin_array['shortcode_mce_button'] = get_stylesheet_directory_uri() .'/js/shortcode-button.js';
return $plugin_array;
}

function shortcode_register_mce_button( $buttons ) // register the new button
{
array_push( $buttons, 'shortcode_mce_button' );
return $buttons;
}

/* Functions taken from AJ Clarke: http://www.wpexplorer.com/wordpress-tinymce-tweaks/ */

// Fix the bbPress Forum page SEO title and description
// https://wordpress.org/support/topic/bbpress-forums-and-topics-archive-no-title-no-description
/*
add_filter( 'aioseop_title', 'freewpress_fix_titles' );
function freewpress_fix_titles( $title ) {
    if ( is_post_type_archive() ) {
        global $aiosp;
        $title = $aiosp->get_original_title() . " | " . get_bloginfo( "name" );
    }
    return $title;
}
*/

add_filter( 'aioseop_title', 'seo_bbpress_forum_title' );
function seo_bbpress_forum_title( $title ) {
        if ( is_post_type_archive( 'forum' ) ) {
                $title = "GM Forum, General Motors Discussions, GM Q&A | GM Authority";
        }
        return $title;
}

add_filter( 'aioseop_description', 'seo_bbpress_forum_description' );
function seo_bbpress_forum_description( $description ) {
        if ( is_post_type_archive( 'forum' ) ) {
		$description = "Browse our GM Forums to discuss General Motors vehicles. Forum topics range from general help and assistance to tips and tricks, and everything in between.";
        }
        return $description;
}

// Update hidden word_count field below with the value from WP editor
add_action( 'admin_footer-post-new.php', 'update_word_count_post' );
add_action( 'admin_footer-post.php', 'update_word_count_post' );


function update_word_count_post() {
    if ( 'post' !== $GLOBALS['post_type'] )
        return;
    ?>
    <script>
	document.getElementById("publish").onclick = function() {
		var word_count = document.getElementById("wp-word-count").getElementsByClassName("word-count")[0].textContent;
		document.getElementById("hidden_word_count").value = word_count;
    	//alert( word_count );

	}
	</script>
    <?php
}


// Add a couple custom fields to posts
add_action( 'add_meta_boxes', 'display_post_fields' );
        function display_post_fields() {
                add_meta_box( 'editor', 'Post Admins', 'display_editor', 'post', 'side', 'high' );
                add_meta_box( 'editor', 'Post Admins', 'display_editor', 'page', 'side', 'high' );
                }

            function display_editor( $post ) {
            	$editors = array_merge( get_users('role=administrator'), get_users('role=editor') );
            	$transcribers = array_merge( get_users('role=administrator'), get_users('role=editor') );

		     	// Sort the multidimensional array
     			function cmp($a, $b){
					if ($a->display_name == $b->display_name) {
						return 0;
					}
					return ($a->display_name > $b->display_name) ? 1 : -1;
				}

				usort($editors, 'cmp');
				usort($transcribers, 'cmp');

 				// Find Current Editor and Social Author
                $current_editor = get_post_meta( $post->ID, 'editor', true);
                $current_social = get_post_meta( $post->ID, 'social_author', true);
                $current_transcriber = get_post_meta( $post->ID, 'transcriber', true);
                $current_type = get_post_meta( $post->ID, 'post_type', true);
                $current_proofer = get_post_meta( $post->ID, 'proofer', true);
                ?>
                <table class="form-table">
                <tbody><tr><th>
                <label>Post Type</label>
                </th>
                <td><select name="content_type">
                	<option value="null" selected>None</option>
                	<option value="news" <?php echo $current_type == "news" ? "selected" : "";?>>News</option>
                	<option value="content" <?php echo $current_type == "content" ? "selected" : "";?>>Special Content</option>
                	<option value="deep" <?php echo $current_type == "deep" ? "selected" : "";?>>Deep Dive</option>
                	<option value="field" <?php echo $current_type == "field" ? "selected" : "";?>>Field Assignment </option>
                	<option value="review" <?php echo $current_type == "review" ? "selected" : "";?>>Review</option>
                	<option value="research" <?php echo $current_type == "research" ? "selected" : "";?>>Research</option>
                <select></td></tr>
                <tr><th>
                <label>Editor</label>
                </th>
                <td><select name="custom_editor"><option value="null" selected>None</option>
                <?php
                	foreach ($editors as $editor) {
                	$editor_selected = $editor->ID == $current_editor ? "selected" : "";
                	echo '<option value="'.$editor->ID.'" '.$editor_selected.'>'.$editor->display_name.'</option>';
                }
                ?><select></td></tr>
                <tr><th>
                <label>Social</label>
                </th>
                <td><select name="social_author"><option value="null" selected>None</option>
                <?php
                	foreach ($editors as $editor) {
                	$social_selected = $editor->ID == $current_social ? "selected" : "";
                	echo '<option value="'.$editor->ID.'" '.$social_selected.'>'.$editor->display_name.'</option>';
                }
                ?><select>
                </td></tr>
                <tr><th>
                <label>Transcriber</label>
                </th>
                <td><select name="transcriber"><option value="null" selected>None</option>
                <?php
                	foreach ($transcribers as $transcriber) {
                	$transcriber_selected = $transcriber->ID == $current_transcriber ? "selected" : "";
                	echo '<option value="'.$transcriber->ID.'" '.$transcriber_selected.'>'.$transcriber->display_name.'</option>';
                }
                ?><select>
                </td></tr>
                <tr><th>
                <label>Proof Reader</label>
                </th>
                <td><select name="proofer"><option value="null" selected>None</option>
                <?php
                	$proofer_selected = 51241 == $current_proofer ? "selected" : "";
                	echo '<option value="51241" '.$proofer_selected.'>Michelle Marus</option>';
                ?><select>
                </td></tr>

                </tbody>
                <input type="hidden" value="" name="hidden_word_count" id="hidden_word_count"></table>
                <?php

        }

// Save custom fields data
add_action( 'save_post', 'save_post_fields' );
        function save_post_fields( $post_ID ) {
            global $post;
            if( $post->post_type == "post" || $post->post_type == "page" ) {
            if (isset( $_POST ) ) {
                update_post_meta( $post_ID, 'editor', strip_tags( $_POST['custom_editor'] ) );
                update_post_meta( $post_ID, 'social_author', strip_tags( $_POST['social_author'] ) );
                update_post_meta( $post_ID, 'transcriber', strip_tags( $_POST['transcriber'] ) );
                update_post_meta( $post_ID, 'post_type', strip_tags( $_POST['content_type'] ) );
                update_post_meta( $post_ID, 'proofer', strip_tags( $_POST['proofer'] ) );
                update_post_meta( $post_ID, 'word_count', strip_tags( $_POST['hidden_word_count'] ) );
            }
        }
}

// Remove the normal custom fields box
function remove_post_custom_fields() {
	remove_meta_box( 'postcustom' , 'post' , 'normal' );
}
add_action( 'admin_menu' , 'remove_post_custom_fields' );


// Add Editor Column
add_filter('manage_posts_columns', 'admin_columns2');
function admin_columns2($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='categories')
      $new['editor'] = 'Editor';
    $new[$key] = $title;
  }
  return $new;
}

add_filter('manage_pages_columns', 'admin_columns3');
function admin_columns3($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='date')
      $new['editor'] = 'Editor';
    $new[$key] = $title;
  }
  return $new;
}

// Retrieve Editor Data
add_action('manage_posts_custom_column',  'admin_show_columns2');
add_action('manage_pages_custom_column',  'admin_show_columns2');
function admin_show_columns2($name) {
    global $post;
    switch ($name) {
        case 'editor':
            $views = get_userdata(get_post_meta($post->ID, 'editor', true))->display_name;
            echo $views;
    }
}

// Add Social Author Column
add_filter('manage_posts_columns', 'admin_columns1');
function admin_columns1($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='categories')
      $new['social_author'] = 'Social Author';
    $new[$key] = $title;
  }
  return $new;
}

// Retrieve Social Author Data
add_action('manage_posts_custom_column',  'admin_show_columns1');
function admin_show_columns1($name) {
    global $post;
    switch ($name) {
        case 'social_author':
            $views = get_userdata(get_post_meta($post->ID, 'social_author', true))->display_name;
            echo $views;
    }
}

// Add Proofer Column
add_filter('manage_posts_columns', 'admin_columns4');
function admin_columns4($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='categories')
      $new['proofer'] = 'Proofer';
    $new[$key] = $title;
  }
  return $new;
}

// Retrieve Social Author Data
add_action('manage_posts_custom_column',  'admin_show_columns4');
function admin_show_columns4($name) {
    global $post;
    switch ($name) {
        case 'proofer':
            $views = get_userdata(get_post_meta($post->ID, 'proofer', true))->display_name;
            echo $views;
    }
}


// Disable search
function motrolix_filter_query( $query, $error = true ) {

	if ( is_search() && !is_admin()) {
		$query->is_search = false;
		$query->query_vars[s] = false;
		$query->query[s] = false;

		// to error
		if ( $error == false )
			$query->is_404 = true;
	}
}

//add_action( 'parse_query', 'motrolix_filter_query' );
//add_filter( 'get_search_form', create_function( '$a', "return null;" ) );

/**
 * Don't count pingbacks or trackbacks when determining
 * the number of comments on a post.
 */
function comment_count( $count ) {
	global $id;
	$comment_count = 0;
	$comments = get_approved_comments( $id );
	foreach ( $comments as $comment ) {
		if ( $comment->comment_type === '' ) {
			$comment_count++;
		}
	}
	return $comment_count;
}

add_filter( 'get_comments_number', 'comment_count', 0 );


class Walker_Comment_Custom extends Walker_Comment {

	protected function comment( $comment, $depth, $args ) {

		//$is_gold = !pmpro_hasMembershipLevel('1', get_comment($comment->comment_ID)->user_id) ? true: false;
		$is_gold = false;
		//$comment_user_id = get_userdata($comment->user_id);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
			<?php //echo get_userdata($comment->user_id); ?>
			<?php if( $is_gold) { ?>
				<i class="icon-star" style="color: gold;"></i>


			<?php } ?>
		</div>
		<?php if ( '0' == $comment->comment_approved ) : ?>
		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
		<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '&nbsp;&nbsp;', '' );
			?>
		</div>
		<?php if ( $is_gold) { ?>
		<div style="font-weight: bold !important; color: black !important;">
		<?php
		}

		comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );

		if ( $is_gold) { ?>
		</div>
		<?php }

		comment_reply_link( array_merge( $args, array(
			'add_below' => $add_below,
			'depth'     => $depth,
			'max_depth' => $args['max_depth'],
			'before'    => '<div class="reply">',
			'after'     => '</div>'
		) ) );
		?>

		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
	}
}

// Remove sticky posts from homepage main query

add_action( 'pre_get_posts', 'motrolix_remove_stickies_from_main_query' );

function motrolix_remove_stickies_from_main_query () {
  if (is_home() || is_front_page() ) {
    global $wp_query;
    $stickies = get_option( 'sticky_posts' );
    $wp_query->set('ignore_sticky_posts', '1');
    $wp_query->set('post__not_in', $stickies);
  }
}

function motrolix_category_create_custom_fields() {
  wp_enqueue_media();
  mtrlx_category_custom_fields_init_script();
?>
  <div class='form-field'>
    <th scope='row'><label for='mtrlx_is_sticky'><?php _e('Stick to Home Page'); ?></label></th>
    <td>
        <input id="mtrlx_is_sticky" type="checkbox" value="1" name="mtrlx_is_sticky" />
    </td>
  </div>
  <div class='form-field' id="mtrlx_sticky_title_block" style="display:none;">
    <th scope='row'><label for='mtrlx_sticky_title'><?php _e('Sticky Title'); ?></label></th>
    <td>
        <input id="mtrlx_sticky_title" type="text" value="" name="mtrlx_sticky_title" style="width:95%" />
        <p class="description">You can supply a title specifically for the homepage; if you leave this field blank, the category's name will appear there.</p>
    </td>
  </div>
  <div class="form-field" id="mtrlx_sticky_image_block" style="display:none;">
    <th scope='row'><label for='mtrlx_sticky_image_id'><?php _e('Sticky image') ?></label></th>
    <td>
      <input type="hidden" id="mtrlx_sticky_image_id" name="mtrlx_sticky_image_id" class="custom_media_url" value="">
     <div id="mtrlx_sticky_image_wrapper">
     </div>
     <p>
       <input type="button" class="button button-secondary mtrlx_tax_media_button" id="mtrlx_tax_media_button" name="mtrlx_tax_media_button" value="<?php _e( 'Add Image' ); ?>" />
       <input type="button" class="button button-secondary mtrlx_tax_media_remove" id="mtrlx_tax_media_remove" name="mtrlx_tax_media_remove" value="<?php _e( 'Remove Image' ); ?>" />
     </p>
    </td>
  </div>
<?php
}

function motrolix_category_update_custom_fields( $term ) {
  wp_enqueue_media();
  mtrlx_category_custom_fields_init_script();
  $mtrlx_is_sticky_val = get_term_meta($term->term_id, '_mtrlx_is_sticky', true);
  $mtrlx_sticky_title = get_term_meta($term->term_id, '_mtrlx_sticky_title', true);
  $mtrlx_sticky_image_id_val = get_term_meta($term->term_id, '_mtrlx_sticky_image_id', true);
?>
  <tr class="form-field">
    <th scope='row'><label for='mtrlx_is_sticky'><?php _e('Stick to Home Page'); ?></label></th>
    <td>
        <input id="mtrlx_is_sticky" type="checkbox" value="1" <?php checked($mtrlx_is_sticky_val, true, true); ?> name="mtrlx_is_sticky" />
    </td>
  </tr>
  <tr class='form-field' id="mtrlx_sticky_title_block" <?php echo !$mtrlx_is_sticky_val ? 'style="display: none"' : '' ?>>
    <th scope='row'><label for='mtrlx_sticky_title'><?php _e('Sticky Title'); ?></label></th>
    <td>
        <input id="mtrlx_sticky_title" type="text" value="<?php echo $mtrlx_sticky_title ?>" name="mtrlx_sticky_title" />
        <p class="description">You can supply a title specifically for the homepage; if you leave this field blank, the category's name will appear there.</p>
    </td>
  </tr>
  <tr class="form-field" id="mtrlx_sticky_image_block" <?php echo !$mtrlx_is_sticky_val ? 'style="display: none"' : '' ?>>
    <th scope='row'><label for='mtrlx_sticky_image_id'><?php _e('Sticky image') ?></label></th>
    <td>
      <input type="hidden" id="mtrlx_sticky_image_id" name="mtrlx_sticky_image_id" class="custom_media_url" value="<?php echo $mtrlx_sticky_image_id_val ? $mtrlx_sticky_image_id_val : '' ?>">
     <div id="mtrlx_sticky_image_wrapper">
       <?php
          if ( $mtrlx_sticky_image_id_val ) {
            echo wp_get_attachment_image ( $mtrlx_sticky_image_id_val, 'thumbnail' );
          }
       ?>
     </div>
     <p>
       <input type="button" class="button button-secondary mtrlx_tax_media_button" id="mtrlx_tax_media_button" name="mtrlx_tax_media_button" value="<?php _e( 'Add Image' ); ?>" />
       <input type="button" class="button button-secondary mtrlx_tax_media_remove" id="mtrlx_tax_media_remove" name="mtrlx_tax_media_remove" value="<?php _e( 'Remove Image' ); ?>" />
    </p>
    </td>
  </tr>
<?php
}

if( current_user_can('editor') || current_user_can('administrator') || is_super_admin() ) {
  add_action( 'create_category', 'motrolix_category_updated_category_image' );
  add_action( 'edit_category', 'motrolix_category_updated_category_image' );
  add_action( 'category_add_form_fields', 'motrolix_category_create_custom_fields' );
  add_action( 'category_edit_form_fields', 'motrolix_category_update_custom_fields' );
}

function motrolix_category_created_category_image ( $term_id ) {
  // if "sticky is checked"
  if( isset( $_POST['mtrlx_is_sticky'] ) ){
    // first, ensure that an image has been selected
    if( isset( $_POST['mtrlx_sticky_image_id']) && $_POST['mtrlx_sticky_image_id'] != '' ){
      $image_id = $_POST['mtrlx_sticky_image_id'];
      $sticky_title = filter_var($_POST['mtrlx_sticky_title'], FILTER_SANITIZE_STRING);
      // update all fields
      update_term_meta ( $term_id, '_mtrlx_is_sticky', '1' );
      update_term_meta ( $term_id, '_mtrlx_sticky_title', $sticky_title );
      update_term_meta ( $term_id, '_mtrlx_sticky_image_id', $image_id );
    } else {
      // otherwise, produce an error
      add_settings_error(
        'mtrlx-no-sticky-image-selected',
        '',
        'You must select an image for a sticky post',
        'error'
      );
      set_transient( 'settings_errors', get_settings_errors(), 30 );
    }
  }
}

function motrolix_category_updated_category_image ( $term_id ) {
  // if "sticky is checked"
  if( isset( $_POST['mtrlx_is_sticky'] ) ){
    // first, ensure that an image has been selected
    if( isset( $_POST['mtrlx_sticky_image_id']) && $_POST['mtrlx_sticky_image_id'] != '' ){
      $image_id = $_POST['mtrlx_sticky_image_id'];
      $sticky_title = filter_var($_POST['mtrlx_sticky_title'], FILTER_SANITIZE_STRING);
      // update all fields
      update_term_meta ( $term_id, '_mtrlx_is_sticky', '1' );
      update_term_meta ( $term_id, '_mtrlx_sticky_image_id', $image_id );
      update_term_meta ( $term_id, '_mtrlx_sticky_title', $sticky_title );
    } else {
      // otherwise, produce an error
      add_settings_error(
        'mtrlx-no-sticky-image-selected',
        '',
        'You must select an image for a sticky post',
        'error'
      );
      set_transient( 'settings_errors', get_settings_errors(), 30 );
    }
  } else {
    update_term_meta ( $term_id, '_mtrlx_is_sticky', '0' );
    update_term_meta ( $term_id, '_mtrlx_sticky_image_id', '' );
  }
}

function mtrlx_category_custom_fields_init_script () {
?>
  <script>
    jQuery(document).ready( function($) {
        function ct_media_upload(button_class) {
          var _custom_media = true,
          _orig_send_attachment = wp.media.editor.send.attachment;
          $('body').on('click', button_class, function(e) {
            var button_id = '#'+$(this).attr('id');
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
              if ( _custom_media ) {
                $('#mtrlx_sticky_image_id').val(attachment.id).trigger('change');
                $('#mtrlx_sticky_image_wrapper').html('<img class="mtrlx_custom_media_image" src="" style="margin:0;padding:0;max-height:150px;width:150px;float:none;" />');
                $('#mtrlx_sticky_image_wrapper .mtrlx_custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
              } else {
                return _orig_send_attachment.apply( button_id, [props, attachment] );
              }
             }
          wp.media.editor.open(button);
          return false;
        });
      }
      ct_media_upload('.mtrlx_tax_media_button.button');
      $('body').on('click','.mtrlx_tax_media_remove',function(){
        $('#mtrlx_sticky_image_id').val('');
        $('#mtrlx_sticky_image_wrapper').html('<img class="mtrlx_custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
      });
      $('body').on('click', 'input[type=submit]', function(e) {
        if ($('#mtrlx_is_sticky').prop('checked')) {
          if ($('#mtrlx_sticky_image_id').val() == '') {
            e.preventDefault();
            e.stopPropagation();
            return false;
            $('.notice-success').remove();
            $('h1:first-of-type').after('<div class="error"><p>You must select an image for a sticky post</p></div>');
            $("html, body").animate({ scrollTop: 0 }, 'fast');
          }
        }
      })
      $('body').on('change', '#mtrlx_is_sticky', function() {
        if ($(this).prop('checked')) {
          $('#mtrlx_sticky_image_block').css('display', 'table-row');
          $('#mtrlx_sticky_title_block').css('display', 'table-row');
          if ($('#mtrlx_sticky_image_id').val() == '') {
            $('input[type=submit]').prop('disabled', true);
          }
        } else {
          $('#mtrlx_sticky_image_block').css('display', ' none');
          $('#mtrlx_sticky_title_block').css('display', 'none');
          $('input[type=submit]').prop('disabled', false);
        }
      })
      $('body').on('change', '#mtrlx_sticky_image_id', function () {
        console.log('fired');
        if ($(this).val() == '' && $('#mtrlx_is_sticky').prop('checked')) {
          $('input[type=submit]').prop('disabled', true);
        } else {
          console.log('its the else');
          $('input[type=submit]').prop('disabled', false);
        }
      })
      $(document).ajaxComplete(function(event, xhr, settings) {
        var queryStringArr = settings.data.split('&');
        if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
          var xml = xhr.responseXML;
          $response = $(xml).find('term_id').text();
          if($response!=""){
            // Clear the thumb image
            $('#mtrlx_sticky_image_wrapper').html('');
          }
        }
      });
    });
  </script>
<?php
}

add_action('admin_notices', 'motrolix_theme_admin_error_messages');

function motrolix_theme_admin_error_messages () {
  if ( ! ( $errors = get_transient( 'settings_errors' ) ) ) {
    return;
  }
  foreach ( $errors as $error ) {
    echo '<div class="error"><p>' . $error['message'] . '</p></div>';
  }
  delete_transient( 'settings_errors' );
  remove_action( 'admin_notices', 'motrolix_theme_admin_error_messages' );
}

/* Submit email via sign-up form */
wp_enqueue_script( 'mtrlx-inline-sign-up-form', get_stylesheet_directory_uri() . '/js/MTRLX-inline-sign-up-form.js', array('jquery'), '1.0.0' );

  wp_localize_script( 'mtrlx-inline-sign-up-form', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
add_action("wp_ajax_mtrlx_inline_sign_up_form_process", "mtrlx_inline_sign_up_form_process");
add_action("wp_ajax_mtrlx_inline_sign_up_form_process", "mtrlx_inline_sign_up_form_process");

function mtrlx_inline_sign_up_form_process() {
  $result = array();
  if ( !wp_verify_nonce( $_REQUEST['nonce'], "mtrlx_inline_sign_up_form_nonce")) {
    $result['failure'] = true;
    $result['status'] = 'Nonce not valid';
    $result = json_encode($result);
    echo $result;
    die();
  }
  $key = MTRLX_INLINE_MAILCHIMP_KEY;
  $aud_id = MTRLX_INLINE_MAILCHIMP_AUD_ID;
  $region = explode('-', $key)[1];
  $post_data = array(
    "email_address" => $_REQUEST["email"],
    "status" => "subscribed",
    "merge_fields" => array(
      "FNAME"=> $_REQUEST["first_name"],
      "LNAME"=> $_REQUEST["last_name"]
    )
  );
  $ch = curl_init('https://' . $region . '.api.mailchimp.com/3.0/lists/'.$aud_id.'/members/');
  curl_setopt_array($ch, array(
      CURLOPT_POST => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HTTPHEADER => array(
          'Authorization: apikey '. $key,
          'Content-Type: application/json'
      ),
      CURLOPT_POSTFIELDS => json_encode($post_data)
  ));
  // Send the request
  $response = curl_exec($ch);
  $response = json_decode($response, true);
  if ($response['id'] != null || $response['title'] == 'Member Exists') {
    $result['success'] = true;
    $result = json_encode($result);
  } else {
    $result['failure'] = true;
    $result = json_encode($result);
  }
  echo $result;
  die();
}

add_filter('comment_form_default_fields', 'mtrlx_remove_website_field');
function mtrlx_remove_website_field($fields) {
  unset($fields['url']);
  return $fields;
}

add_action('init', 'mtrlx_check_combo_cat_page_is_valid');
function mtrlx_check_combo_cat_page_is_valid() {
  // declare combo categories title global variable
  global $combo_cats_names;
  // return false if our URL doesn't exist
  if (!strpos($_SERVER['REQUEST_URI'], '/combo-categories')) return false;
  // get cat slugs from URL
  $cat_slugs = $_GET['cats'];
  // display 404 page if cats URL param not found
  if (!$cat_slugs && $cat_slugs == null) {
    // add filter and return
    add_filter('the_posts', 'mtrlx_display_404_page');
  }
  $cat_slugs_arr = explode(',', $cat_slugs);
  $cats = array();
  $any_false = false;
  // query categories
  $combo_cats_names = array();
  foreach ($cat_slugs_arr as $key => $cat_slug) {
    $cats[$key] = get_category_by_slug($cat_slug);
    // throw false flag if any of our category slugs isn't valid
    if ($cats[$key] == false) {
      $any_false = true;
      break;
    }
    // throw in combo cats names array
    array_push($combo_cats_names, $cats[$key]->name);
  }
  // display 404 page if any_false flag was tripped
  if ($any_false) {
    // add filter and return
    add_filter('the_posts', 'mtrlx_display_404_page');
  }
}

// this function will display a blank page by clearing the global posts object
function mtrlx_display_404_page($posts) {
  $posts = array();
  return $posts;
}

// shortcode for combo categories
add_shortcode('mtxcg_posts', 'mtxcg_process_shortcode');

function mtxcg_process_shortcode($atts = array()) {
  global $wp_query;
  extract( shortcode_atts( array(), $atts ) );
  $cat_slugs = $atts['cats'];
  // immediately return error if no cats supplied
  if (!$cat_slugs) {
    return '<div class="mtxcg-feed"><h2>Invalid Combo Category</h2></div>';
  }
  $no_of_posts = (int) $atts['count'];
  $show_more_link = $atts['show-more-posts'] ? true : false;
  $custom_title = $atts['title'] ? $atts['title'] : false;
  // get categories from database
  $cat_slugs_arr = explode(',', $cat_slugs);
  $cats = array();
  $any_false = false;
  // query categories
  foreach ($cat_slugs_arr as $key => $cat_slug) {
    $found_cat = get_category_by_slug($cat_slug);
    $cats[$key] = $found_cat;
    // throw false flag if any of our category slugs isn't valid
    if ($found_cat == false){
       $any_false = true;
       break;
    }
  }
  // immediately return error if any of the categories turns out to be false
  if ($any_false) {
    return '<div class="mtxcg-feed"><h2>Invalid Combo Category</h2></div>';
  }
  //  query
  $wp_query = new WP_Query (
    array (
      'post_type' => 'post',
      'category_name' => implode('+', $cat_slugs_arr),
      'posts_per_page' => $no_of_posts
    )
  );
  // generate title
  $title = '';
  foreach ($cats as $key => $cat) {
    $title.= $cat->name . ' ';
  }
  // echo '<pre>';
  // var_dump($cats);
  // echo '</pre>';
  $title = $custom_title ? $custom_title : trim($title);
  // output content
  ob_start();
  ?>
    <div class="mtxcg-feed">
      <h2 class="mtxcg-feed-title"><?php echo $title ?><?php echo !$atts['title'] ? ' News' : '' ?></h2>
      <?php get_template_part('partials/loop-combo-categories-feed'); ?>
      <?php if($show_more_link): ?>
        <div class="mtxcg-feed-show-more-container">
          <!-- if it's just a single category, link to the real category page -->
          <?php if (count($cats) == 1): ?>
          <a href="<?php echo get_category_link($cats[0]->term_id) ?>">
            <?php echo !$atts['title'] ? 'All ' : '' ?><?php echo $title ?><?php echo !$atts['title'] ? ' News' : '' ?>
          </a>
          <!-- otherwise, link to the combo-categories simulated page -->
          <?php else: ?>
          <a href="<?php echo get_site_url()?>/combo-categories/?cats=<?php echo $cat_slugs ?>">
            <?php echo !$atts['title'] ? 'All ' : '' ?><?php echo $title ?><?php echo !$atts['title'] ? ' News' : '' ?>
          </a>
          <?php endif;?>
        </div>
      <?php endif; ?>
    </div>
  <?php
  wp_reset_query();
  return ob_get_clean();
}

// // redirect from profile
add_filter( 'theme_page_templates', 'child_theme_remove_page_template' );

function child_theme_remove_page_template( $page_templates ) {
  unset( $page_templates['forum.php'] );
  return $page_templates;
}
?>
