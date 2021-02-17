<?php
  $querystr = "
    SELECT term_id
    FROM wp_termmeta
    WHERE meta_key = '_mtrlx_is_sticky'
    AND meta_value = '1'
  ";
  $categories = $wpdb->get_results($querystr);
  if (!empty($categories)):
?>
<ul class="entry-sticky-list-group">
  <?php
    foreach ($categories as $category_raw):
    $category_id = $category_raw->term_id;
    $category = get_category($category_id);
    $bg_id = get_term_meta($category_id, '_mtrlx_sticky_image_id', true);
    $sticky_title = get_term_meta($category_id, '_mtrlx_sticky_title', true);
    $bg = wp_get_attachment_image_src($bg_id, 'large');
  ?>
    <li class="entry-sticky-item">
      <article id="entry-category-<?php echo $category_id ?>">
        <a
          href="<?php echo get_category_link($category_id) ?>"
          title="<?php echo $category->name ?>"
          style="background-image:url('<?php echo $bg ? $bg[0] : get_template_directory_uri() . '/img/placeholder.png' ?>')">
          <div class="entry-sticky-item-featured-tag">Hot Topic</div>
        	<div class="entry-sticky-item-inner">
            <div class="entry-sticky-item-title"><?php echo $sticky_title ? $sticky_title : $category->name ?></div>
          </div>
          <div class="entry-sticky-item-cta-tag">See Stories</div>
        </a>
      </article>
    </li>
  <?php endforeach ?>
</ul>
<?php endif ?>
