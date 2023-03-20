<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

get_header();

ed_set_post_views(get_the_ID());

?>
<?php
$post_id = get_the_ID();
$author_id = get_post_field('post_author', $post_id);
$author_name = get_the_author_meta('display_name', $author_id);
$author_slug = get_the_author_meta('user_nicename', $author_id);

$url = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'thumbnail');
if ($url != '') {
  $src = $url;
} else {
  $src = 'https://img.youtube.com/vi/' . get_field('video_kabumTV') . '/mqdefault.jpg';
}
?>
<!-- main -->
<main>
  <!-- featured -->
  <section id="featured" class="postCont">
    <div class="container">
      <div class="grid">
        <div class="banner">
          <?php get_template_part('template-parts/banners/banner', 'full'); ?>
        </div>
      </div>
    </div>
  </section>
  <!-- end:featured -->

  <!-- postCont -->
  <section id="postCont" class="pbottom-50">
    <div class="container grid">
      <div class="img" style="height:auto;">
        <iframe id="video<?php the_field('video_kabumTV'); ?>" width="100%" height="100%" src="https://www.youtube.com/embed/<?php the_field('video_kabumTV'); ?>?enablejsapi=1&amp;html5=1&amp;wmode=opaque&amp;autohide=1" frameborder="0" allowfullscreen=""></iframe>
      </div>

    </div>
  </section>
  <!-- end:postCont -->

</main>
<!-- end:main -->

<?php

get_footer();
