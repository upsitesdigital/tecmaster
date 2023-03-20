<?php 
function loginAreaMembros() {
  ob_start();
    ?>
  
  <!-- equipmentForSale -->
  <div id="loginAreaMembros">
    <!-- boxLogin -->
    <section id="boxLogin">
      <h2>Acesse sua área</h2>
      <div class="boxForm">
        <?php 
        wp_login_form( 
          array(
            'redirect'       => 'http://localhost/projetos/labwp/perfil/',
            'label_username' => __( 'E-mail' ),
            'label_password' => __( 'Senha' ),
            //'label_remember' => __( 'Lembrar-me' ),
            'label_log_in'   => __( 'Entre em contato' ),
            'remember'       => false,
          )
        );
        ?>
        <script type="text/javascript">
          jQuery(document).on('click', '#openlostpasswordform', function() {
            jQuery('#lostpasswordform').slideToggle();
            return false;
          });
        </script>
        <a href="#" id="openlostpasswordform" class="lostPassword">Esqueci minha senha</a>

        <?php 
        echo '<form style="display:none; padding: 20px 0 0 0" name="lostpasswordform" id="lostpasswordform" action="' . get_site_url() . '/wp-login.php?action=lostpassword" method="post">
          <p>
            <label for="user_login">Nome de usuário ou endereço de e-mail</label>
            <input type="text" name="user_login" id="user_login" class="input" value="" size="20" autocapitalize="off">
          </p>
          <input type="hidden" name="redirect_to" value="">
          <p class="submitBtn">
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Obter nova senha">
          </p>
        </form>';
        ?>
      </div>
    </section>
    <!-- end:boxLogin -->
  </div>
  <!-- end:equipmentForSale -->
    <?php
    wp_reset_postdata();
    return ob_get_clean();
  }
add_shortcode('loginAreaMembros', 'loginAreaMembros');


