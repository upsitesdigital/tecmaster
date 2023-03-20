<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$tax       = get_queried_object()->taxonomy;
$term      = get_queried_object()->slug;
$termID    = get_queried_object()->term_id;
$termName  = get_queried_object()->name;
$termColor = get_field('cor', 'category_'.$termID) ? get_field('cor', 'category_'.$termID) : '#FD6519' ;
$count = [];

?>

<!-- main -->
<main>
  <!-- featured -->
  <section id="featured" class="categories" style="color: <?php echo $termColor; ?>">
    <div class="container">
      <div class="grid">
        <div class="banner">
          <?php get_template_part( 'template-parts/banners/banner', 'full' ); ?>
        </div>
        <div class="title" style="color: <?php echo $termColor; ?>; ">
          <h1 class=""><?php echo $termName; ?></h1>
          <span></span>
        </div>
        <?php
          $args = array(
            'post_type' => 'post',
            'posts_per_page'  => 3,
            'meta_query' => array(
              'relation' => 'AND',
              array(
                'key' => 'postagem_destacada',
                'value' => 'Sim',
                'compare' => 'IN'
              ),
            )
          );
          if($term) {
            $args['tax_query'] = array(
              array(
                'taxonomy' => $tax,
                'field' => 'slug',
                'terms' => $term,
              )
            );
          }
          $posts = new WP_Query( $args );
          ?>
          <?php
          $counter = 1;
          $class = '';
          while ( $posts->have_posts() ) : $posts->the_post();
            array_push($count, get_the_ID());
            if($counter == 1) {
              $class = 'first';
            } elseif($counter == 2) {
              $class = 'second';
            } elseif($counter == 3) {
              $class = 'third';
            };
            echo '<div class="'. $class .'">';
              get_template_part( 'template-parts/posts/content', 'blog-featured' );
            echo '</div>';
          $counter++; endwhile; // End of the loop.
        ?>
      </div>
    </div>
  </section>
  <!-- end:featured -->

  <!-- lastNews -->
  <section id="lastNews">
    <div class="container">
      <?php
        $argsF = array(
          'post_type' => 'post',
          'posts_per_page'  => 4,
          'orderby' => 'date ',
          'order' => 'DESC',
          'post__not_in' => $count,
        );
        if($term) {
          $argsF['tax_query'] = array(
            array(
              'taxonomy' => $tax,
              'field' => 'slug',
              'terms' => $term,
            )
          );
        }
        $postsF = new WP_Query( $argsF );
        echo '<div id="theFour">';
          while ( $postsF->have_posts() ) : $postsF->the_post();
            array_push($count, get_the_ID());
            get_template_part( 'template-parts/posts/content', 'blog-featured' );
          endwhile; // End of the loop.
        echo '</div>';

        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $args = array(
          'post_type' => 'post',
          'paged' => $paged,
          'post__not_in' => $count,
          'orderby' => 'date ',
          'order' => 'DESC',
        );
        if($term) {
          $args['tax_query'] = array(
            array(
              'taxonomy' => $tax,
              'field' => 'slug',
              'terms' => $term,
            )
          );
        }
        $posts = new WP_Query( $args );
        $maxpages = $posts->max_num_pages;
        echo '<div id="getCont">';
          echo '<div id="news">';
            while ( $posts->have_posts() ) : $posts->the_post();
              get_template_part( 'template-parts/posts/content', 'blog' );
            endwhile; // End of the loop.
          echo '</div>';
        echo '</div>';
        US_paging_nav2($termColor,$posts,$paged,$maxpages);
      ?>
    </div>
  </section>
  <!-- end:lastNews -->

</main>
<!-- end:main -->
