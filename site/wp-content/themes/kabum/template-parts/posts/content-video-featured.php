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
$url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large')[0];
if ($url != '') {
  $src = get_the_post_thumbnail(get_the_ID());
} else {
  $src = '<img src="https://img.youtube.com/vi/' . get_field('video_kabumTV') . '/maxresdefault.jpg" alt="' . get_the_title() . '">';
}
?>

<div class="videoFeatured item">
  <pre style="display: none;">
<?php echo get_the_post_thumbnail(get_the_ID()) ?>
</pre>
  <div class="video">
    <?php echo $src; ?>
    <!-- button class="link" id="play-button" data-video="<?php the_field('video_kabumTV') ?>"><img src="<?php bloginfo('template_url'); ?>/assets/img/player.svg"></button-->
    <a href="<?php the_permalink(); ?>" class="playLink"><img width="90" height="90" src="<?php bloginfo('template_url'); ?>/assets/img/player.svg" alt="player"></a>
  </div>
  <span class="tag"><?php echo $terms_slug_str; ?></span>
  <?php the_title('<h3>', '</h3>'); ?>
</div>