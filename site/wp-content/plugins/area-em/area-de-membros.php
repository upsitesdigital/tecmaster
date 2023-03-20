<?php
/*
Plugin Name: Area de membros EM
Plugin URI: http://upsites.digital
Description: Um plugin de Area de membros
Version: 1.1.35
Author: Upsites
Author URI: http://upsites.digital
License: GPLv2
*/

?>

<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class USAreaMembros {
  public function __construct() {
    require_once(dirname(__FILE__) . '/includes/config.php');
    require_once(dirname(__FILE__) . '/includes/loginAreaMembros.php');
    require_once(dirname(__FILE__) . '/includes/areaMembros.php');
  }
  public function US_membros() {
    
    add_action('after_setup_theme', 'remove_admin_bar');
    function remove_admin_bar() {
      $user = wp_get_current_user();
      if (in_array('subscriber', $user->roles)){
        show_admin_bar(false);
      }
    }

  }
  public function activate() {
    $this->US_membros();
    flush_rewrite_rules();
  }
  public function deactivate() {
    flush_rewrite_rules();
  }
  public function uninstall() {
    flush_rewrite_rules();
  }
}

if(class_exists('USAreaMembros')) {
  $USAreaMembros = new USAreaMembros();
  register_activation_hook( __FILE__, array($USAreaMembros, 'activate') );
  register_deactivation_hook( __FILE__, array($USAreaMembros, 'deactivate') );
  register_uninstall_hook( __FILE__, array($USAreaMembros, 'uninstall') );
}

class USAreaMembrosStyle extends USAreaMembros {

	public function __construct() {
		/*Add style in wp-admin footer*/
		add_action('wp_enqueue_scripts', array( $this, 'areaMembrosStyle' ) );
    add_action( 'wp_ajax_pluginAjax', 'pluginAjax_callback' );
    add_action( 'wp_ajax_nopriv_pluginAjax', 'pluginAjax_callback' );  
	}

	/*Add style in wp-admin footer*/
	public function areaMembrosStyle() {
		$assets_src = plugins_url('', __FILE__);
    $version = wp_get_theme()->get( 'Version' );

    // Load theme style
    wp_enqueue_style( 'pluginStyle', "{$assets_src}/assets/css/main.css", [], $version, 'all' );
    wp_enqueue_script( 'pluginAjax', "{$assets_src}/assets/js/bundle.js", array('jquery'), '1.1.35');
    wp_localize_script( 'pluginAjax', 'pluginloadpostajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

}

$USAreaMembrosStyle = new USAreaMembrosStyle();

add_action( 'wp_ajax_pageList', 'pageList_function' );
add_action( 'wp_ajax_nopriv_pageList', 'pageList_function' );
function pageList_function(){
  $action            = $_POST['action'];
  $page              = $_POST['page'];
  $query             = $_POST['query']; 
  $name              = $_POST['name'];
  $a =  "<div>" . $action . ': ' . plugins_url('', __FILE__) . '/includes/pages/' . $page . "</div>";
  echo $a;

  if($action == 'pageList') {
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
    <?php
  } elseif($action == 'postList') {
    ?>
      <div class="list">
        <h2><?php echo $name; ?></h2>
        <?php 
        $my_args = array(
          'post_type' => 'arquivos',
          'posts_per_page'  => -1,
          'orderby' => 'date',
          'order' => 'DESC',
          'tax_query' => array(
            'relation' => 'AND',
            array(
              'taxonomy' => 'category_files',
              'field'    => 'slug',
              'terms'    => array( $query ),
            ),
          ),
        );
        $my_query = new WP_Query( $my_args );
        echo '<ul>';
          while ( $my_query->have_posts() ) : $my_query->the_post();
            echo '<li>';
              echo '<h3>';
                echo get_the_title();
              echo '</h3>';
              echo get_the_content();
            echo '</li>';
          endwhile; // End of the loop.
        echo '</ul>';
        ?>
      </div>
    <?php
  } elseif($action == 'init') {
    $current_user = wp_get_current_user();
    ?>
      <div class="init">
        <h2>Início</h2>
        <p>Olá, <?php echo $current_user->display_name; ?>!<br>Seja bem-vindo a área de membros da Upsites!</p>
        <p>A área feita exclusivamente para a sua empresa! <br>Aqui você terá acesso a diversos conteúdos
          disponibilizados com intuito de facilitar nossa comunicação e tornar o processo mais eficiente.</p>
        <p>Você poderá encontrar cada uma das Guias de Pagamento, Contratos, Relatórios Mensais, Holerites, etc. </p>
      </div>
    <?php
  }

  wp_die(); // ajax call must die to avoid trailing 0 in your response
}


?>

