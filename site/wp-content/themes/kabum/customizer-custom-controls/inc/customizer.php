<?php

/**
 * Customizer Setup and Custom Controls
 *
 */
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class upsite_initialise_customizer_settings
{
	// Get our default values
	private $defaults;

	public function __construct()
	{
		// Get our Customizer defaults
		$this->defaults = upsite_generate_defaults();

		// Register our Panels
		add_action('customize_register', array($this, 'upsite_add_customizer_panels'));

		// Register our sections
		add_action('customize_register', array($this, 'upsite_add_customizer_sections'));

		// Register our social media controls
		add_action('customize_register', array($this, 'upsite_register_social_controls'));

		// Register our contact controls
		add_action('customize_register', array($this, 'upsite_register_contact_controls'));

		// Register our search controls
		add_action('customize_register', array($this, 'upsite_register_search_controls'));

		// Register our WooCommerce controls, only if WooCommerce is active
		if (upsite_is_woocommerce_active()) {
			add_action('customize_register', array($this, 'upsite_register_woocommerce_controls'));
		}

		// Register our sample Custom Control controls
		add_action('customize_register', array($this, 'upsite_register_sample_custom_controls'));

		// Register our sample default controls
		add_action('customize_register', array($this, 'upsite_register_sample_default_controls'));
	}

	/**
	 * Register the Customizer panels
	 */
	public function upsite_add_customizer_panels($wp_customize)
	{
		/**
		 * Add our Header & Navigation Panel
		 */
		$wp_customize->add_panel(
			'header_naviation_panel',
			array(
				'title' => __('Header & Navigation', 'upsite'),
				'description' => esc_html__('Adjust your Header and Navigation sections.', 'upsite')
			)
		);
	}

	/**
	 * Register the Customizer sections
	 */
	public function upsite_add_customizer_sections($wp_customize)
	{
		/**
		 * Add our Social Icons Section
		 */
		$wp_customize->add_section(
			'social_icons_section',
			array(
				'title' => __('Social Icons', 'upsite'),
				'description' => esc_html__('Add your social media links and we\'ll automatically match them with the appropriate icons. Drag and drop the URLs to rearrange their order.', 'upsite'),
				'panel' => 'header_naviation_panel'
			)
		);

		/**
		 * Add our Contact Section
		 */
		$wp_customize->add_section(
			'contact_section',
			array(
				'title' => __('Contact', 'upsite'),
				'description' => esc_html__('Add your phone number to the site header bar.', 'upsite'),
				'panel' => 'header_naviation_panel'
			)
		);

		/**
		 * Add our Search Section
		 */
		$wp_customize->add_section(
			'search_section',
			array(
				'title' => __('Search', 'upsite'),
				'description' => esc_html__('Add a search icon to your primary naigation menu.', 'upsite'),
				'panel' => 'header_naviation_panel'
			)
		);

		/**
		 * Add our WooCommerce Layout Section, only if WooCommerce is active
		 */
		$wp_customize->add_section(
			'woocommerce_layout_section',
			array(
				'title' => __('WooCommerce Layout', 'upsite'),
				'description' => esc_html__('Adjust the layout of your WooCommerce shop.', 'upsite'),
				'active_callback' => 'upsite_is_woocommerce_active'
			)
		);

		/**
		 * Add our section that contains examples of our Custom Controls
		 */
		$wp_customize->add_section(
			'sample_custom_controls_section',
			array(
				'title' => __('Sample Custom Controls', 'upsite'),
				'description' => esc_html__('These are an example of Customizer Custom Controls.', 'upsite')
			)
		);

		/**
		 * Add our section that contains examples of the default Core Customizer Controls
		 */
		$wp_customize->add_section(
			'default_controls_section',
			array(
				'title' => __('Default Controls', 'upsite'),
				'description' => esc_html__('These are an example of the default Customizer Controls.', 'upsite')
			)
		);

		/**
		 * Add our Upsell Section
		 */
		$wp_customize->add_section(new upsite_Upsell_Section(
			$wp_customize,
			'upsell_section',
			array(
				'title' => __('Premium Addons Available', 'upsite'),
				'url' => 'https://upsitethemes.com',
				'backgroundcolor' => '#344860',
				'textcolor' => '#fff',
				'priority' => 0,
			)
		));
	}

	/**
	 * Register our social media controls
	 */
	public function upsite_register_social_controls($wp_customize)
	{

		// Add our Checkbox switch setting and control for opening URLs in a new tab
		$wp_customize->add_setting(
			'social_newtab',
			array(
				'default' => $this->defaults['social_newtab'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_switch_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Toggle_Switch_Custom_control(
			$wp_customize,
			'social_newtab',
			array(
				'label' => __('Open in new browser tab', 'upsite'),
				'section' => 'social_icons_section'
			)
		));
		$wp_customize->selective_refresh->add_partial(
			'social_newtab',
			array(
				'selector' => '.social',
				'container_inclusive' => false,
				'render_callback' => function () {
					echo upsite_get_social_media();
				},
				'fallback_refresh' => true
			)
		);

		// Add our Text Radio Button setting and Custom Control for controlling alignment of icons
		$wp_customize->add_setting(
			'social_alignment',
			array(
				'default' => $this->defaults['social_alignment'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_radio_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Text_Radio_Button_Custom_Control(
			$wp_customize,
			'social_alignment',
			array(
				'label' => __('Alignment', 'upsite'),
				'description' => esc_html__('Choose the alignment for your social icons', 'upsite'),
				'section' => 'social_icons_section',
				'choices' => array(
					'alignleft' => __('Left', 'upsite'),
					'alignright' => __('Right', 'upsite')
				)
			)
		));
		$wp_customize->selective_refresh->add_partial(
			'social_alignment',
			array(
				'selector' => '.social',
				'container_inclusive' => false,
				'render_callback' => function () {
					echo upsite_get_social_media();
				},
				'fallback_refresh' => true
			)
		);

		// Add our Sortable Repeater setting and Custom Control for Social media URLs
		$wp_customize->add_setting(
			'social_urls',
			array(
				'default' => $this->defaults['social_urls'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_url_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Sortable_Repeater_Custom_Control(
			$wp_customize,
			'social_urls',
			array(
				'label' => __('Social URLs', 'upsite'),
				'description' => esc_html__('Add your social media links.', 'upsite'),
				'section' => 'social_icons_section',
				'button_labels' => array(
					'add' => __('Add Icon', 'upsite'),
				)
			)
		));
		$wp_customize->selective_refresh->add_partial(
			'social_urls',
			array(
				'selector' => '.social',
				'container_inclusive' => false,
				'render_callback' => function () {
					echo upsite_get_social_media();
				},
				'fallback_refresh' => true
			)
		);

		// Add our Single Accordion setting and Custom Control to list the available Social Media icons
		$socialIconsList = array(
			'Behance' => __('<i class="fab fa-behance"></i>', 'upsite'),
			'Bitbucket' => __('<i class="fab fa-bitbucket"></i>', 'upsite'),
			'CodePen' => __('<i class="fab fa-codepen"></i>', 'upsite'),
			'DeviantArt' => __('<i class="fab fa-deviantart"></i>', 'upsite'),
			'Discord' => __('<i class="fab fa-discord"></i>', 'upsite'),
			'Dribbble' => __('<i class="fab fa-dribbble"></i>', 'upsite'),
			'Etsy' => __('<i class="fab fa-etsy"></i>', 'upsite'),
			'Facebook' => __('<i class="fab fa-facebook-f"></i>', 'upsite'),
			'Flickr' => __('<i class="fab fa-flickr"></i>', 'upsite'),
			'Foursquare' => __('<i class="fab fa-foursquare"></i>', 'upsite'),
			'GitHub' => __('<i class="fab fa-github"></i>', 'upsite'),
			'Google+' => __('<i class="fab fa-google-plus-g"></i>', 'upsite'),
			'Instagram' => __('<i class="fab fa-instagram"></i>', 'upsite'),
			'Kickstarter' => __('<i class="fab fa-kickstarter-k"></i>', 'upsite'),
			'Last.fm' => __('<i class="fab fa-lastfm"></i>', 'upsite'),
			'LinkedIn' => __('<i class="fab fa-linkedin-in"></i>', 'upsite'),
			'Medium' => __('<i class="fab fa-medium-m"></i>', 'upsite'),
			'Patreon' => __('<i class="fab fa-patreon"></i>', 'upsite'),
			'Pinterest' => __('<i class="fab fa-pinterest-p"></i>', 'upsite'),
			'Reddit' => __('<i class="fab fa-reddit-alien"></i>', 'upsite'),
			'Slack' => __('<i class="fab fa-slack-hash"></i>', 'upsite'),
			'SlideShare' => __('<i class="fab fa-slideshare"></i>', 'upsite'),
			'Snapchat' => __('<i class="fab fa-snapchat-ghost"></i>', 'upsite'),
			'SoundCloud' => __('<i class="fab fa-soundcloud"></i>', 'upsite'),
			'Spotify' => __('<i class="fab fa-spotify"></i>', 'upsite'),
			'Stack Overflow' => __('<i class="fab fa-stack-overflow"></i>', 'upsite'),
			'Tumblr' => __('<i class="fab fa-tumblr"></i>', 'upsite'),
			'Twitch' => __('<i class="fab fa-twitch"></i>', 'upsite'),
			'Twitter' => __('<i class="fab fa-twitter"></i>', 'upsite'),
			'Vimeo' => __('<i class="fab fa-vimeo-v"></i>', 'upsite'),
			'Weibo' => __('<i class="fab fa-weibo"></i>', 'upsite'),
			'YouTube' => __('<i class="fab fa-youtube"></i>', 'upsite'),
		);
		$wp_customize->add_setting(
			'social_url_icons',
			array(
				'default' => $this->defaults['social_url_icons'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Single_Accordion_Custom_Control(
			$wp_customize,
			'social_url_icons',
			array(
				'label' => __('View list of available icons', 'upsite'),
				'description' => $socialIconsList,
				'section' => 'social_icons_section'
			)
		));

		// Add our Checkbox switch setting and Custom Control for displaying an RSS icon
		$wp_customize->add_setting(
			'social_rss',
			array(
				'default' => $this->defaults['social_rss'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_switch_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Toggle_Switch_Custom_control(
			$wp_customize,
			'social_rss',
			array(
				'label' => __('Display RSS icon', 'upsite'),
				'section' => 'social_icons_section'
			)
		));
		$wp_customize->selective_refresh->add_partial(
			'social_rss',
			array(
				'selector' => '.social',
				'container_inclusive' => false,
				'render_callback' => function () {
					echo upsite_get_social_media();
				},
				'fallback_refresh' => true
			)
		);
	}

	/**
	 * Register our Contact controls
	 */
	public function upsite_register_contact_controls($wp_customize)
	{
		// Add our Text field setting and Control for displaying the phone number
		$wp_customize->add_setting(
			'contact_phone',
			array(
				'default' => $this->defaults['contact_phone'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			)
		);
		$wp_customize->add_control(
			'contact_phone',
			array(
				'label' => __('Display phone number', 'upsite'),
				'type' => 'text',
				'section' => 'contact_section'
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'contact_phone',
			array(
				'selector' => '.social',
				'container_inclusive' => false,
				'render_callback' => function () {
					echo upsite_get_social_media();
				},
				'fallback_refresh' => true
			)
		);
	}

	/**
	 * Register our Search controls
	 */
	public function upsite_register_search_controls($wp_customize)
	{
		// Add our Checkbox switch setting and control for opening URLs in a new tab
		$wp_customize->add_setting(
			'search_menu_icon',
			array(
				'default' => $this->defaults['search_menu_icon'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_switch_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Toggle_Switch_Custom_control(
			$wp_customize,
			'search_menu_icon',
			array(
				'label' => __('Display Search Icon', 'upsite'),
				'section' => 'search_section'
			)
		));
		$wp_customize->selective_refresh->add_partial(
			'search_menu_icon',
			array(
				'selector' => '.menu-item-search',
				'container_inclusive' => false,
				'fallback_refresh' => false
			)
		);
	}

	/**
	 * Register our WooCommerce Layout controls
	 */
	public function upsite_register_woocommerce_controls($wp_customize)
	{

		// Add our Checkbox switch setting and control for displaying a sidebar on the shop page
		$wp_customize->add_setting(
			'woocommerce_shop_sidebar',
			array(
				'default' => $this->defaults['woocommerce_shop_sidebar'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_switch_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Toggle_Switch_Custom_control(
			$wp_customize,
			'woocommerce_shop_sidebar',
			array(
				'label' => __('Shop page sidebar', 'upsite'),
				'section' => 'woocommerce_layout_section'
			)
		));

		// Add our Checkbox switch setting and control for displaying a sidebar on the single product page
		$wp_customize->add_setting(
			'woocommerce_product_sidebar',
			array(
				'default' => $this->defaults['woocommerce_product_sidebar'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_switch_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Toggle_Switch_Custom_control(
			$wp_customize,
			'woocommerce_product_sidebar',
			array(
				'label' => esc_html__('Single Product page sidebar', 'upsite'),
				'section' => 'woocommerce_layout_section'
			)
		));

		// Add our Simple Notice setting and control for displaying a message about the WooCommerce shop sidebars
		$wp_customize->add_setting(
			'woocommerce_other_sidebar',
			array(
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Simple_Notice_Custom_control(
			$wp_customize,
			'woocommerce_other_sidebar',
			array(
				'label' => __('Cart, Checkout & My Account sidebars', 'upsite'),
				'description' => esc_html__('The Cart, Checkout and My Account pages are displayed using shortcodes. To remove the sidebar from these Pages, simply edit each Page and change the Template (in the Page Attributes Panel) to Full-width Page.', 'upsite'),
				'section' => 'woocommerce_layout_section'
			)
		));
	}

	/**
	 * Register our sample custom controls
	 */
	public function upsite_register_sample_custom_controls($wp_customize)
	{

		// Test of Toggle Switch Custom Control
		$wp_customize->add_setting(
			'sample_toggle_switch',
			array(
				'default' => $this->defaults['sample_toggle_switch'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_switch_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Toggle_Switch_Custom_control(
			$wp_customize,
			'sample_toggle_switch',
			array(
				'label' => __('Toggle switch', 'upsite'),
				'section' => 'sample_custom_controls_section'
			)
		));

		// Test of Slider Custom Control
		$wp_customize->add_setting(
			'sample_slider_control',
			array(
				'default' => $this->defaults['sample_slider_control'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control(new upsite_Slider_Custom_Control(
			$wp_customize,
			'sample_slider_control',
			array(
				'label' => __('Slider Control (px)', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'min' => 10,
					'max' => 90,
					'step' => 1,
				),
			)
		));

		// Another Test of Slider Custom Control
		$wp_customize->add_setting(
			'sample_slider_control_small_step',
			array(
				'default' => $this->defaults['sample_slider_control_small_step'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_range_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Slider_Custom_Control(
			$wp_customize,
			'sample_slider_control_small_step',
			array(
				'label' => __('Slider Control With a Small Step', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'min' => 0,
					'max' => 4,
					'step' => .5,
				),
			)
		));

		// Add our Sortable Repeater setting and Custom Control for Social media URLs
		$wp_customize->add_setting(
			'sample_sortable_repeater_control',
			array(
				'default' => $this->defaults['sample_sortable_repeater_control'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_url_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Sortable_Repeater_Custom_Control(
			$wp_customize,
			'sample_sortable_repeater_control',
			array(
				'label' => __('Sortable Repeater', 'upsite'),
				'description' => esc_html__('This is the control description.', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'button_labels' => array(
					'add' => __('Add Row', 'upsite'),
				)
			)
		));

		// Test of Image Radio Button Custom Control
		$wp_customize->add_setting(
			'sample_image_radio_button',
			array(
				'default' => $this->defaults['sample_image_radio_button'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_radio_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Image_Radio_Button_Custom_Control(
			$wp_customize,
			'sample_image_radio_button',
			array(
				'label' => __('Image Radio Button Control', 'upsite'),
				'description' => esc_html__('Sample custom control description', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'choices' => array(
					'sidebarleft' => array(
						'image' => trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/images/sidebar-left.png',
						'name' => __('Left Sidebar', 'upsite')
					),
					'sidebarnone' => array(
						'image' => trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/images/sidebar-none.png',
						'name' => __('No Sidebar', 'upsite')
					),
					'sidebarright' => array(
						'image' => trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/images/sidebar-right.png',
						'name' => __('Right Sidebar', 'upsite')
					)
				)
			)
		));

		// Test of Text Radio Button Custom Control
		$wp_customize->add_setting(
			'sample_text_radio_button',
			array(
				'default' => $this->defaults['sample_text_radio_button'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_radio_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Text_Radio_Button_Custom_Control(
			$wp_customize,
			'sample_text_radio_button',
			array(
				'label' => __('Text Radio Button Control', 'upsite'),
				'description' => esc_html__('Sample custom control description', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'choices' => array(
					'left' => __('Left', 'upsite'),
					'centered' => __('Centered', 'upsite'),
					'right' => __('Right', 'upsite')
				)
			)
		));

		// Test of Image Checkbox Custom Control
		$wp_customize->add_setting(
			'sample_image_checkbox',
			array(
				'default' => $this->defaults['sample_image_checkbox'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Image_checkbox_Custom_Control(
			$wp_customize,
			'sample_image_checkbox',
			array(
				'label' => __('Image Checkbox Control', 'upsite'),
				'description' => esc_html__('Sample custom control description', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'choices' => array(
					'stylebold' => array(
						'image' => trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/images/Bold.png',
						'name' => __('Bold', 'upsite')
					),
					'styleitalic' => array(
						'image' => trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/images/Italic.png',
						'name' => __('Italic', 'upsite')
					),
					'styleallcaps' => array(
						'image' => trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/images/AllCaps.png',
						'name' => __('All Caps', 'upsite')
					),
					'styleunderline' => array(
						'image' => trailingslashit(get_template_directory_uri()) . 'customizer-custom-controls/images/Underline.png',
						'name' => __('Underline', 'upsite')
					)
				)
			)
		));

		// Test of Single Accordion Control
		$sampleIconsList = array(
			'Behance' => __('<i class="fab fa-behance"></i>', 'upsite'),
			'Bitbucket' => __('<i class="fab fa-bitbucket"></i>', 'upsite'),
			'CodePen' => __('<i class="fab fa-codepen"></i>', 'upsite'),
			'DeviantArt' => __('<i class="fab fa-deviantart"></i>', 'upsite'),
			'Discord' => __('<i class="fab fa-discord"></i>', 'upsite'),
			'Dribbble' => __('<i class="fab fa-dribbble"></i>', 'upsite'),
			'Etsy' => __('<i class="fab fa-etsy"></i>', 'upsite'),
			'Facebook' => __('<i class="fab fa-facebook-f"></i>', 'upsite'),
			'Flickr' => __('<i class="fab fa-flickr"></i>', 'upsite'),
			'Foursquare' => __('<i class="fab fa-foursquare"></i>', 'upsite'),
			'GitHub' => __('<i class="fab fa-github"></i>', 'upsite'),
			'Google+' => __('<i class="fab fa-google-plus-g"></i>', 'upsite'),
			'Instagram' => __('<i class="fab fa-instagram"></i>', 'upsite'),
			'Kickstarter' => __('<i class="fab fa-kickstarter-k"></i>', 'upsite'),
			'Last.fm' => __('<i class="fab fa-lastfm"></i>', 'upsite'),
			'LinkedIn' => __('<i class="fab fa-linkedin-in"></i>', 'upsite'),
			'Medium' => __('<i class="fab fa-medium-m"></i>', 'upsite'),
			'Patreon' => __('<i class="fab fa-patreon"></i>', 'upsite'),
			'Pinterest' => __('<i class="fab fa-pinterest-p"></i>', 'upsite'),
			'Reddit' => __('<i class="fab fa-reddit-alien"></i>', 'upsite'),
			'Slack' => __('<i class="fab fa-slack-hash"></i>', 'upsite'),
			'SlideShare' => __('<i class="fab fa-slideshare"></i>', 'upsite'),
			'Snapchat' => __('<i class="fab fa-snapchat-ghost"></i>', 'upsite'),
			'SoundCloud' => __('<i class="fab fa-soundcloud"></i>', 'upsite'),
			'Spotify' => __('<i class="fab fa-spotify"></i>', 'upsite'),
			'Stack Overflow' => __('<i class="fab fa-stack-overflow"></i>', 'upsite'),
			'Tumblr' => __('<i class="fab fa-tumblr"></i>', 'upsite'),
			'Twitch' => __('<i class="fab fa-twitch"></i>', 'upsite'),
			'Twitter' => __('<i class="fab fa-twitter"></i>', 'upsite'),
			'Vimeo' => __('<i class="fab fa-vimeo-v"></i>', 'upsite'),
			'Weibo' => __('<i class="fab fa-weibo"></i>', 'upsite'),
			'YouTube' => __('<i class="fab fa-youtube"></i>', 'upsite'),
		);
		$wp_customize->add_setting(
			'sample_single_accordion',
			array(
				'default' => $this->defaults['sample_single_accordion'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Single_Accordion_Custom_Control(
			$wp_customize,
			'sample_single_accordion',
			array(
				'label' => __('Single Accordion Control', 'upsite'),
				'description' => $sampleIconsList,
				'section' => 'sample_custom_controls_section'
			)
		));

		// Test of Alpha Color Picker Control
		$wp_customize->add_setting(
			'sample_alpha_color',
			array(
				'default' => $this->defaults['sample_alpha_color'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_hex_rgba_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Customize_Alpha_Color_Control(
			$wp_customize,
			'sample_alpha_color',
			array(
				'label' => __('Alpha Color Picker Control', 'upsite'),
				'description' => esc_html__('Sample custom control description', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'show_opacity' => true,
				'palette' => array(
					'#000',
					'#fff',
					'#df312c',
					'#df9a23',
					'#eef000',
					'#7ed934',
					'#1571c1',
					'#8309e7'
				)
			)
		));

		// Test of WPColorPicker Alpha Color Picker Control
		$wp_customize->add_setting(
			'sample_wpcolorpicker_alpha_color',
			array(
				'default' => $this->defaults['sample_wpcolorpicker_alpha_color'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_hex_rgba_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Alpha_Color_Control(
			$wp_customize,
			'sample_wpcolorpicker_alpha_color',
			array(
				'label' => __('WP ColorPicker Alpha Color Picker', 'upsite'),
				'description' => esc_html__('Sample color control with Alpha channel', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'palette' => array(
						'#000000',
						'#222222',
						'#444444',
						'#777777',
						'#999999',
						'#aaaaaa',
						'#dddddd',
						'#ffffff',
					)
				),
			)
		));

		// Another Test of WPColorPicker Alpha Color Picker Control
		$wp_customize->add_setting(
			'sample_wpcolorpicker_alpha_color2',
			array(
				'default' => $this->defaults['sample_wpcolorpicker_alpha_color2'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_hex_rgba_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Alpha_Color_Control(
			$wp_customize,
			'sample_wpcolorpicker_alpha_color2',
			array(
				'label' => __('WP ColorPicker Alpha Color Picker', 'upsite'),
				'description' => esc_html__('Sample color control with Alpha channel', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'resetalpha' => false,
					'palette' => array(
						'rgba(99,78,150,1)',
						'rgba(67,78,150,1)',
						'rgba(34,78,150,.7)',
						'rgba(3,78,150,1)',
						'rgba(7,110,230,.9)',
						'rgba(234,78,150,1)',
						'rgba(99,78,150,.5)',
						'rgba(190,120,120,.5)',
					),
				),
			)
		));

		// Test of Pill Checkbox Custom Control
		$wp_customize->add_setting(
			'sample_pill_checkbox',
			array(
				'default' => $this->defaults['sample_pill_checkbox'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Pill_Checkbox_Custom_Control(
			$wp_customize,
			'sample_pill_checkbox',
			array(
				'label' => __('Pill Checkbox Control', 'upsite'),
				'description' => esc_html__('This is a sample Pill Checkbox Control', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'sortable' => false,
					'fullwidth' => false,
				),
				'choices' => array(
					'tiger' => __('Tiger', 'upsite'),
					'lion' => __('Lion', 'upsite'),
					'giraffe' => __('Giraffe', 'upsite'),
					'elephant' => __('Elephant', 'upsite'),
					'hippo' => __('Hippo', 'upsite'),
					'rhino' => __('Rhino', 'upsite'),
				)
			)
		));

		// Test of Pill Checkbox Custom Control
		$wp_customize->add_setting(
			'sample_pill_checkbox2',
			array(
				'default' => $this->defaults['sample_pill_checkbox2'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Pill_Checkbox_Custom_Control(
			$wp_customize,
			'sample_pill_checkbox2',
			array(
				'label' => __('Pill Checkbox Control', 'upsite'),
				'description' => esc_html__('This is a sample Sortable Pill Checkbox Control', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'sortable' => true,
					'fullwidth' => false,
				),
				'choices' => array(
					'captainamerica' => __('Captain America', 'upsite'),
					'ironman' => __('Iron Man', 'upsite'),
					'captainmarvel' => __('Captain Marvel', 'upsite'),
					'msmarvel' => __('Ms. Marvel', 'upsite'),
					'Jessicajones' => __('Jessica Jones', 'upsite'),
					'squirrelgirl' => __('Squirrel Girl', 'upsite'),
					'blackwidow' => __('Black Widow', 'upsite'),
					'hulk' => __('Hulk', 'upsite'),
				)
			)
		));

		// Test of Pill Checkbox Custom Control
		$wp_customize->add_setting(
			'sample_pill_checkbox3',
			array(
				'default' => $this->defaults['sample_pill_checkbox3'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Pill_Checkbox_Custom_Control(
			$wp_customize,
			'sample_pill_checkbox3',
			array(
				'label' => __('Pill Checkbox Control', 'upsite'),
				'description' => esc_html__('This is a sample Sortable Fullwidth Pill Checkbox Control', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'sortable' => true,
					'fullwidth' => true,
				),
				'choices' => array(
					'date' => __('Date', 'upsite'),
					'author' => __('Author', 'upsite'),
					'categories' => __('Categories', 'upsite'),
					'tags' => __('Tags', 'upsite'),
					'comments' => __('Comments', 'upsite'),
				)
			)
		));

		// Test of Simple Notice control
		$wp_customize->add_setting(
			'sample_simple_notice',
			array(
				'default' => $this->defaults['sample_simple_notice'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Simple_Notice_Custom_control(
			$wp_customize,
			'sample_simple_notice',
			array(
				'label' => __('Simple Notice Control', 'upsite'),
				'description' => __('This Custom Control allows you to display a simple title and description to your users. You can even include <a href="http://google.com" target="_blank">basic html</a>.', 'upsite'),
				'section' => 'sample_custom_controls_section'
			)
		));

		// Test of Dropdown Select2 Control (single select)
		$wp_customize->add_setting(
			'sample_dropdown_select2_control_single',
			array(
				'default' => $this->defaults['sample_dropdown_select2_control_single'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Dropdown_Select2_Custom_Control(
			$wp_customize,
			'sample_dropdown_select2_control_single',
			array(
				'label' => __('Dropdown Select2 Control', 'upsite'),
				'description' => esc_html__('Sample Dropdown Select2 custom control (Single Select)', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'placeholder' => __('Please select a state...', 'upsite'),
					'multiselect' => false,
				),
				'choices' => array(
					'nsw' => __('New South Wales', 'upsite'),
					'vic' => __('Victoria', 'upsite'),
					'qld' => __('Queensland', 'upsite'),
					'wa' => __('Western Australia', 'upsite'),
					'sa' => __('South Australia', 'upsite'),
					'tas' => __('Tasmania', 'upsite'),
					'act' => __('Australian Capital Territory', 'upsite'),
					'nt' => __('Northern Territory', 'upsite'),
				)
			)
		));

		// Test of Dropdown Select2 Control (Multi-Select)
		$wp_customize->add_setting(
			'sample_dropdown_select2_control_multi',
			array(
				'default' => $this->defaults['sample_dropdown_select2_control_multi'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Dropdown_Select2_Custom_Control(
			$wp_customize,
			'sample_dropdown_select2_control_multi',
			array(
				'label' => __('Dropdown Select2 Control', 'upsite'),
				'description' => esc_html__('Sample Dropdown Select2 custom control  (Multi-Select)', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'multiselect' => true,
				),
				'choices' => array(
					__('Antarctica', 'upsite') => array(
						'Antarctica/Casey' => __('Casey', 'upsite'),
						'Antarctica/Davis' => __('Davis', 'upsite'),
						'Antarctica/DumontDurville' => __('DumontDUrville', 'upsite'),
						'Antarctica/Macquarie' => __('Macquarie', 'upsite'),
						'Antarctica/Mawson' => __('Mawson', 'upsite'),
						'Antarctica/McMurdo' => __('McMurdo', 'upsite'),
						'Antarctica/Palmer' => __('Palmer', 'upsite'),
						'Antarctica/Rothera' => __('Rothera', 'upsite'),
						'Antarctica/Syowa' => __('Syowa', 'upsite'),
						'Antarctica/Troll' => __('Troll', 'upsite'),
						'Antarctica/Vostok' => __('Vostok', 'upsite'),
					),
					__('Atlantic', 'upsite') => array(
						'Atlantic/Azores' => __('Azores', 'upsite'),
						'Atlantic/Bermuda' => __('Bermuda', 'upsite'),
						'Atlantic/Canary' => __('Canary', 'upsite'),
						'Atlantic/Cape_Verde' => __('Cape Verde', 'upsite'),
						'Atlantic/Faroe' => __('Faroe', 'upsite'),
						'Atlantic/Madeira' => __('Madeira', 'upsite'),
						'Atlantic/Reykjavik' => __('Reykjavik', 'upsite'),
						'Atlantic/South_Georgia' => __('South Georgia', 'upsite'),
						'Atlantic/Stanley' => __('Stanley', 'upsite'),
						'Atlantic/St_Helena' => __('St Helena', 'upsite'),
					),
					__('Australia', 'upsite') => array(
						'Australia/Adelaide' => __('Adelaide', 'upsite'),
						'Australia/Brisbane' => __('Brisbane', 'upsite'),
						'Australia/Broken_Hill' => __('Broken Hill', 'upsite'),
						'Australia/Currie' => __('Currie', 'upsite'),
						'Australia/Darwin' => __('Darwin', 'upsite'),
						'Australia/Eucla' => __('Eucla', 'upsite'),
						'Australia/Hobart' => __('Hobart', 'upsite'),
						'Australia/Lindeman' => __('Lindeman', 'upsite'),
						'Australia/Lord_Howe' => __('Lord Howe', 'upsite'),
						'Australia/Melbourne' => __('Melbourne', 'upsite'),
						'Australia/Perth' => __('Perth', 'upsite'),
						'Australia/Sydney' => __('Sydney', 'upsite'),
					)
				)
			)
		));

		// Test of Dropdown Select2 Control (Multi-Select) with single array choice
		$wp_customize->add_setting(
			'sample_dropdown_select2_control_multi2',
			array(
				'default' => $this->defaults['sample_dropdown_select2_control_multi2'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Dropdown_Select2_Custom_Control(
			$wp_customize,
			'sample_dropdown_select2_control_multi2',
			array(
				'label' => __('Dropdown Select2 Control', 'upsite'),
				'description' => esc_html__('Another Sample Dropdown Select2 custom control (Multi-Select)', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'multiselect' => true,
				),
				'choices' => array(
					'Antarctica/Casey' => __('Casey', 'upsite'),
					'Antarctica/Davis' => __('Davis', 'upsite'),
					'Antarctica/DumontDurville' => __('DumontDUrville', 'upsite'),
					'Antarctica/Macquarie' => __('Macquarie', 'upsite'),
					'Antarctica/Mawson' => __('Mawson', 'upsite'),
					'Antarctica/McMurdo' => __('McMurdo', 'upsite'),
					'Antarctica/Palmer' => __('Palmer', 'upsite'),
					'Antarctica/Rothera' => __('Rothera', 'upsite'),
					'Antarctica/Syowa' => __('Syowa', 'upsite'),
					'Antarctica/Troll' => __('Troll', 'upsite'),
					'Antarctica/Vostok' => __('Vostok', 'upsite'),
					'Atlantic/Azores' => __('Azores', 'upsite'),
					'Atlantic/Bermuda' => __('Bermuda', 'upsite'),
					'Atlantic/Canary' => __('Canary', 'upsite'),
					'Atlantic/Cape_Verde' => __('Cape Verde', 'upsite'),
					'Atlantic/Faroe' => __('Faroe', 'upsite'),
					'Atlantic/Madeira' => __('Madeira', 'upsite'),
					'Atlantic/Reykjavik' => __('Reykjavik', 'upsite'),
					'Atlantic/South_Georgia' => __('South Georgia', 'upsite'),
					'Atlantic/Stanley' => __('Stanley', 'upsite'),
					'Atlantic/St_Helena' => __('St Helena', 'upsite'),
					'Australia/Adelaide' => __('Adelaide', 'upsite'),
					'Australia/Brisbane' => __('Brisbane', 'upsite'),
					'Australia/Broken_Hill' => __('Broken Hill', 'upsite'),
					'Australia/Currie' => __('Currie', 'upsite'),
					'Australia/Darwin' => __('Darwin', 'upsite'),
					'Australia/Eucla' => __('Eucla', 'upsite'),
					'Australia/Hobart' => __('Hobart', 'upsite'),
					'Australia/Lindeman' => __('Lindeman', 'upsite'),
					'Australia/Lord_Howe' => __('Lord Howe', 'upsite'),
					'Australia/Melbourne' => __('Melbourne', 'upsite'),
					'Australia/Perth' => __('Perth', 'upsite'),
					'Australia/Sydney' => __('Sydney', 'upsite'),
				)
			)
		));

		// Test of Dropdown Posts Control
		$wp_customize->add_setting(
			'sample_dropdown_posts_control',
			array(
				'default' => $this->defaults['sample_dropdown_posts_control'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control(new upsite_Dropdown_Posts_Custom_Control(
			$wp_customize,
			'sample_dropdown_posts_control',
			array(
				'label' => __('Dropdown Posts Control', 'upsite'),
				'description' => esc_html__('Sample Dropdown Posts custom control description', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'posts_per_page' => -1,
					'orderby' => 'name',
					'order' => 'ASC',
				),
			)
		));

		// Test of TinyMCE control
		$wp_customize->add_setting(
			'sample_tinymce_editor',
			array(
				'default' => $this->defaults['sample_tinymce_editor'],
				'transport' => 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
			)
		);
		$wp_customize->add_control(new upsite_TinyMCE_Custom_control(
			$wp_customize,
			'sample_tinymce_editor',
			array(
				'label' => __('TinyMCE Control', 'upsite'),
				'description' => __('This is a TinyMCE Editor Custom Control', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'toolbar1' => 'bold italic bullist numlist alignleft aligncenter alignright link',
					'mediaButtons' => true,
				)
			)
		));
		$wp_customize->selective_refresh->add_partial(
			'sample_tinymce_editor',
			array(
				'selector' => '.footer-credits',
				'container_inclusive' => false,
				'render_callback' => 'upsite_get_credits_render_callback',
				'fallback_refresh' => false,
			)
		);

		// Test of Google Font Select Control
		$wp_customize->add_setting(
			'sample_google_font_select',
			array(
				'default' => $this->defaults['sample_google_font_select'],
				'sanitize_callback' => 'upsite_google_font_sanitization'
			)
		);
		$wp_customize->add_control(new upsite_Google_Font_Select_Custom_Control(
			$wp_customize,
			'sample_google_font_select',
			array(
				'label' => __('Google Font Control', 'upsite'),
				'description' => esc_html__('All Google Fonts sorted alphabetically', 'upsite'),
				'section' => 'sample_custom_controls_section',
				'input_attrs' => array(
					'font_count' => 'all',
					'orderby' => 'alpha',
				),
			)
		));
	}

	/**
	 * Register our sample default controls
	 */
	public function upsite_register_sample_default_controls($wp_customize)
	{

		// Test of Text Control
		$wp_customize->add_setting(
			'sample_default_text',
			array(
				'default' => $this->defaults['sample_default_text'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(
			'sample_default_text',
			array(
				'label' => __('Default Text Control', 'upsite'),
				'description' => esc_html__('Text controls Type can be either text, email, url, number, hidden, or date', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'text',
				'input_attrs' => array(
					'class' => 'my-custom-class',
					'style' => 'border: 1px solid rebeccapurple',
					'placeholder' => __('Enter name...', 'upsite'),
				),
			)
		);

		// Test of Email Control
		$wp_customize->add_setting(
			'sample_email_text',
			array(
				'default' => $this->defaults['sample_email_text'],
				'transport' => 'refresh',
				'sanitize_callback' => 'sanitize_email'
			)
		);
		$wp_customize->add_control(
			'sample_email_text',
			array(
				'label' => __('Default Email Control', 'upsite'),
				'description' => esc_html__('Text controls Type can be either text, email, url, number, hidden, or date', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'email'
			)
		);

		// Test of URL Control
		$wp_customize->add_setting(
			'sample_url_text',
			array(
				'default' => $this->defaults['sample_url_text'],
				'transport' => 'refresh',
				'sanitize_callback' => 'esc_url_raw'
			)
		);
		$wp_customize->add_control(
			'sample_url_text',
			array(
				'label' => __('Default URL Control', 'upsite'),
				'description' => esc_html__('Text controls Type can be either text, email, url, number, hidden, or date', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'url'
			)
		);

		// Test of Number Control
		$wp_customize->add_setting(
			'sample_number_text',
			array(
				'default' => $this->defaults['sample_number_text'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_sanitize_integer'
			)
		);
		$wp_customize->add_control(
			'sample_number_text',
			array(
				'label' => __('Default Number Control', 'upsite'),
				'description' => esc_html__('Text controls Type can be either text, email, url, number, hidden, or date', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'number'
			)
		);

		// Test of Hidden Control
		$wp_customize->add_setting(
			'sample_hidden_text',
			array(
				'default' => $this->defaults['sample_hidden_text'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(
			'sample_hidden_text',
			array(
				'label' => __('Default Hidden Control', 'upsite'),
				'description' => esc_html__('Text controls Type can be either text, email, url, number, hidden, or date', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'hidden'
			)
		);

		// Test of Date Control
		$wp_customize->add_setting(
			'sample_date_text',
			array(
				'default' => $this->defaults['sample_date_text'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_text_sanitization'
			)
		);
		$wp_customize->add_control(
			'sample_date_text',
			array(
				'label' => __('Default Date Control', 'upsite'),
				'description' => esc_html__('Text controls Type can be either text, email, url, number, hidden, or date', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'text'
			)
		);

		// Test of Standard Checkbox Control
		$wp_customize->add_setting(
			'sample_default_checkbox',
			array(
				'default' => $this->defaults['sample_default_checkbox'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_switch_sanitization'
			)
		);
		$wp_customize->add_control(
			'sample_default_checkbox',
			array(
				'label' => __('Default Checkbox Control', 'upsite'),
				'description' => esc_html__('Sample Checkbox description', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'checkbox'
			)
		);

		// Test of Standard Select Control
		$wp_customize->add_setting(
			'sample_default_select',
			array(
				'default' => $this->defaults['sample_default_select'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_radio_sanitization'
			)
		);
		$wp_customize->add_control(
			'sample_default_select',
			array(
				'label' => __('Standard Select Control', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'select',
				'choices' => array(
					'wordpress' => __('WordPress', 'upsite'),
					'hamsters' => __('Hamsters', 'upsite'),
					'jet-fuel' => __('Jet Fuel', 'upsite'),
					'nuclear-energy' => __('Nuclear Energy', 'upsite')
				)
			)
		);

		// Test of Standard Radio Control
		$wp_customize->add_setting(
			'sample_default_radio',
			array(
				'default' => $this->defaults['sample_default_radio'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_radio_sanitization'
			)
		);
		$wp_customize->add_control(
			'sample_default_radio',
			array(
				'label' => __('Standard Radio Control', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'radio',
				'choices' => array(
					'captain-america' => __('Captain America', 'upsite'),
					'iron-man' => __('Iron Man', 'upsite'),
					'spider-man' => __('Spider-Man', 'upsite'),
					'thor' => __('Thor', 'upsite')
				)
			)
		);

		// Test of Dropdown Pages Control
		$wp_customize->add_setting(
			'sample_default_dropdownpages',
			array(
				'default' => $this->defaults['sample_default_dropdownpages'],
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control(
			'sample_default_dropdownpages',
			array(
				'label' => __('Default Dropdown Pages Control', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'dropdown-pages'
			)
		);

		// Test of Textarea Control
		$wp_customize->add_setting(
			'sample_default_textarea',
			array(
				'default' => $this->defaults['sample_default_textarea'],
				'transport' => 'refresh',
				'sanitize_callback' => 'wp_filter_nohtml_kses'
			)
		);
		$wp_customize->add_control(
			'sample_default_textarea',
			array(
				'label' => __('Default Textarea Control', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'textarea',
				'input_attrs' => array(
					'class' => 'my-custom-class',
					'style' => 'border: 1px solid #999',
					'placeholder' => __('Enter message...', 'upsite'),
				),
			)
		);

		// Test of Color Control
		$wp_customize->add_setting(
			'sample_default_color',
			array(
				'default' => $this->defaults['sample_default_color'],
				'transport' => 'refresh',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);
		$wp_customize->add_control(
			'sample_default_color',
			array(
				'label' => __('Default Color Control', 'upsite'),
				'section' => 'default_controls_section',
				'type' => 'color'
			)
		);

		// Test of Media Control
		$wp_customize->add_setting(
			'sample_default_media',
			array(
				'default' => $this->defaults['sample_default_media'],
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control(new WP_Customize_Media_Control(
			$wp_customize,
			'sample_default_media',
			array(
				'label' => __('Default Media Control', 'upsite'),
				'description' => esc_html__('This is the description for the Media Control', 'upsite'),
				'section' => 'default_controls_section',
				'mime_type' => 'image',
				'button_labels' => array(
					'select' => __('Select File', 'upsite'),
					'change' => __('Change File', 'upsite'),
					'default' => __('Default', 'upsite'),
					'remove' => __('Remove', 'upsite'),
					'placeholder' => __('No file selected', 'upsite'),
					'frame_title' => __('Select File', 'upsite'),
					'frame_button' => __('Choose File', 'upsite'),
				)
			)
		));

		// Test of Image Control
		$wp_customize->add_setting(
			'sample_default_image',
			array(
				'default' => $this->defaults['sample_default_image'],
				'transport' => 'refresh',
				'sanitize_callback' => 'esc_url_raw'
			)
		);
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			'sample_default_image',
			array(
				'label' => __('Default Image Control', 'upsite'),
				'description' => esc_html__('This is the description for the Image Control', 'upsite'),
				'section' => 'default_controls_section',
				'button_labels' => array(
					'select' => __('Select Image', 'upsite'),
					'change' => __('Change Image', 'upsite'),
					'remove' => __('Remove', 'upsite'),
					'default' => __('Default', 'upsite'),
					'placeholder' => __('No image selected', 'upsite'),
					'frame_title' => __('Select Image', 'upsite'),
					'frame_button' => __('Choose Image', 'upsite'),
				)
			)
		));

		// Test of Cropped Image Control
		$wp_customize->add_setting(
			'sample_default_cropped_image',
			array(
				'default' => $this->defaults['sample_default_cropped_image'],
				'transport' => 'refresh',
				'sanitize_callback' => 'absint'
			)
		);
		$wp_customize->add_control(new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'sample_default_cropped_image',
			array(
				'label' => __('Default Cropped Image Control', 'upsite'),
				'description' => esc_html__('This is the description for the Cropped Image Control', 'upsite'),
				'section' => 'default_controls_section',
				'flex_width' => false,
				'flex_height' => false,
				'width' => 800,
				'height' => 400
			)
		));

		// Test of Date/Time Control
		$wp_customize->add_setting(
			'sample_date_only',
			array(
				'default' => $this->defaults['sample_date_only'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_date_time_sanitization',
			)
		);
		$wp_customize->add_control(new WP_Customize_Date_Time_Control(
			$wp_customize,
			'sample_date_only',
			array(
				'label' => __('Default Date Control', 'upsite'),
				'description' => esc_html__('This is the Date Time Control but is only displaying a date field. It also has Max and Min years set.', 'upsite'),
				'section' => 'default_controls_section',
				'include_time' => false,
				'allow_past_date' => true,
				'twelve_hour_format' => true,
				'min_year' => '2016',
				'max_year' => '2025',
			)
		));

		// Test of Date/Time Control
		$wp_customize->add_setting(
			'sample_date_time',
			array(
				'default' => $this->defaults['sample_date_time'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_date_time_sanitization',
			)
		);
		$wp_customize->add_control(new WP_Customize_Date_Time_Control(
			$wp_customize,
			'sample_date_time',
			array(
				'label' => __('Default Date Control', 'upsite'),
				'description' => esc_html__('This is the Date Time Control. It also has Max and Min years set.', 'upsite'),
				'section' => 'default_controls_section',
				'include_time' => true,
				'allow_past_date' => true,
				'twelve_hour_format' => true,
				'min_year' => '2010',
				'max_year' => '2020',
			)
		));

		// Test of Date/Time Control
		$wp_customize->add_setting(
			'sample_date_time_no_past_date',
			array(
				'default' => $this->defaults['sample_date_time_no_past_date'],
				'transport' => 'refresh',
				'sanitize_callback' => 'upsite_date_time_sanitization',
			)
		);
		$wp_customize->add_control(new WP_Customize_Date_Time_Control(
			$wp_customize,
			'sample_date_time_no_past_date',
			array(
				'label' => __('Default Date Control', 'upsite'),
				'description' => esc_html__("This is the Date Time Control but is only displaying a date field. Past dates are not allowed.", 'upsite'),
				'section' => 'default_controls_section',
				'include_time' => false,
				'allow_past_date' => false,
				'twelve_hour_format' => true,
				'min_year' => '2016',
				'max_year' => '2099',
			)
		));
	}
}


/**
 * Render Callback for displaying the footer credits
 */
function upsite_get_credits_render_callback()
{
	echo upsite_get_credits();
}

/**
 * Load all our Customizer Custom Controls
 */
require_once trailingslashit(dirname(__FILE__)) . 'custom-controls.php';

/**
 * Initialise our Customizer settings
 */
//$upsite_settings = new upsite_initialise_customizer_settings();
