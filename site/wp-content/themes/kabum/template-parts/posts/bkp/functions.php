<?php

require get_template_directory() . '/customizer-custom-controls/functions.php';

/** 
 * After theme setup hook actions
 */
add_action('after_setup_theme', function () {

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'institucional'    => __('Institucional Menu', 'kabum'),
			'category' => __('Category Menu', 'kabum'),
			'menu' => __('Top Menu', 'kabum'),
			'footer' => __('Footer Menu', 'kabum'),
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 197,
			'width'       => 50,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails');
	// add_image_size( 'card-thumb', 510, 287, true );
	// add_image_size( 'play-thumb', 730, 411, true );
	// add_image_size( 'author-thumb', 420, 420, true );

});

/** 
 * Load theme assets
 */
add_action('wp_enqueue_scripts', function () {
	$assets_src = get_template_directory_uri() . '/assets';
	$version = wp_get_theme()->get('Version');

	wp_enqueue_style('Ubuntu', 'https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap', array(), null, 'all');
	wp_enqueue_style('Kanit', 'https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), null, 'all');
	// wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), null, 'all' );
	wp_enqueue_style('font-awesome', "{$assets_src}/css/font-awesome.min.css", array(), null, 'all');
	// Load theme style
	if (strpos(get_bloginfo('url'), 'local.wp4') !== false) {
		wp_enqueue_style('theme', "{$assets_src}/css/main.css", [], $version, 'all');
	} else {
		wp_enqueue_style('theme', "{$assets_src}/css/main.min.css", [], $version, 'all');
	}

	// Load theme 
	if (strpos(get_bloginfo('url'), 'local.wp4') !== false) {
		wp_enqueue_script('theme', "{$assets_src}/js/bundle.js", ['jquery'], $version, true);
	} else {
		wp_enqueue_script('theme', "{$assets_src}/js/bundle.min.js", ['jquery'], $version, true);
	}
	wp_enqueue_script('flbuttons', "https://cdn.flipboard.com/web/buttons/js/flbuttons.min.js", ['jquery'], $version, true);
}, 999, 1);

//registrando visitas
function ed_set_post_views($postID)
{
	$count_key = 'ed_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
//Removendo pré-buscas para melhorar a precisão dos dados
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function ed_post_views_count($column)
{
	$column['ed_post_views_count'] = 'Visualizações';
	return $column;
}
add_filter('manage_posts_columns', 'ed_post_views_count');
function views_count_show_columns($name)
{
	global $post;
	switch ($name) {
		case 'ed_post_views_count':
			$views = get_post_meta($post->ID, 'ed_post_views_count', true);
			echo $views;
	}
}
add_action('manage_posts_custom_column',  'views_count_show_columns');



function hex2RGB($hex)
{
	$hex = str_replace("#", "", $hex);
	if (strlen($hex) == 3) {
		$r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
		$g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
		$b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
	} else {
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));
	}
	$rgb = array($r, $g, $b);
	return $rgb;
}

// remove cookies buttom
remove_action('set_comment_cookies', 'wp_set_comment_cookies');

// html output comment field
add_filter('comment_form_field_comment', 'my_comment_form_field_comment');
function my_comment_form_field_comment($field)
{
	$field = '<div class="comment"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" title="' . __('Comment', 'my-text-domain') . '" placeholder="Deixe seu cometário" aria-required="true"></textarea></div>';
	return $field;
}

// html output comment
function format_comment($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<h5><?php if ($comment->comment_type == 'wpdiscuz_sticky') {
					echo '<i class="fa fa-thumb-tack" aria-hidden="true"></i> ';
				} ?><?php printf(__('%s'), get_comment_author_link()) ?></h5> <span><?php echo get_comment_date(); ?> - <?php echo get_comment_time(); ?></span>
		<?php comment_text(); ?>
		<!-- div class="reply">
            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div -->
	</li>
<?php }

// upsites customize register.
function upsites_customize_register($wp_customize)
{

	$allposts = array();
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page'  => 40,
	);
	// $allposts[''] = 'Selecionar';
	$posts = new WP_Query($args);
	while ($posts->have_posts()) : $posts->the_post();
		$allposts[get_the_ID()] = get_the_title();
	endwhile;

	$allvideos = array();
	$args = array(
		'post_type' => 'kabumtv',
		'post_status' => 'publish',
		'posts_per_page'  => 20,
	);
	// $allvideos[''] = 'Selecionar';
	$videos = new WP_Query($args);
	while ($videos->have_posts()) : $videos->the_post();
		$allvideos[get_the_ID()] = get_the_title();
	endwhile;




	$wp_customize->add_section(
		'US_feturedhome',
		array(
			'title'    => 'Destaques home',
			'priority' => 201,
		)
	);
	$wp_customize->add_setting('US_posthome01', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(new upsite_Dropdown_Select2_Custom_Control(
		$wp_customize,
		'US_posthome01',
		array(
			'label' => 'Post destaque 01',
			'section' => 'US_feturedhome',
			'input_attrs' => array(
				'multiselect' => false,
			),
			'choices' => array(
				'posts' => $allposts,
				'videos' => $allvideos
			)
		)
	));
	$wp_customize->add_setting('US_posthome02', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(new upsite_Dropdown_Select2_Custom_Control(
		$wp_customize,
		'US_posthome02',
		array(
			'label' => 'Post destaque 02',
			'section' => 'US_feturedhome',
			'input_attrs' => array(
				'multiselect' => false,
			),
			'choices' => array(
				'posts' => $allposts,
				'videos' => $allvideos
			)
		)
	));
	$wp_customize->add_setting('US_posthome03', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(new upsite_Dropdown_Select2_Custom_Control(
		$wp_customize,
		'US_posthome03',
		array(
			'label' => 'Post destaque 03',
			'section' => 'US_feturedhome',
			'input_attrs' => array(
				'multiselect' => false,
			),
			'choices' => array(
				'posts' => $allposts,
				'videos' => $allvideos
			)
		)
	));
	$wp_customize->add_setting('US_posthome04', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(new upsite_Dropdown_Select2_Custom_Control(
		$wp_customize,
		'US_posthome04',
		array(
			'label' => 'Post destaque 04',
			'section' => 'US_feturedhome',
			'input_attrs' => array(
				'multiselect' => false,
			),
			'choices' => array(
				'posts' => $allposts,
				'videos' => $allvideos
			)
		)
	));
	/*$wp_customize->add_setting('US_posthome01', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_posthome01',
			array(
				'label' => 'Post destaque 01',
				'section' => 'US_feturedhome',
				'type'    => 'select',
				'choices' => $allposts
			)
		)
	);
	$wp_customize->add_setting('US_posthome02', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_posthome02',
			array(
				'label' => 'Post destaque 02',
				'section' => 'US_feturedhome',
				'type'    => 'select',
				'choices' => $allposts
			)
		)
	);
	$wp_customize->add_setting('US_posthome03', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_posthome03',
			array(
				'label' => 'Post destaque 03',
				'section' => 'US_feturedhome',
				'type'    => 'select',
				'choices' => $allposts
			)
		)
	);
	$wp_customize->add_setting('US_posthome04', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_posthome04',
			array(
				'label' => 'Post destaque 04',
				'section' => 'US_feturedhome',
				'type'    => 'select',
				'choices' => $allposts
			)
		)
	);*/

	$wp_customize->selective_refresh->add_partial('US_posthome01', array(
		'selector' => '#featured .grid .first',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_posthome02', array(
		'selector' => '#featured .grid .second',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_posthome03', array(
		'selector' => '#featured .grid .third',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_posthome04', array(
		'selector' => '#featured .grid .fourth',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));

	$wp_customize->add_section(
		'US_webstories',
		array(
			'title'    => 'Web stories',
			'priority' => 201,
		)
	);
	$wp_customize->add_setting('US_webstories_shortcode', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_webstories_shortcode', array(
		'type' => 'text',
		'section' => 'US_webstories',
		'label' => 'Shortcode',
	));


	$wp_customize->add_section(
		'US_authors',
		array(
			'title'    => 'Autores em destaque',
			'priority' => 201,
		)
	);
	$authors = get_users();
	$aut = array();
	$i = 0;
	foreach ($authors as $author) {
		if ($i == 0) {
			$autdefault = $author->display_name;
			$i++;
		}
		$aut[$author->ID] = $author->display_name;
	}
	$wp_customize->add_setting('US_aut01', array(
		'default'        => $autdefault,
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_aut01',
			array(
				'label' => 'Autor coluna 01',
				'section' => 'US_authors',
				'type'    => 'select',
				'choices' => $aut
			)
		)
	);
	$wp_customize->add_setting('US_aut02', array(
		'default'        => $autdefault,
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_aut02',
			array(
				'label' => 'Autor coluna 02',
				'section' => 'US_authors',
				'type'    => 'select',
				'choices' => $aut
			)
		)
	);
	$wp_customize->add_setting('US_aut03', array(
		'default'        => $autdefault,
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_aut03',
			array(
				'label' => 'Autor coluna 03',
				'section' => 'US_authors',
				'type'    => 'select',
				'choices' => $aut
			)
		)
	);


	$wp_customize->add_section(
		'US_categories',
		array(
			'title'    => 'Categorias',
			'priority' => 201,
		)
	);
	$categories = get_categories();
	$cats = array();
	$i = 0;
	foreach ($categories as $category) {
		if ($i == 0) {
			$default = $category->slug;
			$i++;
		}
		$cats[$category->slug] = $category->name;
	}
	$wp_customize->add_setting('US_cat01', array(
		'default'        => $default,
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_cat01',
			array(
				'label' => 'Categorias coluna 01',
				'section' => 'US_categories',
				'type'    => 'select',
				'choices' => $cats
			)
		)
	);
	$wp_customize->add_setting('US_cat02', array(
		'default'        => $default,
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_cat02',
			array(
				'label' => 'Categorias coluna 02',
				'section' => 'US_categories',
				'type'    => 'select',
				'choices' => $cats
			)
		)
	);
	$wp_customize->add_setting('US_cat03', array(
		'default'        => $default,
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'US_cat03',
			array(
				'label' => 'Categorias coluna 03',
				'section' => 'US_categories',
				'type'    => 'select',
				'choices' => $cats
			)
		)
	);



	$wp_customize->add_section(
		'US_socialMedia',
		array(
			'title'    => 'Social media',
			'priority' => 201,
		)
	);
	$wp_customize->add_setting('US_SM_title', array(
		'capability' => 'edit_theme_options',
		'default' => 'Rede sociais'
	));
	$wp_customize->add_control('US_SM_title', array(
		'type' => 'text',
		'section' => 'US_socialMedia',
		'label' => 'Titulo',
	));
	$wp_customize->add_setting('US_SM_facebook', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_SM_facebook', array(
		'type' => 'text',
		'section' => 'US_socialMedia',
		'label' => 'Link Facebook',
	));
	$wp_customize->add_setting('US_SM_linkedin', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_SM_linkedin', array(
		'type' => 'text',
		'section' => 'US_socialMedia',
		'label' => 'Link Linkedin',
	));
	$wp_customize->add_setting('US_SM_twitter', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_SM_twitter', array(
		'type' => 'text',
		'section' => 'US_socialMedia',
		'label' => 'Link Twitter',
	));
	$wp_customize->add_setting('US_SM_youtube', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_SM_youtube', array(
		'type' => 'text',
		'section' => 'US_socialMedia',
		'label' => 'Link Youtube',
	));
	$wp_customize->add_setting('US_SM_flipboard', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_SM_flipboard', array(
		'type' => 'text',
		'section' => 'US_socialMedia',
		'label' => 'Link Flipboard',
	));
	$wp_customize->add_setting('US_emailContact', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_emailContact', array(
		'type' => 'text',
		'section' => 'title_tagline',
		'label' => 'E-mail de contato',
	));
	$wp_customize->add_setting('logo_footer', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo_footer',
			array(
				'label'     => 'Logo Rodapé',
				'section'   => 'title_tagline',
				'settings'  => 'logo_footer',
			)
		)
	);

	$wp_customize->add_setting('US_postcustom_id', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_postcustom_id', array(
		'type' => 'text',
		'section' => 'title_tagline',
		'label' => 'ID do post',
	));
	$wp_customize->add_setting('US_postcustom_script', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_postcustom_script', array(
		'type' => 'textarea',
		'section' => 'title_tagline',
		'label' => 'Script do post',
	));

	$wp_customize->add_setting('US_autoload', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_autoload', array(
		'type' => 'checkbox',
		'section' => 'title_tagline',
		'label' => 'Autoload'
	));

	$wp_customize->add_setting('US_autoload_time', array(
		'default'        => '300',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_autoload_time', array(
		'type' => 'text',
		'section' => 'title_tagline',
		'label' => 'Tempo para o load',
		'description' => 'Tempo em segundos',
	));
	$wp_customize->add_setting('US_time_featuredNews', array(
		'default'        => '30',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_time_featuredNews', array(
		'type' => 'text',
		'section' => 'title_tagline',
		'label' => 'Intervalo Em Alta',
		'description' => 'Valor em dias',
	));

	$wp_customize->add_setting('US_tit_form_footer', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_tit_form_footer', array(
		'type' => 'text',
		'section' => 'title_tagline',
		'label' => 'Título formulário',
	));
	$wp_customize->add_setting('US_form_footer', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_form_footer', array(
		'type' => 'textarea',
		'section' => 'title_tagline',
		'label' => 'Formulário',
	));

	$wp_customize->selective_refresh->add_partial('US_SM_facebook', array(
		'selector' => '.socialMedia',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_emailContact', array(
		'selector' => '#emailContact',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('logo_footer', array(
		'selector' => '.links',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_tit_form_footer', array(
		'selector' => 'footer .newsletter',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));


	$wp_customize->selective_refresh->add_partial('US_cat01', array(
		'selector' => '#cat01',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_cat02', array(
		'selector' => '#cat02',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_cat03', array(
		'selector' => '#cat03',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));

	$wp_customize->add_panel(
		'US_banner',
		array(
			'priority'         => 202,
			'title'            => 'Banner',
			'description'      => 'banners sections',
		)
	);
	$wp_customize->add_section(
		'US_bannerHome',
		array(
			'title'    => 'Home',
			'priority' => 201,
			'panel'    => 'US_banner'
		)
	);
	$wp_customize->add_setting('US_bannerHomefull', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerHomefull',
			array(
				'label'     => 'Topo',
				'section'   => 'US_bannerHome',
				'settings'  => 'US_bannerHomefull',
			)
		)
	);
	/* mobile */
	$wp_customize->add_setting('US_bannerHomefull_mobile', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerHomefull_mobile',
			array(
				'label'     => 'Topo mobile',
				'section'   => 'US_bannerHome',
				'settings'  => 'US_bannerHomefull_mobile',
			)
		)
	);
	$wp_customize->add_setting('US_bannerHomefullLink', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_bannerHomefullLink', array(
		'type' => 'text',
		'section' => 'US_bannerHome',
		'label' => 'Link Full',
	));

	$wp_customize->add_setting('US_bannerHomeside', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerHomeside',
			array(
				'label'     => 'Lateral',
				'section'   => 'US_bannerHome',
				'settings'  => 'US_bannerHomeside',
			)
		)
	);
	/* mobile */
	$wp_customize->add_setting('US_bannerHomeside_mobile', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerHomeside_mobile',
			array(
				'label'     => 'Lateral mobile',
				'section'   => 'US_bannerHome',
				'settings'  => 'US_bannerHomeside_mobile',
			)
		)
	);
	$wp_customize->add_setting('US_bannerHomesideLink', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_bannerHomesideLink', array(
		'type' => 'text',
		'section' => 'US_bannerHome',
		'label' => 'Link Lateral',
	));
	$wp_customize->selective_refresh->add_partial('US_bannerHomefull', array(
		'selector' => '.home .fullbanner',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_bannerHomeside', array(
		'selector' => '.home .sidebanner',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));

	$wp_customize->add_section(
		'US_bannerSingle',
		array(
			'title'    => 'Single',
			'priority' => 201,
			'panel'    => 'US_banner'
		)
	);
	$wp_customize->add_setting('US_bannerSinglefull', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerSinglefull',
			array(
				'label'     => 'Topo',
				'section'   => 'US_bannerSingle',
				'settings'  => 'US_bannerSinglefull',
			)
		)
	);
	/* mobile */
	$wp_customize->add_setting('US_bannerSinglefull_mobile', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerSinglefull_mobile',
			array(
				'label'     => 'Topo mobile',
				'section'   => 'US_bannerSingle',
				'settings'  => 'US_bannerSinglefull_mobile',
			)
		)
	);
	$wp_customize->add_setting('US_bannerSinglefullLink', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_bannerSinglefullLink', array(
		'type' => 'text',
		'section' => 'US_bannerSingle',
		'label' => 'Link Topo',
	));
	$wp_customize->add_setting('US_bannerSingleside', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerSingleside',
			array(
				'label'     => 'Lateral',
				'section'   => 'US_bannerSingle',
				'settings'  => 'US_bannerSingleside',
			)
		)
	);
	/* mobile */
	$wp_customize->add_setting('US_bannerSingleside_mobile', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerSingleside_mobile',
			array(
				'label'     => 'Lateral mobile',
				'section'   => 'US_bannerSingle',
				'settings'  => 'US_bannerSingleside_mobile',
			)
		)
	);
	$wp_customize->add_setting('US_bannerSinglesideLink', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_bannerSinglesideLink', array(
		'type' => 'text',
		'section' => 'US_bannerSingle',
		'label' => 'Link Lateral',
	));
	$wp_customize->add_setting('US_bannerSinglemidle', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerSinglemidle',
			array(
				'label'     => 'Meio',
				'section'   => 'US_bannerSingle',
				'settings'  => 'US_bannerSinglemidle',
			)
		)
	);
	/* mobile */
	$wp_customize->add_setting('US_bannerSinglemidle_mobile', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerSinglemidle_mobile',
			array(
				'label'     => 'Meio mobile',
				'section'   => 'US_bannerSingle',
				'settings'  => 'US_bannerSinglemidle_mobile',
			)
		)
	);
	$wp_customize->add_setting('US_bannerSinglemidleLink', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_bannerSinglemidleLink', array(
		'type' => 'text',
		'section' => 'US_bannerSingle',
		'label' => 'Link Meio',
	));
	$wp_customize->selective_refresh->add_partial('US_bannerSinglefull', array(
		'selector' => '.single #featured .fullbanner',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_bannerSingleside', array(
		'selector' => '.single .sidebanner',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_bannerSinglemidle', array(
		'selector' => '.single #postCont .fullbanner',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));


	$wp_customize->add_section(
		'US_bannerCategory',
		array(
			'title'    => 'Category',
			'priority' => 201,
			'panel'    => 'US_banner'
		)
	);
	$wp_customize->add_setting('US_bannerCategoryfull', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerCategoryfull',
			array(
				'label'     => 'Topo',
				'section'   => 'US_bannerCategory',
				'settings'  => 'US_bannerCategoryfull',
			)
		)
	);
	/* mobile */
	$wp_customize->add_setting('US_bannerCategoryfull_mobile', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'US_bannerCategoryfull_mobile',
			array(
				'label'     => 'Topo mobile',
				'section'   => 'US_bannerCategory',
				'settings'  => 'US_bannerCategoryfull_mobile',
			)
		)
	);
	$wp_customize->add_setting('US_bannerCategoryfullLink', array(
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control('US_bannerCategoryfullLink', array(
		'type' => 'text',
		'section' => 'US_bannerCategory',
		'label' => 'Link Topo',
	));
	$wp_customize->selective_refresh->add_partial('US_bannerCategoryfull', array(
		'selector' => '.category .fullbanner',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
	$wp_customize->selective_refresh->add_partial('US_bannerCategoryfull', array(
		'selector' => '.page-template .fullbanner',
		'container_inclusive' => false,
		'render_callback' => 'dummy_function'
	));
}
add_action('customize_register', 'upsites_customize_register');

function US_paging_nav($color)
{
	$color = $color;

	if (is_singular())
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if ($wp_query->max_num_pages <= 1)
		return;

	$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
	$max   = intval($wp_query->max_num_pages);

	/** Add current page to the array */
	if ($paged >= 1)
		$links[] = $paged;

	/** Add the pages around the current page to the array */
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="pag" style="color:' . $color . '">' . "\n";

	/** Previous Post Link */
	if (get_previous_posts_link()) {
		printf('<a href="%s" class="prev"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_previous_posts_page_link());
	} else {
		printf('<a class="prev"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_previous_posts_page_link());
	}

	/** Link to first page, plus ellipses if necessary */
	if (!in_array(1, $links)) {
		$class = 1 == $paged ? ' class="current"' : '';

		printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

		if (!in_array(2, $links))
			echo '<span>…</span>';
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="current"' : '';
		printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
	}

	/** Link to last page, plus ellipses if necessary */
	if (!in_array($max, $links)) {
		if (!in_array($max - 1, $links))
			echo '<span>…</span>' . "\n";

		$class = $paged == $max ? ' class="current"' : '';
		printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
	}

	/** Next Post Link */
	if (get_next_posts_link()) {
		printf('<a href="%s" class="next"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_next_posts_page_link());
	} else {
		printf('<a class="next"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_next_posts_page_link());
	}
	echo '</div>' . "\n";
}

function US_paging_nav2($color, $posts, $paged, $maxpages)
{
	$color = $color;

	/** Stop execution if there's only 1 page */
	if ($posts->max_num_pages <= 1)
		return;

	//$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval($maxpages);

	/** Add current page to the array */
	if ($paged >= 1)
		$links[] = $paged;

	/** Add the pages around the current page to the array */
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="pag" style="color:' . $color . '">' . "\n";

	/** Previous Post Link */
	if (get_previous_posts_link()) {
		printf('<a rel="prev" href="%s" class="prev"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_previous_posts_page_link());
	} else {
		printf('<a href="#" rel="prev" class="prev"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_previous_posts_page_link());
	}

	/** Link to first page, plus ellipses if necessary */
	if (!in_array(1, $links)) {
		$class = 1 == $paged ? ' class="current"' : '';

		printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

		if (!in_array(2, $links))
			echo '<span>…</span>';
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="current"' : '';
		printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
	}

	/** Link to last page, plus ellipses if necessary */
	if (!in_array($max, $links)) {
		if (!in_array($max - 1, $links))
			echo '<span>…</span>' . "\n";

		$class = $paged == $max ? ' class="current"' : '';
		printf('<a%s href="%s">%s</a>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
	}

	/** Next Post Link */
	if (get_next_posts_link('next', $posts->max_num_pages)) {
		printf('<a rel="next" href="%s" class="next"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_next_posts_page_link());
	} else {
		printf('<a href="#" rel="next" class="next"><svg class="icon"><use xlink:href="' . get_bloginfo('template_url') . '/assets/img/icons.svg#arrow"></use></svg> </a>' . "\n", get_next_posts_page_link());
	}
	echo '</div>' . "\n";
}

function clean_custom_menus()
{
	$menu_name = 'menu'; // specify custom menu slug
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		/*echo '<pre>';
		var_dump($menu_items);
		echo '</pre>';*/
		$menu_list = '<nav class="menu">';
		$menu_list .= '<ul>';
		foreach ((array) $menu_items as $key => $menu_item) {
			$id = $menu_item->object_id;
			$title = $menu_item->title;
			$url = $menu_item->url;
			$termColor = get_field('cor', 'category_' . $id) ? get_field('cor', 'category_' . $id) : '#fd6519';
			$menu_list .= '<li style="color:' . $termColor . '"><a href="' . $url . '">' . $title . '</a></li>';
		}
		//$menu_list .= '<li id="megaMenu" style="color:#fd6519"><a href="">Mais <svg class="icon"><use xlink:href="'. get_bloginfo('template_url') .'/assets/img/icons.svg#arrow"></use></svg></a></li>';
		$menu_list .= '</ul>';
		$menu_list .= '</nav>';
	} else {
		// $menu_list = '<!-- no list defined -->';
	}
	echo $menu_list;
}

function searchFilter($query)
{
	if ($query->is_search) {
		if (!isset($query->query_vars['post_type'])) {
			$query->set('post_type', 'post');
		}
	}
	return $query;
}
add_filter('pre_get_posts', 'searchFilter');

function colorPost()
{
	$v = get_query_var("global_vars") ? get_query_var("global_vars") : 'null';
	if ($v != 'null') {
		$tcolor_arr[] = $v["color"];
	} else {
		if (get_queried_object() && !is_single() && !is_page() && !is_author()) {
			$tcolor_arr[] = get_field('cor', 'category_' . get_queried_object()->term_id);
		} else {
			$tcolor_arr[] = get_field('categoria_principal') ? get_field('cor', 'category_' . get_field('categoria_principal')) : '';
		}
	}
	return $tcolor_arr;
}

function slugPost()
{
	$v = get_query_var("global_vars") ? get_query_var("global_vars") : 'null';
	if ($v != 'null') {
		$tslugs_arr[] = $v["tag"];
	} else {
		if (get_queried_object() && !is_single() && !is_page() && !is_author()) {
			$tslugs_arr[] = get_queried_object()->slug;
		} else {
			$tslugs_arr[] = get_field('categoria_principal') ? get_term(get_field('categoria_principal'))->slug : '';
		}
	}
	return $tslugs_arr;
}

function namePost()
{
	$v = get_query_var("global_vars") ? get_query_var("global_vars") : 'null';
	if ($v != 'null') {
		$tnames_arr[] = $v["tag"];
	} else {
		if (get_queried_object() && !is_single() && !is_page() && !is_author()) {
			$tnames_arr[] = get_queried_object()->name;
		} else {
			$tnames_arr[] = get_field('categoria_principal') ? get_term(get_field('categoria_principal'))->name : '';
		}
	}
	return $tnames_arr;
}

/**
 * Removes some menus by page.
 */
function US_remove_menus()
{
	remove_menu_page('edit.php?post_type=acf-field-group');
	remove_menu_page('cptui_main_menu');
}
add_action('admin_menu', 'US_remove_menus');


function USFormatGallery($string, $attr)
{
	static $instance = 0;
	$instance++;
	$output = '<div class="slick-slider-postimg" id="slick-slider-postimg-' . $instance . '">';
	$output .= '<div class="box-postimg">';
	$posts = get_posts(array('include' => $attr['ids'], 'post_type' => 'attachment'));

	$output .= '<div class="featured-postimg">';
	foreach ($posts as $imagePost) {
		$output .= '<a data-fancybox="gallery-' . $instance . '" class="postimg" href="' . wp_get_attachment_image_src($imagePost->ID, 'full')[0] . '" style="background-image: url(' . wp_get_attachment_image_src($imagePost->ID, 'large')[0] . ');"></a>';
	}
	$output .= '</div>';

	$output .= '<div class="list-postimg">';
	foreach ($posts as $imagePost) {
		$output .= '<img src="' . wp_get_attachment_image_src($imagePost->ID, 'thumbnail')[0] . '">';
	}
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_filter('post_gallery', 'USFormatGallery', 10, 2);

function US_search_by_title_only($search, $wp_query)
{
	global $wpdb;

	if (empty($search))
		return $search; // skip processing - no search term in query

	$q = $wp_query->query_vars;
	$n = !empty($q['exact']) ? '' : '%';

	$search =
		$searchand = '';

	foreach ((array) $q['search_terms'] as $term) {
		$term = esc_sql($term);
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}

	if (!empty($search)) {
		$search = " AND ({$search}) ";
		if (!is_user_logged_in())
			$search .= " AND ($wpdb->posts.post_password = '') ";
	}

	return $search;
}
add_filter('posts_search', 'US_search_by_title_only', 500, 2);

/**
 * Add Featured Image to RSS feed
 *
 **/
add_filter('pre_get_posts', 'feed_add_enclosure');
function feed_add_enclosure($query)
{
	if ($query->is_feed) {
		add_filter('rss2_item', 'feed_enclosure');
	}
	return $query;
}
function feed_enclosure($item)
{
	global $post;
	$attachments = get_field('imagem_destacada', $post->ID);
	if ($attachments) {
		$image = $attachments['url'];
		$mime  = $attachments['mime_type'];
		$filesize  = $attachments['filesize'];
		echo '<enclosure url="' . $image . '" length="' . $filesize . '" type="' . $mime . '"/>';
	}
	return $item;
}

add_filter('the_excerpt_rss', 'US_featured_image_in_feed');
add_filter('the_content_feed', 'US_featured_image_in_feed');
function US_featured_image_in_feed($content)
{
	global $post;
	if (is_feed()) {
		$attachments = get_field('imagem_destacada', $post->ID);
		if ($attachments) {
			$feat_image_output = '<p><img width="100%" src="' . $attachments['url'] . '" alt="' . $attachments['alt'] . '" /></p>';
			$content = $feat_image_output . $content;
		}
	}
	return $content;
}


add_filter('acf/fields/relationship/query', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query($args, $field, $post_id)
{
	$args['orderby'] = 'date';
	$args['order'] = 'DESC';

	return $args;
}

add_action('template_redirect', function () {
	ob_start(function ($buffer) {
		$buffer = str_replace(array(' type="text/css"', " type='text/css'"), '', $buffer);
		$buffer = str_replace(array(' type="text/javascript"', " type='text/javascript'"), '', $buffer);
		return $buffer;
	});
});
