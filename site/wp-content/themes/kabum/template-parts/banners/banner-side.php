<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 */

if (is_single()) {
	$US_bannerside    		    = get_theme_mod('US_bannerSingleside') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerSingleside')), 'full') : '<img width="100%" height="auto" alt="banner" src="' . get_bloginfo('template_url') . '/assets/img/banner319x619.jpg">';
	$US_bannersidemobile	    = get_theme_mod('US_bannerSingleside_mobile') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerSingleside_mobile')), 'full') : $US_bannerside;
	$US_bannersidelink    		= get_theme_mod('US_bannerSinglesideLink');
} elseif (is_archive() || is_page_template('template-pages/category.php')) {
	$US_bannerside    		    = get_theme_mod('US_bannerCategoryside') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerCategoryside')), 'full') : '<img width="100%" height="auto" alt="banner" src="' . get_bloginfo('template_url') . '/assets/img/banner319x619.jpg">';
	$US_bannersidemobile	    = get_theme_mod('US_bannerCategoryside_mobile') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerCategoryside_mobile')), 'full') : $US_bannerside;
	$US_bannersidelink    		= get_theme_mod('US_bannerCategorysideLink');
} else {
	$US_bannerside    		    = get_theme_mod('US_bannerHomeside') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerHomeside')), 'full') : '<img width="100%" height="auto" alt="banner" src="' . get_bloginfo('template_url') . '/assets/img/banner319x619.jpg">';
	$US_bannersidemobile	    = get_theme_mod('US_bannerHomeside_mobile') ? wp_get_attachment_image(attachment_url_to_postid(get_theme_mod('US_bannerHomeside_mobile')), 'full') : $US_bannerside;
	$US_bannersidelink    		= get_theme_mod('US_bannerHomesideLink');
}

$US_bannersideout       = $US_bannersidelink ? '<a class="visible-onlydesck" target="_blank" href="' . $US_bannersidelink . '">' . $US_bannerside . '</a>' : '<div class="visible-onlydesck">' . $US_bannerside . '</div>';
$US_bannersideoutmobile = $US_bannersidelink ? '<a class="visible-onlyphone" target="_blank" href="' . $US_bannersidelink . '">' . $US_bannersidemobile . '</a>' : '<div class="visible-onlyphone">' . $US_bannersidemobile . '</div>';

echo '<div class="sidebanner">' . $US_bannersideout . '' . $US_bannersideoutmobile . '</div>';
