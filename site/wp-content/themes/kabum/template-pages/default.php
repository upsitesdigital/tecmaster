<?php
/*
Template Name: Padrão
*/
get_header();
?>

<!-- main -->
<main>
  <!-- page-header -->
  <section id="page-header">
    <div class="container">
      <div class="image">
      <img src="<?php echo get_field('imagem_destacada')['url']; ?>" alt="<?php echo get_field('imagem_destacada')['alt']; ?>" width="100%">
      </div>
    </div>
  </section>
  <!-- end:page-header -->

  <!-- page-content -->
  <section id="page-content">
    <div class="container mobile-mbottom-50">
      <div class="small mobile-pbottom-50">
        <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        <h1><?php the_title(); ?></h1>
        <div class="content">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
  </section>
  <!-- end:page-content -->

</main>
<!-- end:main -->

<?php get_footer(); ?>




