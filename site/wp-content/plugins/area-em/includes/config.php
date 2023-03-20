<?php


function US_cpt_files() {

  /**
   * Post Type: Arquivos.
   */

  $labels = [
    "name" => __( "Arquivos", "UpSites" ),
    "singular_name" => __( "Arquivo", "UpSites" ),
  ];

  $args = [
    "label" => __( "Arquivos", "UpSites" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => [ "slug" => "arquivos", "with_front" => true ],
    "query_var" => true,
    "supports" => [ "title", "editor" ],
    "taxonomies" => [ "category_files" ],
    "show_in_graphql" => false,
  ];

  register_post_type( "arquivos", $args );
}
add_action( 'init', 'US_cpt_files' );

function US_cpt_category_files() {

	/**
	 * Taxonomy: Especialidades.
	 */

	$labels = [
		"name" => __( "Categorias", "UpSites" ),
		"singular_name" => __( "Categoria", "UpSites" ),
	];

	
	$args = [
		"label" => __( "Categorias", "UpSites" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'category_files', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "category_files",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "category_files", [ "arquivos" ], $args );
}
add_action( 'init', 'US_cpt_category_files' );


// Add a new top level menu link to the ACP
function US_fields()
{
  if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
      'page_title'  =>  'Área de membros',
      'menu_title'  =>  'Área de membros',
      'capability'  =>  'edit_posts',
      'icon_url'    =>  'dashicons-admin-generic',
      'position'    =>  2,
      'redirect'    =>  false
    ));
  }
  if( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
      'key' => 'config_group_1',
      'title' => 'Configurações',
      'fields' => array (
        array (
          'key' => 'field_txt_default',
          'label' => 'Texto página inicial',
          'name' => 'txt_pag_init',
          'type' => 'textarea',
        )
      ),
      'location' => array (
        array (
          array (
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'acf-options-area-de-membros',
          ),
        ),
      ),
    ));

    acf_add_local_field_group(array(
      'key' => 'config_group_2',
      'title' => 'Users',
      'fields' => array(
        array(
          'key' => 'field_user_default',
          'label' => 'users',
          'name' => 'users',
          'type' => 'user',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'role' => '',
          'allow_null' => 0,
          'multiple' => 1,
          'return_format' => 'array',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'arquivos',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    ));

    acf_add_local_field_group(array(
      'key' => 'config_group_3',
      'title' => 'Arquivo',
      'fields' => array(
        array(
          'key' => 'field_arquivo_default',
          'label' => 'Arquivo',
          'name' => 'arquivo',
          'type' => 'file',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'return_format' => 'array',
          'library' => 'all',
          'min_size' => '',
          'max_size' => '',
          'mime_types' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'arquivos',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'side',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    ));

  };
  
}
add_action( 'init', 'US_fields' );
