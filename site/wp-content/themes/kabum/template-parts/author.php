<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

$termColor = '#FD6519';
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$count = [];
//var_dump($curauth);
//echo $curauth->display_name;
?>

<!-- main -->
<main>
  <!-- featured -->
  <section id="featured" class="categories" style="color: <?php echo $termColor; ?>">
    <div class="container">
      <div class="grid">
        <div class="banner">
          <?php get_template_part('template-parts/banners/banner', 'full'); ?>
        </div>
        <div class="title" style="color: <?php echo $termColor; ?>; ">
          <h2 class=""><?php echo $curauth->display_name; ?></h2>
          <span></span>
        </div>
        <?php
        $args = array(
          'post_type' => 'post',
          'posts_per_page'  => 3,
          'author' => $curauth->ID,
          'meta_query' => array(
            'relation' => 'AND',
            array(
              'key' => 'postagem_destacada',
              'value' => 'Sim',
              'compare' => 'IN'
            ),
          )
        );
        $posts = new WP_Query($args);
        ?>
        <?php
        $counter = 1;
        $class = '';
        while ($posts->have_posts()) : $posts->the_post();
          array_push($count, get_the_ID());
          if ($counter == 1) {
            $class = 'first';
          } elseif ($counter == 2) {
            $class = 'second';
          } elseif ($counter == 3) {
            $class = 'third';
          };
          echo '<div class="' . $class . '">';
          get_template_part('template-parts/posts/content', 'blog-featured');
          echo '</div>';
          $counter++;
        endwhile; // End of the loop.
        ?>
      </div>
    </div>
  </section>
  <!-- end:featured -->

  <!-- page-content -->
  <section id="page-content">
    <div class="container">
      <div class="small">
        <div class="content">
          <div class="bioAuthor">
            <?php
            $avatar = (get_user_meta($curauth->ID, 'us_imagem_avatar', true) != '') ? wp_get_attachment_image(get_user_meta($curauth->ID, 'us_imagem_avatar', true)) : get_avatar($curauth->ID, 120);
            echo '<div class="boxAvatar">';
            echo $avatar . '<br>';
            echo '</div>';
            echo '<div class="boxInfos">';
            echo '<h1>' . $curauth->display_name . '</h1>';
            echo '</div>';
            echo '<div class="boxBio">';
            echo '<p>' . get_user_meta($curauth->ID, 'description', true) . '</p>';
            echo '</div>';
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end:page-content -->

  <!-- lastNews -->
  <section id="lastNews">
    <div class="container">
      <h3>
        <svg class="icon">
          <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#featured"></use>
        </svg>
        <span>Post do autor</span>
      </h3>
      <?php

      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = array(
        'post_type' => 'post',
        'paged' => $paged,
        'post__not_in' => $count,
        'author' => $curauth->ID,
        'orderby' => 'date ',
        'order' => 'DESC',
      );
      $posts = new WP_Query($args);
      $maxpages = $posts->max_num_pages;
      echo '<div id="getCont">';
      echo '<div id="news">';
      while ($posts->have_posts()) : $posts->the_post();
        get_template_part('template-parts/posts/content', 'blog');
      endwhile; // End of the loop.
      echo '</div>';
      echo '</div>';
      US_paging_nav2($termColor, $posts, $paged, $maxpages);
      ?>
    </div>
  </section>
  <!-- end:lastNews -->

</main>
<!-- end:main -->