<?php

/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$autoload    	  = get_theme_mod('US_autoload');
$timeautoload   = strval(get_theme_mod('US_autoload_time'));
if ($autoload) {
	$autoload = 'data-autoload="true" data-autoloadtime="' . $timeautoload . '"';
};
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<title>Tecmasters</title>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="text/html; charset=UTF-8" name="Content-Type">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
	</style>
	<!-- Google ADs -->
	<script data-ad-client="ca-pub-8418522754531700" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- End Google ADs -->
</head>

<body <?php body_class(); ?> <?php echo $autoload; ?>>

	<?php
	get_template_part('template-parts/header');
