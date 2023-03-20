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

$timefeaturedNew  = (get_theme_mod('US_time_featuredNews') == '') ? '30' : get_theme_mod('US_time_featuredNews');

$tcolor_arr = colorPost();
$tslugs_arr = slugPost();
$tnames_arr = namePost();

$rgb_color = hex2RGB($tcolor_arr[0]);

if ($tcolor_arr[0]) {
  echo '<style>#postCont .postContent ol li::marker{color:' . $tcolor_arr[0] . '}</style>';
  echo '<style>#postCont .postContent ul li::marker{color:' . $tcolor_arr[0] . '}</style>';
  echo '<style>#postCont .postContent table tr:nth-child(even){background-color: rgba(' . $rgb_color[0] . ', ' . $rgb_color[1] . ', ' . $rgb_color[2] . ', 0.05)}</style>';
}
?>
<!-- main -->
<main style="color: <?php echo $tcolor_arr[0] ?>;">
  <!-- featured -->
  <section id="featured" class="postCont">
    <div class="container">
      <div class="grid">
        <div class="banner">
          <?php get_template_part('template-parts/banners/banner', 'full'); ?>
        </div>
        <div class="title">
          <a href="<?php echo get_term_link($tslugs_arr[0], 'category'); ?>"><span><?php echo $tnames_arr[0]; ?></span></a>
          <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
          <h1><?php the_title(); ?></h1>
          <?php if (get_field('subtitulo_post')) {
            echo '<em>' . get_field('subtitulo_post') . '</em>';
          } ?>
          <div class="data">
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <h4>By - <a href="<?php echo get_option('siteurl') . '/author/' . $author_slug; ?>"><?php echo $author_name; ?></a>, <?php the_time('j F Y'); ?> às <?php the_time('G:i'); ?></h4>
          </div>
          <div class="share">
            <h4>Compartilhe post</h4>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" style="border-color: rgba(<?php echo $rgb_color[0] . ', ' . $rgb_color[1] . ', ' . $rgb_color[2]; ?>, 0.1);"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>" target="_blank" style="border-color: rgba(<?php echo $rgb_color[0] . ', ' . $rgb_color[1] . ', ' . $rgb_color[2]; ?>, 0.1);"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
            <a href="mailto:subject=&cc=&bcc=&body=<?php the_permalink(); ?>" target="_blank" style="border-color: rgba(<?php echo $rgb_color[0] . ', ' . $rgb_color[1] . ', ' . $rgb_color[2]; ?>, 0.1);"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank" style="border-color: rgba(<?php echo $rgb_color[0] . ', ' . $rgb_color[1] . ', ' . $rgb_color[2]; ?>, 0.1);"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- end:featured -->

  <!-- postCont -->
  <section id="postCont">
    <div class="container grid">
      <div class="img" style="background-image: url(<?php echo get_field('imagem_destacada')['url'] ?>);"></div>

      <div class="postContent borderTop">
        <?php

        $coreCont = get_the_content();
        $content = explode("[--quebra--]", $coreCont);
        echo apply_filters('the_content', $content[0]);
        echo '</div><div class="postContent">';
        if (sizeof($content) > 1) {
          echo apply_filters('the_content', $content[1]);
        }
        ?>
      </div>

      <?php
      $post_tags = get_the_tags();
      if ($post_tags) {
        echo '<div class="tags">';
        foreach ($post_tags as $tag) {
          echo '<a href="' . get_term_link($tag) . '" style="background-color: rgba(' . $rgb_color[0] . ', ' . $rgb_color[1] . ', ' . $rgb_color[2] . ', 0.1);">' . $tag->name . '</a>';
        }
        echo '</div>';
      }
      ?>

      <div id="comments">
        <div class="title">
          <h4>Comentários</h4>
          <div class="count">
            <svg class="icon">
              <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#balao"></use>
            </svg>
            <span><?php
                  $comments_count = wp_count_comments($post_id);
                  echo $comments_count->approved;
                  ?></span>
          </div>
        </div>
        <div class="form">
          <?php
          $commenter = wp_get_current_commenter();
          $req = get_option('require_name_email');
          $aria_req = ($req ? " aria-required='true'" : '');
          $fields =  array(
            'author' => '<div class="name fields"><input id="author" name="author" type="text" placeholder="Nome" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
            'email'  => '<div class="email fields"><input id="email" name="email" type="text" placeholder="Email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>',
          );
          $url = '<div class="submit">%1$s %2$s<svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg></div>';
          $comments_args = array(
            'fields'                =>  $fields,
            'title_reply'           => 'Please give us your valuable comment',
            'label_submit'          => 'Comentar',
            'submit_button'         => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
            'submit_field'          => $url,
          );
          comment_form($comments_args);
          ?>
        </div>
        <div class="commentList">
          <?php
          echo '<ul class="commentlist">';
          $comments = get_comments(array(
            'post_id' => $post_id,
            'status' => 'approve',
            'orderby' => 'comment_type',
          ));
          wp_list_comments(array(
            'per_page' => -1,
            'reverse_top_level' => false,
            'callback' => 'format_comment',
          ), $comments);
          echo '</ul>';
          ?>
        </div>
      </div>

      <div class="related">
        <?php
        $postsRelacionados = get_field('posts_relacionados');
        if ($postsRelacionados) {
          echo '<h4>Matérias relacionadas</h4>';
          foreach ($postsRelacionados as $post) :
            get_template_part('template-parts/posts/content', 'blog-list');
          endforeach;
        } else {
          $tax = get_field('categoria_principal'); // recebe ID
          $args = array(
            'post_type' => 'post',
            'post__not_in' => array($post_id),
            'posts_per_page'  => 3,
            'meta_key'    => 'categoria_principal',
            'meta_value'  => $tax,
          );
          $posts = new WP_Query($args);
          if ($posts->have_posts()) {
            echo '<h4>Matérias relacionadas</h4>';
            while ($posts->have_posts()) : $posts->the_post();
              get_template_part('template-parts/posts/content', 'blog-list');
            endwhile; // End of the loop.
          }
        }
        ?>
      </div>

      <div class="banner">
        <div style="margin: 20px auto 0 auto; max-width:728px;">
          <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8418522754531700" crossorigin="anonymous"></script>
          <ins class="adsbygoogle" style="display:inline-block;width:728px;min-height:90px" data-ad-format="fluid" data-ad-layout-key="-fb+5w+4e-db+86" data-ad-client="ca-pub-8418522754531700" data-ad-slot="2531419719"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div>
        <?php /*
          $array_defaults = array('pos' => 'middle');
          set_query_var( "position", $array_defaults);
          get_template_part( 'template-parts/banners/banner', 'full' ); */
        ?>
      </div>



      <div class="sidebar">
        <div class="banner">
          <?php get_template_part('template-parts/banners/banner', 'side'); ?>
        </div>
        <div class="newsletter">
          <?php
          $titformFooters        = get_theme_mod('US_tit_form_footer');
          $formFooters            = get_theme_mod('US_form_footer');
          if ($formFooters != '') {
            echo '<div class="box">
                <h4>' . $titformFooters . '</h4>
                ' . $formFooters . '
              </div>';
          }
          ?>
        </div>
        <div class="listNews">
          <h3>
            <svg class="icon">
              <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#moreLastNews"></use>
            </svg>
            <span>As mais lidas</span>
          </h3>
          <div id="news">
            <?php
            $tax = $tnames_arr[0];
            $args = array(
              'post_type' => 'post',
              'posts_per_page'  => 5,
              'meta_key' => 'ed_post_views_count',
              'orderby' => 'meta_value_num',
              'order' => 'DESC',
              'date_query' => array(
                'after' => date('Y-m-d', strtotime('-' . $timefeaturedNew . ' days'))
              )
            );
            $posts = new WP_Query($args);
            while ($posts->have_posts()) : $posts->the_post();
              get_template_part('template-parts/posts/content', 'blog');
            endwhile; // End of the loop.
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end:postCont -->

  <!-- lastNews
  <section id="lastNews" class="postCont">
    <div class="container">
      <h3>
        <svg class="icon"><use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#moreLastNews"></use></svg> 
        <span>Veja Também</span>
      </h3>
      <div id="theFour">
        <?php
        $tax = $tnames_arr[0]; // recebe slug
        $args = array(
          'post_type' => 'post',
          'post__not_in' => array($post_id),
          'posts_per_page'  => 4,
          'tax_query' => array(
            'relation' => 'AND',
            array(
              'taxonomy' => 'category',
              'field'    => 'slug',
              'terms'    => $tax,
            )
          ),
        );
        $posts = new WP_Query($args);
        while ($posts->have_posts()) : $posts->the_post();
          get_template_part('template-parts/posts/content', 'blog-featured');
        endwhile; // End of the loop.
        ?>
      </div>
    </div>
  </section>
  end:lastNews -->



</main>
<!-- end:main -->

<?php

get_footer();
