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

$image = (get_field('imagem_destacada')['sizes']['large'] !== null) ? get_field('imagem_destacada')['sizes']['large'] : wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large')[0];

$url = ($image !== null) ? $image : 'https://img.youtube.com/vi/' . get_field('video_kabumTV', get_the_ID()) . '/maxresdefault.jpg';

$filename = $url . '.webp';
$file_headers = @get_headers($filename);
$iff = ($file_headers[0] === 'HTTP/1.1 200 OK') ? 'background-image: -webkit-image-set(url(' . str_replace("uploads", "webp-express/webp-images/uploads", get_field('imagem_destacada')['sizes']['large']) . ') 1x);' : '';

?>
<div data-id="post-<?php the_ID(); ?>" class="post featured" style="color: <?php echo $tcolor_arr[0] ?>;">
  <a href="<?php the_permalink(); ?>">
    <div class="img" style="background-image: url(<?php echo $url ?>); <?php echo $iff ?>">

    </div>
    <div class="content">
      <span><?php echo $tnames_arr[0]; ?></span>
      <?php the_title('<h2>', '</h2>'); ?>
    </div>
  </a>
</div>