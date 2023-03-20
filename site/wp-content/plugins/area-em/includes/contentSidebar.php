<div class="contentSidebar">
  <ul>
    <li class="act"><a href="#" data-box="init">Início</a></li>
    <?php 
      $args = array(
        'taxonomy' => 'category_files',
        'orderby' => 'name',
        'order' => 'DESC',
      );
      
      function listTaxonomies($taxonomy,$term_id) {
          $output = '';
          //echo $taxonomy . ' : ' . $term_id;
          $args = array(
              'taxonomy' => $taxonomy,
              'parent' => $term_id
          );
          $categories = get_terms($args);
          
          if($categories) {
            echo '<ul>';
              foreach( $categories as $category ) {
                echo '<li><a href="" data-box="padrao" data-query="' . $category->slug . '">' . $category->name . '</a>';
                echo listTaxonomies($taxonomy,$category->term_id);
                echo  '</li>';
              }
              echo  '</ul>';
          }
          return $output;
      }
      $taxonomy = 'category_files';
      
      listTaxonomies($taxonomy, '0');
    ?>
    <li><a href="" data-box="profile">Conta</a></li>
  </ul>
</div>