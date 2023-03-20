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

$termColor = '#FD6519';
?>

<!-- main -->
<main>
  <!-- featured -->
  <section id="page-header">

  </section>
  <!-- end:featured -->

  <!-- page-content -->
  <section id="page-content">
    <div class="container">
      <div class="small">
        <div class="content pbottom-50" style="text-align: center">
          <img src="<?php bloginfo('template_url'); ?>/assets/img/404.svg">
          <h1>Ooops...</h1>
          <p>Alguém deu um delete neste conteúdo ou ele deve estar em alguma gameplay!</p>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn">Ir para home</a>
        </div>
      </div>
    </div>
  </section>
  <!-- end:page-content -->

</main>
<!-- end:main -->
