<?php
/*
Template Name: Quem somos
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
        </div>
      </div>
      <?php if(get_field('imagem_boxImagem') != '' && get_field('texto_boxImagem') != '') { ?>
      <div class="full imageCols">
        <div class="image">
          <img src="<?php the_field('imagem_boxImagem'); ?>" width="100%">
        </div>
        <div class="content">
        <?php the_field('texto_boxImagem'); ?>
        </div>
      </div>
      <?php }; ?>
    </div>
  </section>
  <!-- end:page-content -->

  <!-- team -->
  <section id="team">
    <div class="container">
      <h2>EQUIPE</h2>
      <div class="grid">
        <?php if(get_field('team')): ?>
            <?php while(has_sub_field('team')) : ?>
              <?php if(get_sub_field('link')) { ?><a href="<?php the_sub_field('link'); ?>" class="item"><?php } else { ?><div class="item"><?php }; ?>
                <img src="<?php the_sub_field('imagem'); ?>" width="100%">
                <h3><?php the_sub_field('nome'); ?></h3>
                <span><?php the_sub_field('cargo'); ?></span>
              <?php if(get_sub_field('link')) { ?></a><?php } else { ?></div><?php }; ?>
            <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- end:team -->

</main>
<!-- end:main -->

<?php get_footer(); ?>




