<?php 
$uriParts = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] ); 
require_once( $uriParts[0] . 'wp-load.php' );
?>
<div class="profile">
  <h2>Conta</h2>
  <?php
    $current_user = wp_get_current_user();
  ?>
  <form method="post" id="adduser" action="<?php the_permalink(); ?>">
  <div class="boxForm">
    <div class="boxField form-username">
      <label for="first-name"><?php _e('Primeiro nome', 'profile'); ?></label>
      <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
    </div><!-- .form-username -->
    <div class="boxField form-username">
      <label for="last-name"><?php _e('Último nome', 'profile'); ?></label>
      <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
    </div><!-- .form-username -->
    <div class="boxField form-email">
      <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
      <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
    </div><!-- .form-email -->
    <p class="support">* Por motivo desegurança os dados acima não poderão ser alterados,
      caso precisar alterar entre em contato pelo telefone (99) 2345-1234
      ou email@empresa.com.br</p>
  </div>
  <h3>Alterar Senha</h3>
  <div class="boxForm">
    <div class="boxField form-password">
      <label for="pass1"><?php _e('Senha *', 'profile'); ?> </label>
      <input class="text-input" name="pass1" type="password" id="pass1" />
    </div><!-- .form-password -->
    <div class="boxField form-password">
      <label for="pass2"><?php _e('Repetir senha *', 'profile'); ?></label>
      <input class="text-input" name="pass2" type="password" id="pass2" />
    </div><!-- .form-password -->

    <div class="form-submit">
      <?php echo $referer; ?>
      <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Atualizar', 'profile'); ?>" />
      <?php wp_nonce_field( 'update-user' ) ?>
      <input name="action" type="hidden" id="action" value="update-user" />
    </div><!-- .form-submit -->
  </div>
  </form><!-- #adduser -->
</div>