<?php

/**
 * Enqueue scripts and styles.
 * Our sample Social Icons are using Font Awesome icons so we need to include the FA CSS when viewing our site
 * The Single Accordion Control is also displaying some FA icons in the Customizer itself, so we need to enqueue FA CSS in the Customizer too
 *
 * @return void
 */
if (!function_exists('upsite_scripts_styles')) {
	function upsite_scripts_styles()
	{
		// Register and enqueue our icon font
		// We're using the awesome Font Awesome icon font. http://fortawesome.github.io/Font-Awesome
		//wp_register_style('fontawesome', trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/css/fontawesome-all.min.css', array(), '5.8.2', 'all');
		//wp_enqueue_style('fontawesome');
	}
}
add_action('wp_enqueue_scripts', 'upsite_scripts_styles');
add_action('customize_controls_print_styles', 'upsite_scripts_styles');

/**
 * Enqueue scripts for our Customizer preview
 *
 * @return void
 */
if (!function_exists('upsite_customizer_preview_scripts')) {
	function upsite_customizer_preview_scripts()
	{
		wp_enqueue_script('upsite-customizer-preview', trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/js/customizer-preview.js', array('customize-preview', 'jquery'));
	}
}
add_action('customize_preview_init', 'upsite_customizer_preview_scripts');

/**
 * Check if WooCommerce is active
 * Use in the active_callback when adding the WooCommerce Section to test if WooCommerce is activated
 *
 * @return boolean
 */
function upsite_is_woocommerce_active()
{
	if (class_exists('woocommerce')) {
		return true;
	}
	return false;
}

/**
 * Set our Social Icons URLs.
 * Only needed for our sample customizer preview refresh
 *
 * @return array Multidimensional array containing social media data
 */
if (!function_exists('upsite_generate_social_urls')) {
	function upsite_generate_social_urls()
	{
		$social_icons = array(
			array('url' => 'behance.net', 'icon' => 'fab fa-behance', 'title' => esc_html__('Follow me on Behance', 'upsite'), 'class' => 'behance'),
			array('url' => 'bitbucket.org', 'icon' => 'fab fa-bitbucket', 'title' => esc_html__('Fork me on Bitbucket', 'upsite'), 'class' => 'bitbucket'),
			array('url' => 'codepen.io', 'icon' => 'fab fa-codepen', 'title' => esc_html__('Follow me on CodePen', 'upsite'), 'class' => 'codepen'),
			array('url' => 'deviantart.com', 'icon' => 'fab fa-deviantart', 'title' => esc_html__('Watch me on DeviantArt', 'upsite'), 'class' => 'deviantart'),
			array('url' => 'discord.gg', 'icon' => 'fab fa-discord', 'title' => esc_html__('Join me on Discord', 'upsite'), 'class' => 'discord'),
			array('url' => 'dribbble.com', 'icon' => 'fab fa-dribbble', 'title' => esc_html__('Follow me on Dribbble', 'upsite'), 'class' => 'dribbble'),
			array('url' => 'etsy.com', 'icon' => 'fab fa-etsy', 'title' => esc_html__('favorite me on Etsy', 'upsite'), 'class' => 'etsy'),
			array('url' => 'facebook.com', 'icon' => 'fab fa-facebook-f', 'title' => esc_html__('Like me on Facebook', 'upsite'), 'class' => 'facebook'),
			array('url' => 'flickr.com', 'icon' => 'fab fa-flickr', 'title' => esc_html__('Connect with me on Flickr', 'upsite'), 'class' => 'flickr'),
			array('url' => 'foursquare.com', 'icon' => 'fab fa-foursquare', 'title' => esc_html__('Follow me on Foursquare', 'upsite'), 'class' => 'foursquare'),
			array('url' => 'github.com', 'icon' => 'fab fa-github', 'title' => esc_html__('Fork me on GitHub', 'upsite'), 'class' => 'github'),
			array('url' => 'instagram.com', 'icon' => 'fab fa-instagram', 'title' => esc_html__('Follow me on Instagram', 'upsite'), 'class' => 'instagram'),
			array('url' => 'kickstarter.com', 'icon' => 'fab fa-kickstarter-k', 'title' => esc_html__('Back me on Kickstarter', 'upsite'), 'class' => 'kickstarter'),
			array('url' => 'last.fm', 'icon' => 'fab fa-lastfm', 'title' => esc_html__('Follow me on Last.fm', 'upsite'), 'class' => 'lastfm'),
			array('url' => 'linkedin.com', 'icon' => 'fab fa-linkedin-in', 'title' => esc_html__('Connect with me on LinkedIn', 'upsite'), 'class' => 'linkedin'),
			array('url' => 'medium.com', 'icon' => 'fab fa-medium-m', 'title' => esc_html__('Follow me on Medium', 'upsite'), 'class' => 'medium'),
			array('url' => 'patreon.com', 'icon' => 'fab fa-patreon', 'title' => esc_html__('Support me on Patreon', 'upsite'), 'class' => 'patreon'),
			array('url' => 'pinterest.com', 'icon' => 'fab fa-pinterest-p', 'title' => esc_html__('Follow me on Pinterest', 'upsite'), 'class' => 'pinterest'),
			array('url' => 'plus.google.com', 'icon' => 'fab fa-google-plus-g', 'title' => esc_html__('Connect with me on Google+', 'upsite'), 'class' => 'googleplus'),
			array('url' => 'reddit.com', 'icon' => 'fab fa-reddit-alien', 'title' => esc_html__('Join me on Reddit', 'upsite'), 'class' => 'reddit'),
			array('url' => 'slack.com', 'icon' => 'fab fa-slack-hash', 'title' => esc_html__('Join me on Slack', 'upsite'), 'class' => 'slack.'),
			array('url' => 'slideshare.net', 'icon' => 'fab fa-slideshare', 'title' => esc_html__('Follow me on SlideShare', 'upsite'), 'class' => 'slideshare'),
			array('url' => 'snapchat.com', 'icon' => 'fab fa-snapchat-ghost', 'title' => esc_html__('Add me on Snapchat', 'upsite'), 'class' => 'snapchat'),
			array('url' => 'soundcloud.com', 'icon' => 'fab fa-soundcloud', 'title' => esc_html__('Follow me on SoundCloud', 'upsite'), 'class' => 'soundcloud'),
			array('url' => 'spotify.com', 'icon' => 'fab fa-spotify', 'title' => esc_html__('Follow me on Spotify', 'upsite'), 'class' => 'spotify'),
			array('url' => 'stackoverflow.com', 'icon' => 'fab fa-stack-overflow', 'title' => esc_html__('Join me on Stack Overflow', 'upsite'), 'class' => 'stackoverflow'),
			array('url' => 'tumblr.com', 'icon' => 'fab fa-tumblr', 'title' => esc_html__('Follow me on Tumblr', 'upsite'), 'class' => 'tumblr'),
			array('url' => 'twitch.tv', 'icon' => 'fab fa-twitch', 'title' => esc_html__('Follow me on Twitch', 'upsite'), 'class' => 'twitch'),
			array('url' => 'twitter.com', 'icon' => 'fab fa-twitter', 'title' => esc_html__('Follow me on Twitter', 'upsite'), 'class' => 'twitter'),
			array('url' => 'vimeo.com', 'icon' => 'fab fa-vimeo-v', 'title' => esc_html__('Follow me on Vimeo', 'upsite'), 'class' => 'vimeo'),
			array('url' => 'weibo.com', 'icon' => 'fab fa-weibo', 'title' => esc_html__('Follow me on weibo', 'upsite'), 'class' => 'weibo'),
			array('url' => 'youtube.com', 'icon' => 'fab fa-youtube', 'title' => esc_html__('Subscribe to me on YouTube', 'upsite'), 'class' => 'youtube'),
		);

		return apply_filters('upsite_social_icons', $social_icons);
	}
}

/**
 * Return an unordered list of linked social media icons, based on the urls provided in the Customizer Sortable Repeater
 * This is a sample function to display some social icons on your site.
 * This sample function is also used to show how you can call a PHP function to refresh the customizer preview.
 * Add the following code to header.php if you want to see the sample social icons displayed in the customizer preview and your theme.
 * Before any social icons display, you'll also need to add the relevent URL's to the Header Navigation > Social Icons section in the Customizer.
 * <div class="social">
 *	 <?php echo upsite_get_social_media(); ?>
 * </div>
 *
 * @return string Unordered list of linked social media icons
 */
if (!function_exists('upsite_get_social_media')) {
	function upsite_get_social_media()
	{
		$defaults = upsite_generate_defaults();
		$output = array();
		$social_icons = upsite_generate_social_urls();
		$social_urls = explode(',', get_theme_mod('social_urls', $defaults['social_urls']));
		$social_newtab = get_theme_mod('social_newtab', $defaults['social_newtab']);
		$social_alignment = get_theme_mod('social_alignment', $defaults['social_alignment']);
		$contact_phone = get_theme_mod('contact_phone', $defaults['contact_phone']);

		if (!empty($contact_phone)) {
			$output[] = sprintf(
				'<li class="%1$s"><i class="%2$s"></i>%3$s</li>',
				'phone',
				'fas fa-phone fa-flip-horizontal',
				$contact_phone
			);
		}

		foreach ($social_urls as $key => $value) {
			if (!empty($value)) {
				$domain = str_ireplace('www.', '', parse_url($value, PHP_URL_HOST));
				$index = array_search(strtolower($domain), array_column($social_icons, 'url'));
				if (false !== $index) {
					$output[] = sprintf(
						'<li class="%1$s"><a href="%2$s" title="%3$s"%4$s><i class="%5$s"></i></a></li>',
						$social_icons[$index]['class'],
						esc_url($value),
						$social_icons[$index]['title'],
						(!$social_newtab ? '' : ' target="_blank"'),
						$social_icons[$index]['icon']
					);
				} else {
					$output[] = sprintf(
						'<li class="nosocial"><a href="%2$s"%3$s><i class="%4$s"></i></a></li>',
						$social_icons[$index]['class'],
						esc_url($value),
						(!$social_newtab ? '' : ' target="_blank"'),
						'fas fa-globe'
					);
				}
			}
		}

		if (get_theme_mod('social_rss', $defaults['social_rss'])) {
			$output[] = sprintf(
				'<li class="%1$s"><a href="%2$s" title="%3$s"%4$s><i class="%5$s"></i></a></li>',
				'rss',
				home_url('/feed'),
				'Subscribe to my RSS feed',
				(!$social_newtab ? '' : ' target="_blank"'),
				'fas fa-rss'
			);
		}

		if (!empty($output)) {
			$output = apply_filters('upsite_social_icons_list', $output);
			array_unshift($output, '<ul class="social-icons ' . $social_alignment . '">');
			$output[] = '</ul>';
		}

		return implode('', $output);
	}
}

/**
 * Append a search icon to the primary menu
 * This is a sample function to show how to append an icon to the menu based on the customizer search option
 * The search icon wont actually do anything
 */
if (!function_exists('upsite_add_search_menu_item')) {
	function upsite_add_search_menu_item($items, $args)
	{
		$defaults = upsite_generate_defaults();

		if (get_theme_mod('search_menu_icon', $defaults['search_menu_icon'])) {
			if ($args->theme_location == 'primary') {
				$items .= '<li class="menu-item menu-item-search"><a href="#" class="nav-search"><i class="fa fa-search"></i></a></li>';
			}
		}
		return $items;
	}
}
add_filter('wp_nav_menu_items', 'upsite_add_search_menu_item', 10, 2);

/**
 * Return a string containing the sample TinyMCE Control
 * This is a sample function to show how you can use the TinyMCE Control for footer credits in your Theme
 * Add the following three lines of code to your footer.php file to display the content of your sample TinyMCE Control
 * <div class="footer-credits">
 *		<?php echo upsite_get_credits(); ?>
 *	</div>
 */
if (!function_exists('upsite_get_credits')) {
	function upsite_get_credits()
	{
		$defaults = upsite_generate_defaults();

		// wpautop this so that it acts like the new visual text widget, since we're using the same TinyMCE control
		return wpautop(get_theme_mod('sample_tinymce_editor', $defaults['sample_tinymce_editor']));
	}
}

/**
 * Set our Customizer default options
 */
if (!function_exists('upsite_generate_defaults')) {
	function upsite_generate_defaults()
	{
		$customizer_defaults = array(
			'social_newtab' => 0,
			'social_urls' => '',
			'social_alignment' => 'alignright',
			'social_rss' => 0,
			'social_url_icons' => '',
			'contact_phone' => '',
			'search_menu_icon' => 0,
			'woocommerce_shop_sidebar' => 1,
			'woocommerce_product_sidebar' => 0,
			'sample_toggle_switch' => 0,
			'sample_slider_control' => 48,
			'sample_slider_control_small_step' => 2,
			'sample_sortable_repeater_control' => '',
			'sample_image_radio_button' => 'sidebarright',
			'sample_text_radio_button' => 'right',
			'sample_image_checkbox' => 'stylebold,styleallcaps',
			'sample_single_accordion' => '',
			'sample_alpha_color' => 'rgba(209,0,55,0.7)',
			'sample_wpcolorpicker_alpha_color' => 'rgba(55,55,55,0.5)',
			'sample_wpcolorpicker_alpha_color2' => 'rgba(33,33,33,0.8)',
			'sample_pill_checkbox' => 'tiger,elephant,hippo',
			'sample_pill_checkbox2' => 'captainmarvel,msmarvel,squirrelgirl',
			'sample_pill_checkbox3' => 'author,categories,comments',
			'sample_simple_notice' => '',
			'sample_dropdown_select2_control_single' => 'vic',
			'sample_dropdown_select2_control_multi' => 'Antarctica/McMurdo,Australia/Melbourne,Australia/Broken_Hill',
			'sample_dropdown_select2_control_multi2' => 'Atlantic/Stanley,Australia/Darwin',
			'sample_dropdown_posts_control' => '',
			'sample_tinymce_editor' => '',
			'sample_google_font_select' => json_encode(
				array(
					'font' => 'Open Sans',
					'regularweight' => 'regular',
					'italicweight' => 'italic',
					'boldweight' => '700',
					'category' => 'sans-serif'
				)
			),
			'sample_default_text' => '',
			'sample_email_text' => '',
			'sample_url_text' => '',
			'sample_number_text' => '',
			'sample_hidden_text' => '',
			'sample_date_text' => '',
			'sample_default_checkbox' => 0,
			'sample_default_select' => 'jet-fuel',
			'sample_default_radio' => 'spider-man',
			'sample_default_dropdownpages' => '1548',
			'sample_default_textarea' => '',
			'sample_default_color' => '#333',
			'sample_default_media' => '',
			'sample_default_image' => '',
			'sample_default_cropped_image' => '',
			'sample_date_only' => '2017-08-28',
			'sample_date_time' => '2017-08-28 16:30:00',
			'sample_date_time_no_past_date' => date('Y-m-d'),
		);

		return apply_filters('upsite_customizer_defaults', $customizer_defaults);
	}
}

/**
 * Load all our Customizer options
 */
include_once trailingslashit(dirname(__FILE__)) . 'inc/customizer.php';
