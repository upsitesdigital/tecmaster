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
$count = [];

$posthome01        = get_theme_mod('US_posthome01');
$posthome02        = get_theme_mod('US_posthome02');
$posthome03        = get_theme_mod('US_posthome03');
$posthome04        = get_theme_mod('US_posthome04');
$timefeaturedNews  = (get_theme_mod('US_time_featuredNews') == '') ? '30' : get_theme_mod('US_time_featuredNews');

$titformFooter        = get_theme_mod('US_tit_form_footer');
$formFooter            = get_theme_mod('US_form_footer');
?>

<!-- featured -->
<section id="featured" style="color: <?php echo $termColor; ?>">
  <div class="container">
    <div class="grid">
      <div class="banner">
        <?php get_template_part('template-parts/banners/banner', 'full'); ?>
      </div>
      <?php
      if ($posthome01 && $posthome02 && $posthome03 && $posthome04) {
        echo '<div class="first">';
        $posthome01args = array(
          'post_type' => ['post', 'kabumtv'],
          'p'         => $posthome01,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );
        $posthome01posts = new WP_Query($posthome01args);
        while ($posthome01posts->have_posts()) : $posthome01posts->the_post();
          array_push($count, get_the_ID());
          get_template_part('template-parts/posts/content', 'blog-featured');
        endwhile;
        echo '</div>';

        echo '<div class="slideMobile">';
        echo '<div class="second">';
        $posthome02args = array(
          'post_type' => ['post', 'kabumtv'],
          'p'         => $posthome02,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );
        $posthome02posts = new WP_Query($posthome02args);
        while ($posthome02posts->have_posts()) : $posthome02posts->the_post();
          array_push($count, get_the_ID());
          get_template_part('template-parts/posts/content', 'blog-featured');
        endwhile;
        echo '</div>';

        echo '<div class="third">';
        $posthome03args = array(
          'post_type' => ['post', 'kabumtv'],
          'p'         => $posthome03,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );
        $posthome03posts = new WP_Query($posthome03args);
        while ($posthome03posts->have_posts()) : $posthome03posts->the_post();
          array_push($count, get_the_ID());
          get_template_part('template-parts/posts/content', 'blog-featured');
        endwhile;
        echo '</div>';

        echo '<div class="fourth">';
        $posthome04args = array(
          'post_type' => ['post', 'kabumtv'],
          'p'         => $posthome04,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );
        $posthome04posts = new WP_Query($posthome04args);
        while ($posthome04posts->have_posts()) : $posthome04posts->the_post();
          array_push($count, get_the_ID());
          get_template_part('template-parts/posts/content', 'blog-featured');
        endwhile;
        echo '</div>';
        echo '</div>';
      } else {
        $args = array(
          'post_type' => 'post',
          'posts_per_page'  => 4,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false,
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
        $pos = 1;
        $class = '';
        while ($posts->have_posts()) : $posts->the_post();
          array_push($count, get_the_ID());

          if ($pos == 1) {
            $class = 'first';
          } elseif ($pos == 2) {
            $class = 'second';
          } elseif ($pos == 3) {
            $class = 'third';
          } elseif ($pos == 4) {
            $class = 'fourth';
          };
          if ($pos == 2) {
            echo '<div class="slideMobile">';
          }
          echo '<div class="' . $class . '">';
          get_template_part('template-parts/posts/content', 'blog-featured');
          echo '</div>';
          if ($pos == 4) {
            echo '</div>';
          }
          $pos++;
        endwhile; // End of the loop.
      }
      ?>
    </div>
  </div>
</section>
<!-- end:featured -->
<section class="box-newsletter">
  <div class="container">
    <div class="newsletter">
      <?php
      if ($formFooter != '') {
        echo '<div class="box">
          <h4>CADASTRE-SE E RECEBA AS <br>PRINCIPAIS NOTÍCIAS DO MUNDO <br>DA TECNOLOGIA NO SEU E-MAIL</h4>
          ' . $formFooter . '
        </div>';
      }
      ?>
    </div>
  </div>
</section>


<div style="margin: 20px auto 0 auto; max-width:728px; max-height:90px;">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8418522754531700" crossorigin="anonymous"></script>
  <!-- Topo Home -->
  <ins class="adsbygoogle" style="display:inline-block;width:728px;min-height:90px" data-ad-client="ca-pub-8418522754531700" data-ad-slot="3440450351"></ins>
  <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

<!-- lastNews -->
<section id="lastNews">
  <div class="container">
    <h3>
      <svg class="icon">
        <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#featured"></use>
      </svg>
      <span>Últimas notícias</span>
    </h3>
    <?php

    $argsF = array(
      'post_type' => 'post',
      'posts_per_page'  => 4,
      'orderby' => 'date ',
      'order' => 'DESC',
      'post__not_in' => $count,
    );
    $postsF = new WP_Query($argsF);
    echo '<div id="theFour">';
    while ($postsF->have_posts()) : $postsF->the_post();
      array_push($count, get_the_ID());
      get_template_part('template-parts/posts/content', 'blog-featured');
    endwhile; // End of the loop.
    echo '</div>';

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
      'post_type' => 'post',
      'paged' => $paged,
      'post__not_in' => $count,
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

<!-- featuredNews -->
<section id="featuredNews">
  <div class="container">
    <div class="grid">
      <div class="blockNews">
        <h3>
          <svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#featuredNews"></use>
          </svg>
          <span>Em Alta</span>
        </h3>
        <div class="classnews" data-d="<?php echo date('Y-m-d', strtotime('-' . $timefeaturedNews . ' days')) ?>">
          <?php
          $args = array(
            'post_type' => 'post',
            'posts_per_page'  => 6,
            'no_found_rows'          => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'cache_results'          => false,
            'meta_key' => 'ed_post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'date_query' => array(
              'after' => date('Y-m-d', strtotime('-' . $timefeaturedNews . ' days'))
            )
          );
          $posts = new WP_Query($args);
          while ($posts->have_posts()) : $posts->the_post();
            get_template_part('template-parts/posts/content', 'blog');
          endwhile; // End of the loop.
          ?>
        </div>
      </div>
      <div class="blockBanner">
        <div class="banner">
          <?php get_template_part('template-parts/banners/banner', 'side');  ?>

        </div>
      </div>
    </div>
  </div>
</section>
<!-- end:featuredNews -->

<!-- featuredAuthors -->
<section id="featuredAuthors">
  <div class="container">
    <h3>
      <svg class="icon">
        <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#fire"></use>
      </svg>
      <span>Colunistas</span>
    </h3>
    <div class="slide-author">
      <div class="item">
        <?php
        $aut = get_theme_mod('US_aut01') ? get_theme_mod('US_aut01') : 'admin'; // recebe slug
        $autcolor = '#FD6519';
        $autname = get_the_author_meta('display_name', $aut);
        $auturl = get_author_posts_url($aut);
        $avatar = (get_user_meta($aut, 'us_imagem_avatar', true) != '') ? wp_get_attachment_image(get_user_meta($aut, 'us_imagem_avatar', true)) : get_avatar($aut, 60);
        ?>
        <div class="bioAuthor">
          <div class="boxAvatar">
            <?php echo $avatar; ?>
          </div>
          <div class="boxInfos">
            <h4><?php echo $autname; ?></h4>
            <?php echo '<p>' . get_user_meta($aut, 'description', true) . '</p>' ?>
          </div>
        </div>
        <?php
        $autcount = 0;
        $autargs = array(
          'post_type' => 'post',
          'posts_per_page'  => 1,
          'author' => $aut,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );
        $autposts = new WP_Query($autargs);
        while ($autposts->have_posts()) : $autposts->the_post();
          if ($autcount == 0) {
            get_template_part('template-parts/posts/content', 'blog-featured');
          } else {
            get_template_part('template-parts/posts/content', 'blog');
          }
          $autcount++;
        endwhile;
        ?>
        <a href="<?php echo $auturl ?>" class="link" style="color: <?php echo $autcolor ?>;">Ver mais <svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#arrow"></use>
          </svg></a>
      </div>
      <div class="item">
        <?php
        $aut = get_theme_mod('US_aut02') ? get_theme_mod('US_aut02') : 'admin'; // recebe slug
        $autcolor = '#FD6519';
        $avatar = (get_user_meta($aut, 'us_imagem_avatar', true) != '') ? wp_get_attachment_image(get_user_meta($aut, 'us_imagem_avatar', true)) : get_avatar($aut, 60);
        $autname = get_the_author_meta('display_name', $aut);
        $auturl = get_author_posts_url($aut);
        ?>
        <div class="bioAuthor">
          <div class="boxAvatar">
            <?php echo $avatar; ?>
          </div>
          <div class="boxInfos">
            <h4><?php echo $autname; ?></h4>
            <?php echo '<p>' . get_user_meta($aut, 'description', true) . '</p>' ?>
          </div>
        </div>
        <?php
        $autcount = 0;
        $autargs = array(
          'post_type' => 'post',
          'posts_per_page'  => 1,
          'author' => $aut,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );
        $autposts = new WP_Query($autargs);
        while ($autposts->have_posts()) : $autposts->the_post();
          if ($autcount == 0) {
            get_template_part('template-parts/posts/content', 'blog-featured');
          } else {
            get_template_part('template-parts/posts/content', 'blog');
          }
          $autcount++;
        endwhile;

        ?>
        <a href="<?php echo $auturl ?>" class="link" style="color: <?php echo $autcolor ?>;">Ver mais <svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#arrow"></use>
          </svg></a>
      </div>
      <div class="item">
        <?php
        $aut = get_theme_mod('US_aut03') ? get_theme_mod('US_aut03') : 'admin'; // recebe slug
        $autcolor = '#FD6519';
        $autname = get_the_author_meta('display_name', $aut);
        $auturl = get_author_posts_url($aut);
        $avatar = (get_user_meta($aut, 'us_imagem_avatar', true) != '') ? wp_get_attachment_image(get_user_meta($aut, 'us_imagem_avatar', true)) : get_avatar($aut, 60);
        ?>
        <div class="bioAuthor">
          <div class="boxAvatar">
            <?php echo $avatar; ?>
          </div>
          <div class="boxInfos">
            <h4><?php echo $autname; ?></h4>
            <?php echo '<p>' . get_user_meta($aut, 'description', true) . '</p>' ?>
          </div>
        </div>
        <?php
        $autcount = 0;
        $autargs = array(
          'post_type' => 'post',
          'posts_per_page'  => 1,
          'author' => $aut,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );
        $autposts = new WP_Query($autargs);
        while ($autposts->have_posts()) : $autposts->the_post();
          if ($autcount == 0) {
            get_template_part('template-parts/posts/content', 'blog-featured');
          } else {
            get_template_part('template-parts/posts/content', 'blog');
          }
          $autcount++;
        endwhile;

        ?>
        <a href="<?php echo $auturl ?>" class="link" style="color: <?php echo $autcolor ?>;">Ver mais <svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#arrow"></use>
          </svg></a>
      </div>
    </div>
  </div>
</section>
<!-- end:featuredAuthors -->

<!-- categoryNews -->
<section id="categoryNews">
  <div class="container">
    <div class="slide-category">
      <div class="item">
        <?php
        $tax = get_theme_mod('US_cat01') ? get_theme_mod('US_cat01') : 'reviews'; // recebe slug
        $tag = get_category_by_slug($tax);
        $color = get_field('cor', 'category_' . $tag->term_id);
        echo '<h3 id="cat01" style="color: ' . $color . ';">' . $tag->name . '</h3>';
        $array_defaults = array('tag' => $tag->name, 'color' => $color);
        $count = 0;
        $args = array(
          'post_type' => 'post',
          'posts_per_page'  => 4,
          'cat' => $tag->term_id,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );

        $posts = new WP_Query($args);
        while ($posts->have_posts()) : $posts->the_post();
          set_query_var("global_vars", $array_defaults);
          if ($count == 0) {
            get_template_part('template-parts/posts/content', 'blog-featured');
          } else {
            get_template_part('template-parts/posts/content', 'blog-list');
          }
          $count++;
        endwhile; // End of the loop.
        ?>
        <a href="<?php echo get_term_link($tag); ?>" class="link mtop-35" style="color: <?php echo $color ?>;">Ver mais <svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#arrow"></use>
          </svg></a>
      </div>
      <div class="item">
        <?php
        $tax = get_theme_mod('US_cat02') ? get_theme_mod('US_cat02') : 'games'; // recebe slug
        $tag = get_category_by_slug($tax);
        $color = get_field('cor', 'category_' . $tag->term_id);
        echo '<h3 id="cat02" style="color: ' . $color . ';">' . $tag->name . '</h3>';
        $array_defaults = array('tag' => $tag->name, 'color' => $color);
        $count = 0;
        $args = array(
          'post_type' => 'post',
          'posts_per_page'  => 4,
          'cat' => $tag->term_id,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );

        $posts = new WP_Query($args);
        while ($posts->have_posts()) : $posts->the_post();
          set_query_var("global_vars", $array_defaults);
          if ($count == 0) {
            get_template_part('template-parts/posts/content', 'blog-featured');
          } else {
            get_template_part('template-parts/posts/content', 'blog-list');
          }
          $count++;
        endwhile; // End of the loop.
        ?>
        <a href="<?php echo get_term_link($tag); ?>" class="link mtop-35" style="color: <?php echo $color ?>;">Ver mais <svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#arrow"></use>
          </svg></a>
      </div>
      <div class="item">
        <?php
        $tax = get_theme_mod('US_cat03') ? get_theme_mod('US_cat03') : 'esports'; // recebe slug
        $tag = get_category_by_slug($tax);

        $color = get_field('cor', 'category_' . $tag->term_id);
        echo '<h3 id="cat03" style="color: ' . $color . ';">' . $tag->name . '</h3>';
        $array_defaults = array('tag' => $tag->name, 'color' => $color);
        $count = 0;
        $args = array(
          'post_type' => 'post',
          'posts_per_page'  => 4,
          'cat' => $tag->term_id,
          'no_found_rows'          => true,
          'update_post_term_cache' => false,
          'update_post_meta_cache' => false,
          'cache_results'          => false
        );

        $posts = new WP_Query($args);
        while ($posts->have_posts()) : $posts->the_post();
          set_query_var("global_vars", $array_defaults);
          if ($count == 0) {
            get_template_part('template-parts/posts/content', 'blog-featured');
          } else {
            get_template_part('template-parts/posts/content', 'blog-list');
          }
          $count++;
        endwhile; // End of the loop.
        ?>
        <a href="<?php echo get_term_link($tag); ?>" class="link mtop-35" style="color: <?php echo $color ?>;">Ver mais <svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#arrow"></use>
          </svg></a>
      </div>
    </div>
  </div>
</section>
<!-- end:categoryNews -->

<?php
$webStories = get_theme_mod('US_webstories_shortcode');
if ($webStories != '') {
?>
  <div class="webStories">
    <div class="container">
      <h3>
        <svg class="icon">
          <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#fire"></use>
        </svg>
        <span>Web stories</span>
      </h3>

      <?php
      $autcount = 0;
      $webargs = array(
        'post_type' => 'web-story',
        'posts_per_page'  => 6,
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'cache_results'          => false
      );
      $webposts = new WP_Query($webargs);
      echo '<div class="slide-video">';
      while ($webposts->have_posts()) : $webposts->the_post();
        $nonce = wp_create_nonce("webstory_nonce");

        echo '<a target="_blank" data-nonce="' . $nonce . '" data-idpost="' . get_the_ID() . '" href="' . get_the_permalink() . '" class="item">';
        echo '<div style="width: 100%;height: 100%;background: url(' . get_the_post_thumbnail_url() . ') center center no-repeat;">';
        //echo '<iframe src="' . get_the_permalink() . '" width="100%" height="100%"></iframe>';
        echo '<div class="tit-webstory">';
        echo '<h2>' . get_the_title() . '</h2>';
        echo '</div>';
        echo '</div>';
        echo '</a>';
      endwhile;
      echo '</div>';
      ?>

    </div>
  </div>
<?php
}
?>

<!-- kabumTV -->
<section id="kabumTV">
  <div class="container">
    <h2>KaBuM! TV</h2>
    <div class="slider-for">
      <?php
      $args = array(
        'post_type' => 'kabumtv',
        'posts_per_page'  => 15,
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'cache_results'          => false
      );
      $posts = new WP_Query($args);
      while ($posts->have_posts()) : $posts->the_post();
        get_template_part('template-parts/posts/content', 'video-featured');
      endwhile; // End of the loop.
      ?>
    </div>
    <div class="slideVideo slide-video">
      <?php
      $args = array(
        'post_type' => 'kabumtv',
        'posts_per_page'  => 15,
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
        'cache_results'          => false
      );
      $posts = new WP_Query($args);
      while ($posts->have_posts()) : $posts->the_post();
        get_template_part('template-parts/posts/content', 'video');
      endwhile; // End of the loop.
      ?>
    </div>
    <a href="<?php echo get_theme_mod('US_SM_youtube') ?>" target="_blank" class="chanel">
      <svg class="icon">
        <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#play"></use>
      </svg>
      <span>Acesse nosso canal no Youtube</span>
    </a>
  </div>
</section>
<!-- end:kabumTV -->