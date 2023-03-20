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
$tcolor_arr = colorPost();
$tslugs_arr = slugPost();
$tnames_arr = namePost();
$US_postcustom_id = get_theme_mod('US_postcustom_id');
$US_postcustom_script = get_theme_mod('US_postcustom_script');

$image = (get_field('imagem_destacada')['url'] !== null) ? get_field('imagem_destacada')['url'] : wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large')[0];

?>

<div data-id="post-<?php the_ID(); ?>" class="post" style="color: <?php echo $tcolor_arr[0] ?>;">
  <?php if (get_the_ID() == $US_postcustom_id && $US_postcustom_id != '' && $US_postcustom_script != '') { ?>
    <div class="img" style="overflow:hidden;">
      <?php echo $US_postcustom_script ?>
    </div>
  <?php } else { ?>
    <a href="<?php the_permalink(); ?>">
      <div class="img">

        <!-- img src="<?php echo get_field('imagem_destacada')['sizes']['thumbnail'] ?>" -->
        <?= wp_get_attachment_image(attachment_url_to_postid($image), 'medium'); ?>
      </div>
      <div class="content">
        <span><?php echo $tnames_arr[0]; ?></span>
        <?php the_title('<h2>', '</h2>'); ?>
      </div>
    </a>
  <?php } ?>
</div>