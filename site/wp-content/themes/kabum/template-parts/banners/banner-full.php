<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

if (is_single()) {

//var_dump(get_query_var("position")['pos']);
  /*if (!empty(get_query_var("position")['pos']) && get_query_var("position")['pos'] == 'middle') {
    $US_bannerfull            = get_theme_mod('US_bannerSinglemidle') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerSinglemidle')), 'full') : '<img width="100%" height="auto" alt="banner" src="' . get_bloginfo('template_url') . '/assets/img/banner1214x149.jpg">';
    $US_bannerfullmobile      = get_theme_mod('US_bannerSinglemidle_mobile') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerSinglemidle_mobile')), 'full') : $US_bannerfull;
    $US_bannerfulllink        = get_theme_mod('US_bannerSinglemidleLink');
  } else {*/
    $US_bannerfull            = get_theme_mod('US_bannerSinglefull') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerSinglefull')), 'full') : '<img width="100%" height="auto" alt="banner" src="' . get_bloginfo('template_url') . '/assets/img/banner1214x149.jpg">';
    $US_bannerfullmobile      = get_theme_mod('US_bannerSinglefull_mobile') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerSinglefull_mobile')), 'full') : $US_bannerfull;
    $US_bannerfulllink        = get_theme_mod('US_bannerSinglefullLink');
  /*}*/
} elseif (is_archive() || is_page_template('template-pages/category.php')) {
  $US_bannerfull            = get_theme_mod('US_bannerCategoryfull') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerCategoryfull')), 'full') : '<img width="100%" height="auto" alt="banner" src="' . get_bloginfo('template_url') . '/assets/img/banner1214x149.jpg">';
  $US_bannerfullmobile      = get_theme_mod('US_bannerCategoryfull_mobile') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerCategoryfull_mobile')), 'full') : $US_bannerfull;
  $US_bannerfulllink        = get_theme_mod('US_bannerCategoryfullLink');
} else {
  $US_bannerfull            = get_theme_mod('US_bannerHomefull') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerHomefull')), 'full') : '<img width="100%" height="auto" alt="banner" src="' . get_bloginfo('template_url') . '/assets/img/banner1214x149.jpg">';
  $US_bannerfullmobile      = get_theme_mod('US_bannerHomefull_mobile') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerHomefull_mobile')), 'full') : $US_bannerfull;
  $US_bannerfulllink        = get_theme_mod('US_bannerHomefullLink');
}

$US_bannerfullout       = $US_bannerfulllink ? '<a class="visible-onlydesck" target="_blank" href="' . $US_bannerfulllink . '">' . $US_bannerfull . '</a>' : '<div class="visible-onlydesck">' . $US_bannerfull . '</div>';
$US_bannerfulloutmobile = $US_bannerfulllink ? '<a class="visible-onlyphone" target="_blank" href="' . $US_bannerfulllink . '">' . $US_bannerfullmobile . '</a>' : '<div class="visible-onlydesck">' . $US_bannerfullmobile . '</div>';

echo '<div class="fullbanner">' . $US_bannerfullout . '' . $US_bannerfulloutmobile . '</div>';
