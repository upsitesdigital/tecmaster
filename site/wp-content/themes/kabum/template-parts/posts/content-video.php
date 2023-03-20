<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

?>
<?php
$taxonomy = 'categoria_kabumtv';
$terms = get_the_terms($post->ID, $taxonomy);

if ($terms && !is_wp_error($terms)) :
  $tslugs_arr = array();
  foreach ($terms as $term) {
    $tslugs_arr[] = $term->name;
  }
  $terms_slug_str = join(", ", $tslugs_arr);
endif;
$url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail')[0];
if ($url != '') {
  $src = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
} else {
  $src = '<img src="https://img.youtube.com/vi/' . get_field('video_kabumTV') . '/mqdefault.jpg" alt="' . get_the_title() . '">';
}
?>

<a class="item" href="<?php the_permalink(); ?>">
  <div class="videoList">
    <div class="content">
      <span class="tag"><?php echo $terms_slug_str; ?></span>
      <?php the_title('<h3>', '</h3>'); ?>
    </div>
    <div class="video" style="height: auto;">
      <?php echo $src; ?>
    </div>
  </div>
</a>