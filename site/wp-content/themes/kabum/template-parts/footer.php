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
$socialMedia           = get_theme_mod('US_SM_title');
$socialMediaLinkfb     = get_theme_mod('US_SM_facebook');
$socialMediaLinkin     = get_theme_mod('US_SM_linkedin');
$socialMediaLinktw     = get_theme_mod('US_SM_twitter');
$socialMediaLinkyt     = get_theme_mod('US_SM_youtube');

$emailContact         = get_theme_mod('US_emailContact');
$logoFooter            = get_theme_mod('logo_footer');

$titformFooter        = get_theme_mod('US_tit_form_footer');
$formFooter            = get_theme_mod('US_form_footer');
?>
<!-- footer -->
<footer id="footer">
  <div class="container">
    <div class="grid">
      <div class="links">
        <?php
        if ($logoFooter != '') {
          echo wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('logo_footer')), 'full');
        }
        if ($emailContact != '') {
          echo '<a id="emailContact" href="mailto:' . $emailContact . '">' . $emailContact . '</a>';
        }
        ?>
        <?php
        if ($socialMedia != '') {
          echo '<h4>' . $socialMedia . '</h4>';
        }
        ?>

        <div class="socialMedia">
          <ul>
            <?php
            if ($socialMediaLinkfb != '') {
              echo '<li><a href="' . $socialMediaLinkfb . '" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
            }
            if ($socialMediaLinkin != '') {
              echo '<li><a href="' . $socialMediaLinkin . '" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
            }
            if ($socialMediaLinktw != '') {
              echo '<li><a href="' . $socialMediaLinktw . '" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
            }
            if ($socialMediaLinkyt != '') {
              echo '<li><a href="' . $socialMediaLinkyt . '" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>';
            }
            ?>
          </ul>
        </div>
      </div>
      <div class="institutional">
        <h4>Institucional</h4>
        <?php if (has_nav_menu('institucional')) :
          $itemsWrap = '<ul id="%1$s" class="%2$s">%3$s</ul>';
          wp_nav_menu(
            array(
              'theme_location'       => 'institucional',
              'menu'                 => '',
              'container'            => 'ul',
              'container_class'      => 'menu',
              'container_id'         => '',
              'container_aria_label' => '',
              'menu_class'           => '',
              'menu_id'              => '',
              'echo'                 => true,
              'fallback_cb'          => 'wp_page_menu',
              'before'               => '',
              'after'                => '',
              'link_before'          => '',
              'link_after'           => '',
              'items_wrap'           => $itemsWrap,
              'item_spacing'         => 'preserve',
              'depth'                => 0,
              'walker'               => '',
            )
          );
        endif; ?>
      </div>
      <div class="category">
        <h4>Categorias</h4>
        <?php if (has_nav_menu('footer')) :
          $itemsWrap = '<ul id="%1$s" class="%2$s">%3$s</ul>';
          wp_nav_menu(
            array(
              'theme_location'       => 'footer',
              'menu'                 => '',
              'container'            => 'ul',
              'container_class'      => 'menu',
              'container_id'         => '',
              'container_aria_label' => '',
              'menu_class'           => '',
              'menu_id'              => '',
              'echo'                 => true,
              'fallback_cb'          => 'wp_page_menu',
              'before'               => '',
              'after'                => '',
              'link_before'          => '',
              'link_after'           => '',
              'items_wrap'           => $itemsWrap,
              'item_spacing'         => 'preserve',
              'depth'                => 0,
              'walker'               => '',
            )
          );
        endif; ?>
      </div>
      <div class="newsletter">
        <?php
        if ($formFooter != '') {
          echo '<div class="box">
                <h4>' . $titformFooter . '</h4>
                ' . $formFooter . '
              </div>';
        }
        ?>
      </div>
      <div class="copyright">
        <p>©<?php echo date('Y'); ?> KaBuM! - Todos os Direitos Reservados</p>
      </div>
    </div>
  </div>
</footer>
<!-- end:footer -->
</div>
<!-- modal-search -->
<div id="modal" class="">
  <div id="modal-search" class="">
    <div class="form">
      <a href="#" id="close-search" class="opened" aria-expanded="true">
        <div class="ani">
          <svg id="close" width="30" height="50" viewBox="0 0 100 100">
            <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
            <path class="line line2" d="M 20,50 H 80" />
            <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
          </svg>
        </div>
      </a>
      <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="search" class="search-field" placeholder="Digite e pressione enter" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit"><svg class="icon">
            <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#search"></use>
          </svg></button>
      </form>
    </div>
  </div>
</div>
<!-- end:modal-search -->