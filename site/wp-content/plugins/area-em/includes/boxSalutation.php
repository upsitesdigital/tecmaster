<?php 
  $current_user = wp_get_current_user();
?>
<section id="boxSalutation">
  <div class="customContainer">
    <h2>Olá, <?php echo $current_user->display_name; ?>!</h2>
    <a href="<?php echo wp_logout_url( home_url() ); ?>" class="exit">Sair</a>
  </div>
</section>