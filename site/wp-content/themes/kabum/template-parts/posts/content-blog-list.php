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
?>
<div data-id="post-<?php the_ID(); ?>" class="post list" style="color: <?php echo $tcolor_arr[0] ?>;">
  <a href="<?php the_permalink(); ?>">
    <div class="content">
      <span><?php echo $tnames_arr[0]; ?></span>
      <?php the_title('<h2>', '</h2>'); ?>
    </div>
  </a>
</div>