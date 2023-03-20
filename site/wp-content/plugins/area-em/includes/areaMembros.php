<?php
class USAreaMembros_Shortcode extends USAreaMembros {
	
	public function __construct() {
		/*Shortcode*/
		add_shortcode('areaMembros', array( $this, 'areaMembros_shortcode' ));
	}

	/*Shortcode function*/
	public function areaMembros_shortcode() {
		ob_start();
    $assets_src = plugins_url('', __FILE__);
    ?>
    
    <style>
    </style>
    <?php if (is_user_logged_in()) { ?>
      <!-- equipmentForSale -->
      <div id="areaMembros">
        <!-- boxSalutation -->
        <?php include_once('boxSalutation.php'); ?>
        <!-- end:boxSalutation -->
      
        <!-- boxContent -->
        <section id="boxContent">
          <div class="customContainer customContent">
            <?php include_once('contentSidebar.php'); ?>
            
            <div id="contentBodyLoad" class="contentBody">
              <?php include_once('pages/init.php'); ?>
            </div>
          </div>
        </section>
        <!-- end:boxContent -->
      </div>
      <!-- end:equipmentForSale -->
    <?php } else { ?>
      <h2>vc não esta logodo</h2>
    <?php } ?>
    
    <?php
      wp_reset_postdata();
      return ob_get_clean();
	}      
}

$USAreaMembros_Shortcode = new USAreaMembros_Shortcode();

