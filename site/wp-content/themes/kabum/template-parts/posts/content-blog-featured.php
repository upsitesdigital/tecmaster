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

$tcolor_arr = (colorPost()[0] !== '') ? colorPost() : ['#FD6519'];
$tslugs_arr = slugPost();
$tnames_arr = (namePost()[0] !== '') ? namePost() : ['KabumTV'];

$image = (get_field('imagem_destacada')['url'] !== null) ? get_field('imagem_destacada')['url'] : wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large')[0];
$imageID = (get_field('imagem_destacada')['url'] !== null) ? get_field('imagem_destacada')['id'] : get_post_thumbnail_id(get_the_ID());

$url = ($image !== null) ? $image : 'https://img.youtube.com/vi/' . get_field('video_kabumTV', get_the_ID()) . '/maxresdefault.jpg';

?>

<div data-id="post-<?php the_ID(); ?>" class="post featured" style="color: <?php echo $tcolor_arr[0] ?>;">
  <a href="<?php the_permalink(); ?>">
    <div class="img">
      <?php
      echo ($image !== null) ? wp_get_attachment_image(attachment_url_to_postid($url), 'full') : '<img src="' . $url . '">';
      ?>
      <!-- img src="<?php echo $url ?>" -->
    </div>
    <div class="content">
      <span><?php echo $tnames_arr[0]; ?></span>
      <?php the_title('<h2>', '</h2>'); ?>
    </div>
  </a>
</div>