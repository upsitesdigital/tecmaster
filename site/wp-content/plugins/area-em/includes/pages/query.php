<? header("Access-Control-Allow-Origin: *"); ?>
<?php 
$uriParts = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] ); 
require_once( $uriParts[0] . 'wp-load.php' );

$query = $_POST['query']; 
$name = $_POST['name']; 

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