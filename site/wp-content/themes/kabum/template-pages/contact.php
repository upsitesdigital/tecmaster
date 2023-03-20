<?php
/*
Template Name: Contato
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
    <div class="container">
      <div class="small">
        <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        <h1><?php the_title(); ?></h1>
        <div class="content">
          <?php the_content(); ?>
          <div class="form grid">
            <div class="content">
              <?php echo do_shortcode( get_field('formulario_de_contato') ); ?>
            </div>
            <div class="sidebar">
            <?php if(get_field('contatos_page')): ?>
                <?php while(has_sub_field('contatos_page')) : ?>
                    <p>
                        <?php if(get_sub_field('icone')) {
                            echo '<i class="fa '. get_sub_field('icone') .'" aria-hidden="true"></i> <br>';
                        } 
                        if(get_sub_field('texto')) {
                            $cont = str_replace('<p>', '', str_replace('</p>', '', get_sub_field('texto')));
                            echo $cont;
                        } ?>
                    </p>
                <?php endwhile; ?>
            <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end:page-content -->

</main>
<!-- end:main -->

<?php get_footer(); ?>




