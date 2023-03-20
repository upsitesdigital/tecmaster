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
$socialMediaLinkfb     = get_theme_mod('US_SM_facebook');
$socialMediaLinkin     = get_theme_mod('US_SM_linkedin');
$socialMediaLinktw     = get_theme_mod('US_SM_twitter');
$socialMediaLinkyt     = get_theme_mod('US_SM_youtube');
$socialMediaLinkfl     = get_theme_mod('US_SM_flipboard');
$logoFooter            = get_theme_mod('logo_footer');

?>
<div class="after">
  <div class="multi-spinner-container">
    <div class="multi-spinner">
      <div class="multi-spinner">
        <div class="multi-spinner">
          <div class="multi-spinner">
            <div class="multi-spinner">
              <div class="multi-spinner"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="wrapper">
  <!-- header -->
  <header id="top">
    <div class="container">
      <!-- grid -->
      <div class="grid">
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
            if ($socialMediaLinkfl != '') {
              echo '<li><a href="' . $socialMediaLinkfl . '" target="_blank"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg?v=20#flipboard"></use></svg></a></li>';
            }
            ?>
          </ul>
        </div>
        <div class="logo">
          <?php
          $the_custom_logo = get_theme_mod('custom_logo');
          $site_name = get_bloginfo('name');
          $tagline   = get_bloginfo('description', 'display');
          if (function_exists('the_custom_logo') &&  has_custom_logo()) {
            if (is_home()) {
              echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '" rel="home" title="' . get_bloginfo('name') . '">' . wp_get_attachment_image(get_theme_mod('custom_logo'), 'full') . '</a></h1>';
            } else {
              echo '<a href="' . esc_url(home_url('/')) . '" rel="home" title="' . get_bloginfo('name') . '">' . wp_get_attachment_image(get_theme_mod('custom_logo'), 'full') . '</a>';
            }
            //echo '<h1 style="display:none">'. get_bloginfo( 'name' ) .'</h1>';
          } elseif ($site_name) {
          ?>
            <h1 class="site-title">
              <a href="<?php echo esc_url(home_url('/')); ?>" title="Home" rel="home">
                <?php echo esc_html($site_name); ?>
              </a>
            </h1>
            <p class="site-description">
              <?php
              if ($tagline) {
                echo esc_html($tagline);
              }
              ?>
            </p>
          <?php } ?>
        </div>
        <div class="search">
          <div id="box-search">
            <div class="form">
              <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="search-field" placeholder="Digite e pressione enter" value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="search-submit"></button>
              </form>
            </div>
          </div>
          <a href="" id="open-search">
            <svg class="icon">
              <use xlink:href="<?php bloginfo('template_url'); ?>/assets/img/icons.svg#search"></use>
            </svg>
          </a>
          <a href="#" id="open-menu" class="">
            <div class="ani">
              <svg class="close" width="30" height="50" viewBox="0 0 100 100">
                <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                <path class="line line2" d="M 20,50 H 80" />
                <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
              </svg>
            </div>
          </a>
        </div>
      </div>
      <!-- end:grid -->
    </div>

    <div id="blockMenu">
      <div class="container">
        <?php if (function_exists(clean_custom_menus())) clean_custom_menus(); ?>
      </div>
    </div>
  </header>
  <!-- end:header -->
  <div id="blockSubMenu">
    <div class="container">
      <nav id="superMenu" class="subMenu">
        <div class="category">
          <h3>Todas Categorias</h3>
          <?php if (has_nav_menu('category')) :
            $itemsWrap = '<ul id="%1$s" class="%2$s">%3$s</ul>';
            wp_nav_menu(
              array(
                'theme_location'       => 'category',
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
        <!-- div class="institutional">
        <h3>Institucional</h3>
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
      </div -->
        <div class="publicity">
          <!-- div class="img"></div -->
          <?php
          /*if ($logoFooter != '') {
            echo '<div class="logo">' . wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('logo_footer')), 'full') . '</div>';
          }*/
          ?>
        </div>
      </nav>
    </div>
  </div>