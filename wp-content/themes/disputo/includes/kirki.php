<?php
/* ---------------------------------------------------------
Custom Controls
----------------------------------------------------------- */

add_action( 'customize_register', function( $wp_customize ) {
	/**
	 * The custom control class
	 */
	class Kirki_Controls_Subtitle_Control extends Kirki_Control_Base {
        public $type = 'subtitle';
        public function render_content() { 
			echo '<h2 class="disputo-customizer-title">' . $this->setting->default . '</h2>';
		}
    }
    // Register our custom control with Kirki
    add_filter( 'kirki_control_types', function( $controls ) {
        $controls['subtitle'] = 'Kirki_Controls_Subtitle_Control';
        return $controls;
    } );

} );

/* ---------------------------------------------------------
Custom Customizer Styles & Scripts
----------------------------------------------------------- */

function disputo_customizer_script() {
	wp_enqueue_script( 'disputo-customizer', get_template_directory_uri() . '/includes/js/customizer.js', array( 'jquery','customize-preview' ),'',true);
}

add_action( 'customize_controls_print_scripts', 'disputo_customizer_script');

function disputo_customizer_style() {
	wp_enqueue_style( 'disputo-customizer', get_template_directory_uri() . '/includes/css/customizer.css', NULL, NULL, 'all' );
}

add_action( 'customize_controls_print_styles', 'disputo_customizer_style' );

/* ---------------------------------------------------------
Config
----------------------------------------------------------- */

$kirki_prefix = "disputo_";

Kirki::add_config( $kirki_prefix . 'theme_config_id', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod'
));

/* ---------------------------------------------------------
Panel & Sections
----------------------------------------------------------- */

Kirki::add_panel( $kirki_prefix . 'theme_settings', array(
    'priority'    => 10,
    'title'       => esc_html__( 'Theme Settings', 'disputo' )
));

Kirki::add_section( $kirki_prefix . 'general', array(
    'title'     => esc_html__( 'General', 'disputo' ),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 1,
));

Kirki::add_section( $kirki_prefix . 'header', array(
    'title'     => esc_html__( 'Header', 'disputo' ),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 2,
));

Kirki::add_section( $kirki_prefix . 'login', array(
    'title'     => esc_html__( 'Header Buttons', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 3,
));

Kirki::add_section( $kirki_prefix . 'bbpress', array(
    'title'     => esc_html__( 'bbPress', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 4,
));

Kirki::add_section( $kirki_prefix . 'profile', array(
    'title'     => esc_html__( 'User Profiles', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 5,
));

Kirki::add_section( $kirki_prefix . 'blog', array(
    'title'     => esc_html__( 'Blog', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 6,
));

Kirki::add_section( $kirki_prefix . 'user_blog', array(
    'title'     => esc_html__( 'User Blog', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 7,
));

Kirki::add_section( $kirki_prefix . 'typography', array(
    'title'     => esc_html__( 'Typography', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 8,
));

Kirki::add_section( $kirki_prefix . 'woocommerce', array(
    'title'     => esc_html__( 'Woocommerce', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 9,
));

Kirki::add_section( $kirki_prefix . 'facebook', array(
    'title'     => esc_html__( 'Facebook Comments', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 10,
));

Kirki::add_section( $kirki_prefix . 'footer', array(
    'title'     => esc_html__( 'Footer', 'disputo'),
    'panel'     => $kirki_prefix . 'theme_settings',
    'priority'  => 11,
));

/* ---------------------------------------------------------
Fields
----------------------------------------------------------- */

/* Colors */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'link_color',
	'label'       => esc_html__( 'Default Link Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#364253',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'link_hover_color',
	'label'       => esc_html__( 'Default Link Hover Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#1d84b5',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'primary_btn_color',
	'label'       => esc_html__( 'Primary Button Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'primary_btn_bg_color',
	'label'       => esc_html__( 'Primary Button Background Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#364253',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'primary_btn_bg_hover_color',
	'label'       => esc_html__( 'Primary Button Background Hover Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#2a3441',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'info_btn_color',
	'label'       => esc_html__( 'Info Button Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'info_btn_bg_color',
	'label'       => esc_html__( 'Info Button Background Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#1d84b5',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'info_btn_bg_hover_color',
	'label'       => esc_html__( 'Info Button Background Hover Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#0076ad',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'primary_badge_color',
	'label'       => esc_html__( 'Primary Badge Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'primary_badge_bg_color',
	'label'       => esc_html__( 'Primary Badge Background Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#364253',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'info_badge_color',
	'label'       => esc_html__( 'Info Badge Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'info_badge_bg_color',
	'label'       => esc_html__( 'Info Badge Background Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#1d84b5',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'tooltip_color',
	'label'       => esc_html__( 'Tooltip Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'tooltip_bg_color',
	'label'       => esc_html__( 'Tooltip Background Color', 'disputo'),
	'section'     => 'colors',
	'default'     => '#1d84b5',
));

/* Site Title */
    
Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'logo_height',
	'label'       => esc_html__( 'Logo Height', 'disputo'),
    'description' => esc_html__( 'Maximum logo height in pixels on large screens.', 'disputo'),
	'section'     => 'title_tagline',
	'default'     => 50,
	'choices'     => array(
		'min'  => 10,
		'max'  => 200,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'logo_width',
	'label'       => esc_html__( 'Logo Width (Mobile Mode)', 'disputo'),
    'description' => esc_html__( 'Maximum logo width in pixels on mobile devices.', 'disputo'),
	'section'     => 'title_tagline',
	'default'     => 200,
	'choices'     => array(
		'min'  => 50,
		'max'  => 480,
		'step' => 1,
	),
));

/* General */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'no_boxed',
	'label'       => esc_html__( 'Remove Page Padding and Shadow', 'disputo'),
	'section'     => $kirki_prefix . 'general',
	'default'     => 0
));

/* Header */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => $kirki_prefix . 'header_img',
	'label'       => esc_html__( 'Default Header Cover Image', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'header_bg_color',
	'label'       => esc_html__( 'Header Background Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#364253',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'header_padding',
	'label'       => esc_html__( 'Header Vertical Padding', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => 180,
	'choices'     => array(
		'min'  => 0,
		'max'  => 300,
		'step' => 5,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'header_m_padding',
	'label'       => esc_html__( 'Header Vertical Padding (Mobile)', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => 80,
	'choices'     => array(
		'min'  => 0,
		'max'  => 300,
		'step' => 5,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_overlay',
	'section'     => $kirki_prefix . 'header',
	'default'     => esc_html__( 'Overlay', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'enable_overlay',
	'label'       => esc_html__( 'Cover Image Overlay', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'overlay_bg_color',
	'label'       => esc_html__( 'First Overlay Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => 'rgba(29,132,181,0.7)',
	'choices'     => array(
		'alpha' => true,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'overlay_2_bg_color',
	'label'       => esc_html__( 'Second Overlay Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#364253',
	'choices'     => array(
		'alpha' => true,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_search_menu',
	'section'     => $kirki_prefix . 'header',
	'default'     => esc_html__( 'Search Box & Menu', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'header_heading_color',
	'label'       => esc_html__( 'Search Box Text Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'header_btn_color',
	'label'       => esc_html__( 'Button Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'header_btn_bg_color',
	'label'       => esc_html__( 'Button Background Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#1d84b5',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'header_btn_bg_hover_color',
	'label'       => esc_html__( 'Button Background Hover Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#0076ad',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'menu_text_color',
	'label'       => esc_html__( 'Menu Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'dropdown_text_color',
	'label'       => esc_html__( 'Dropdown Menu Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'dropdown_bg_color',
	'label'       => esc_html__( 'Dropdown Menu Background Color', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => '#1d84b5',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'dropdown_min_width',
	'label'       => esc_html__( 'Dropdown Menu Width (em)', 'disputo'),
	'section'     => $kirki_prefix . 'header',
	'default'     => 12,
	'choices'     => array(
		'min'  => 6,
		'max'  => 18,
		'step' => 1,
	),
));

/* Header Buttons */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'switch',
	'settings'    => $kirki_prefix . 'enable_login',
	'label'       => esc_html__( 'Login Button', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => 0,
    'choices'     => array(
		'on'  => esc_html__( 'Enable', 'disputo' ),
		'off' => esc_html__( 'Disable', 'disputo' ),
	)
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'login_text',
	'label'       => esc_html__( 'Login Button Text', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => esc_html__('Login', 'disputo'),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'link',
	'settings'    => $kirki_prefix . 'login_url',
	'label'       => esc_html__( 'Login Button URL (Optional)', 'disputo'),
	'description'  => esc_html__( 'If you add a custom url, the login form will be disabled.', 'disputo'),
	'section'     => $kirki_prefix . 'login'
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'register_link',
	'label'       => esc_html__( 'Register Link', 'disputo'),
	'description' => esc_html__( 'You should enable site registration from Settings -> General -> Membership to make it work.', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'register_text',
	'label'       => esc_html__( 'Register Text', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => esc_html__('Register', 'disputo'),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'link',
	'settings'    => $kirki_prefix . 'register_url',
	'label'       => esc_html__( 'Custom Register URL (Optional)', 'disputo'),
	'section'     => $kirki_prefix . 'login'
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'lost_password_link',
	'label'       => esc_html__( 'Lost Password Link', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'lost_password_text',
	'label'       => esc_html__( 'Lost Password Text', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => esc_html__('Lost Password?', 'disputo'),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'link',
	'settings'    => $kirki_prefix . 'lost_password_url',
	'label'       => esc_html__( 'Custom Lost Password URL (Optional)', 'disputo'),
	'section'     => $kirki_prefix . 'login'
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'switch',
	'settings'    => $kirki_prefix . 'enable_woo_icon',
	'label'       => esc_html__( 'WooCommerce Shopping Cart', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => 0,
    'choices'     => array(
		'on'  => esc_html__( 'Enable', 'disputo' ),
		'off' => esc_html__( 'Disable', 'disputo' ),
	)
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'switch',
	'settings'    => $kirki_prefix . 'enable_user_menu',
	'label'       => esc_html__( 'User Menu', 'disputo'),
	'section'     => $kirki_prefix . 'login',
	'default'     => 0,
    'choices'     => array(
		'on'  => esc_html__( 'Enable', 'disputo' ),
		'off' => esc_html__( 'Disable', 'disputo' ),
	)
));


Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'sortable',
	'settings'    => $kirki_prefix . 'default_user_menu_items',
	'label'       => esc_html__( 'User Menu Items', 'disputo' ),
	'section'     => $kirki_prefix . 'login',
	'default'     => array('high', 'profile', 'mywall', 'myblog', 'messages','medium', 'topics', 'replies', 'engagements', 'favorites', 'subscriptions', 'editprofile', 'shop', 'low', 'logout'),
	'choices'     => array(
		'high' => esc_html__( 'Additional Menu Items (High)', 'disputo' ),
		'profile' => esc_html__( 'Profile', 'disputo' ),
		'mywall' => esc_html__( 'My Wall', 'disputo' ),
		'myblog' => esc_html__( 'My Blog', 'disputo' ),
		'messages' => esc_html__( 'Messages', 'disputo' ),
		'medium' => esc_html__( 'Additional Menu Items (Medium)', 'disputo' ),
		'topics' => esc_html__( 'Topics Started', 'disputo' ),
        'replies' => esc_html__( 'Replies Created', 'disputo' ),
		'engagements' => esc_html__( 'Engagements', 'disputo' ),
		'favorites' => esc_html__( 'Favorites', 'disputo' ),
		'subscriptions' => esc_html__( 'Subscriptions', 'disputo' ),
		'editprofile' => esc_html__( 'Edit Profile', 'disputo' ),
		'shop' => esc_html__( 'Shop Account (WooCommerce)', 'disputo' ),
        'low' => esc_html__( 'Additional Menu Items (Low)', 'disputo' ),
		'logout' => esc_html__( 'Logout', 'disputo' ),
	),
	'priority'    => 10,
));


Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
		'type'        => 'repeater',
		'settings'    => $kirki_prefix . 'user_menu_items',
		'label'       => esc_html__( 'Additional User Menu Items', 'disputo' ),
		'description' => esc_html__( 'Each row is a new menu item.', 'disputo' ),
		'section'     => $kirki_prefix . 'login',
        'row_label' => array(
            'type'  => 'field',
            'value' => esc_html__( 'Menu Item', 'disputo' ),
            'field' => 'title',
        ),
        'default'      => array(
            array(
                'title' => esc_html__( 'Menu item...', 'disputo' ),
                'destination_url'  => '#',
                'priority' => 'hidden'
            ),
        ),
		'fields'      => array(
            'title'    => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Title', 'disputo' ),
				'description' => '',
				'default'     => ''
			),
			'destination_url'    => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Destination URL', 'disputo' ),
				'description' => '',
				'default'     => ''
			),
            'priority'    => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Priority', 'disputo' ),
				'description' => '',
				'default'     => 'medium',
                'choices'     => array(
                    'high'   => esc_html__( 'High', 'disputo' ),
                    'medium'   => esc_html__( 'Medium', 'disputo' ),
                    'low' => esc_html__( 'Low', 'disputo' ),
                    'hidden' => esc_html__( 'Hidden', 'disputo' )
                ),
			),
		),
));

/* bbPress */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => $kirki_prefix . 'bbpress_img',
	'label'       => esc_html__( 'Default bbPress Cover Image', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_breadcrumb',
	'label'       => esc_html__( 'Remove bbPress Breadcrumb', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'popular_topic_at_most',
	'label'       => esc_html__( 'Popular Topic Widget Show at Most', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 5,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'max_topic_length',
	'label'       => esc_html__( 'Maximum Topic Title Length', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 80,
	'choices'     => array(
		'min'  => 1,
		'max'  => 999,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_search',
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => esc_html__( 'Search', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_search',
	'label'       => esc_html__( 'Display Search Box', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'live_search',
	'label'       => esc_html__( 'Enable Live Search', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'live_search_at_most',
	'label'       => esc_html__( 'Live search show at most', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 5,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_text_editor',
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => esc_html__( 'Text Editor', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_visual',
	'label'       => esc_html__( 'Visual Editor', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_visual_teeny',
	'label'       => esc_html__( 'Teeny Mode', 'disputo'),
    'description' => esc_html__( 'Minimal version of visual editor.', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_visual_media',
	'label'       => esc_html__( 'Media Upload', 'disputo'),
    'description' => esc_html__( 'Allow your members the ability to upload media files to their posts.', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_visual_html',
	'label'       => esc_html__( 'HTML Editor', 'disputo'),
    'description' => esc_html__( 'Allow your members the ability to use HTML tags.', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_sidebars',
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => esc_html__( 'Sidebars', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_forum_sidebar',
	'label'       => esc_html__( 'Forum Sidebar', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress'
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_topic_sidebar',
	'label'       => esc_html__( 'Topic Sidebar', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_search_sidebar',
	'label'       => esc_html__( 'Search Sidebar', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_role_names',
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => esc_html__( 'Custom Role Names', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'role_keymaster',
	'label'       => esc_html__( 'Keymaster', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'keymaster_color',
	'label'       => esc_html__( 'Keymaster Badge Color', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
	'transport'   => 'auto',
	'output' => array(
		array(
			'element' => '.disputo-user-bbp_keymaster .bbp-author-role,.disputo-user-bbp_keymaster .badge',
			'property' => 'background',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'role_moderator',
	'label'       => esc_html__( 'Moderator', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'moderator_color',
	'label'       => esc_html__( 'Moderator Badge Color', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
	'transport'   => 'auto',
	'output' => array(
		array(
			'element' => '.disputo-user-bbp_moderator .bbp-author-role,.disputo-user-bbp_moderator .badge',
			'property' => 'background',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'role_participant',
	'label'       => esc_html__( 'Participant', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'participant_color',
	'label'       => esc_html__( 'Participant Badge Color', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
	'transport'   => 'auto',
	'output' => array(
		array(
			'element' => '.disputo-user-bbp_participant .bbp-author-role,.disputo-user-bbp_participant .badge',
			'property' => 'background',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'role_spectator',
	'label'       => esc_html__( 'Spectator', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'spectator_color',
	'label'       => esc_html__( 'Spectator Badge Color', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
	'transport'   => 'auto',
	'output' => array(
		array(
			'element' => '.disputo-user-bbp_spectator .bbp-author-role,.disputo-user-bbp_spectator .badge',
			'property' => 'background',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'role_blocked',
	'label'       => esc_html__( 'Blocked', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'blocked_color',
	'label'       => esc_html__( 'Blocked Badge Color', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => '',
	'transport'   => 'auto',
	'output' => array(
		array(
			'element' => '.disputo-user-bbp_blocked .bbp-author-role,.disputo-user-bbp_blocked .badge',
			'property' => 'background',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_follow_user',
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => esc_html__( 'Follow User', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_follow_user',
	'label'       => esc_html__( 'Follow User', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'bbpress_follow_users_load',
	'label'       => esc_html__( 'Number of Users Per Load', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 10,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'bbpress_follow_topics_load',
	'label'       => esc_html__( 'Number of Topics Per Load', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 10,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'bbpress_follow_limit_topic',
	'label'       => esc_html__( 'Limit The Length of Topic Title', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 10,
	'choices'     => array(
		'min'  => 1,
		'max'  => 999,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'bbpress_follow_limit_topic_desc',
	'label'       => esc_html__( 'Limit The Length of Topic Description', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 40,
	'choices'     => array(
		'min'  => 1,
		'max'  => 999,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_solved_topic',
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => esc_html__( 'Solved Topic & Best Answer', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'lead_topic',
	'label'       => esc_html__( 'Lead Topic Layout', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'solved_topic',
	'label'       => esc_html__( 'Solved Topic & Best Answer', 'disputo'),
	'description'       => esc_html__( 'Lead topic layout must be enabled.', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_other_features',
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => esc_html__( 'Other Features', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'badges',
	'label'       => esc_html__( 'Forum & Topic Badges', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_report',
	'label'       => esc_html__( 'Report Content', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_quote',
	'label'       => esc_html__( 'Quote Topics & Replies', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_private_reply',
	'label'       => esc_html__( 'Private Reply', 'disputo'),
	'section'     => $kirki_prefix . 'bbpress',
	'default'     => 1
));

/* User Profiles */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => $kirki_prefix . 'default_avatar',
	'label'       => esc_html__( 'Default avatar', 'disputo'),
    'description' => esc_html__( 'Default avatar must be selected as "Disputo Avatar" (Go to Settings -> Discussion -> Default Avatar)', 'disputo'),
	'section'     => $kirki_prefix . 'profile',
	'default'     => get_template_directory_uri() . '/images/avatar.png',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_user_avatar',
	'label'       => esc_html__( 'Enable Custom Avatar', 'disputo'),
	'section'     => $kirki_prefix . 'profile',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_user_img',
	'label'       => esc_html__( 'Enable Custom Cover Image', 'disputo'),
	'section'     => $kirki_prefix . 'profile',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_social_icons',
	'label'       => esc_html__( 'Enable Social Icons', 'disputo'),
	'section'     => $kirki_prefix . 'profile',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_signature',
	'label'       => esc_html__( 'Enable Forum Signature', 'disputo'),
	'section'     => $kirki_prefix . 'profile',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_header_signature',
	'label'       => esc_html__( 'Add Forum Signatures to User Profile Headers', 'disputo'),
	'section'     => $kirki_prefix . 'profile',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'bbpress_flags',
	'label'       => esc_html__( 'Enable Flags', 'disputo'),
	'section'     => $kirki_prefix . 'profile',
	'default'     => 0
));

/* Blog */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'blog_subtitle',
	'label'       => esc_html__( 'Default Blog Subtitle (Optional)', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'removemeta',
	'label'       => esc_html__( 'Post Meta Data', 'disputo'),
	'description'  => esc_html__( 'Post date, categories, tags.', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_author',
	'section'     => $kirki_prefix . 'blog',
	'default'     => esc_html__( 'Author', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'enable_author_box',
	'label'       => esc_html__( 'Author Box', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'select',
	'settings'    => $kirki_prefix . 'author_page_layout',
	'label'       => esc_html__( 'Author page layout', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 'twocolumnssidebar',
    'choices'     => array(
		'twocolumnssidebar' => esc_html__( 'Two Columns + Sidebar', 'disputo'),
        'onecolumn' => esc_html__( 'One Column + Sidebar', 'disputo'),
		'twocolumns' => esc_html__( 'Two Columns', 'disputo'),
        'threecolumns' => esc_html__( 'Three Columns', 'disputo'),
        'fourcolumns' => esc_html__( 'Four Columns', 'disputo')
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'author_at_most',
	'label'       => esc_html__( 'Author Page Pagination', 'disputo'),
    'description' => esc_html__( 'Maximum number of the posts.', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 6,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_archive',
	'section'     => $kirki_prefix . 'blog',
	'default'     => esc_html__( 'Archive', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'select',
	'settings'    => $kirki_prefix . 'archive_page_layout',
	'label'       => esc_html__( 'Archive page layout', 'disputo'),
    'description' => esc_html__( 'Category, archive and search pages', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 'twocolumnssidebar',
    'choices'     => array(
		'twocolumnssidebar' => esc_html__( 'Two Columns + Sidebar', 'disputo'),
        'onecolumn' => esc_html__( 'One Column + Sidebar', 'disputo'),
		'twocolumns' => esc_html__( 'Two Columns', 'disputo'),
        'threecolumns' => esc_html__( 'Three Columns', 'disputo'),
        'fourcolumns' => esc_html__( 'Four Columns', 'disputo')
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'archive_at_most',
	'label'       => esc_html__( 'Archive Page Pagination', 'disputo'),
    'description' => esc_html__( 'Maximum number of the posts.', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 6,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'search_exclude_pages',
	'label'       => esc_html__( 'Exclude pages from blog search results', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_social_sharing',
	'section'     => $kirki_prefix . 'blog',
	'default'     => esc_html__( 'Social Media Sharing', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'enable_sharing',
	'label'       => esc_html__( 'Social Media Sharing Buttons', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
    'type'     => 'multicheck',
		'settings' => $kirki_prefix . 'selected_share',
		'label'    => esc_html__( 'Available Social Media Buttons', 'disputo'),
		'section'  => $kirki_prefix . 'blog',
		'default'  => array( 'email','facebook', 'twitter', 'linkedin', 'tumblr', 'reddit', 'pinterest' ),
		'choices'  => array(
            'email' => esc_html__( 'Email', 'disputo' ),
			'facebook' => esc_html__( 'Facebook', 'disputo' ),
			'twitter' => esc_html__( 'Twitter', 'disputo' ),
            'linkedin' => esc_html__( 'Linkedin', 'disputo' ),
			'tumblr' => esc_html__( 'Tumblr', 'disputo' ),
            'reddit' => esc_html__( 'Reddit', 'disputo' ),
            'vk' => esc_html__( 'VK', 'disputo' ),
			'pinterest' => esc_html__( 'Pinterest', 'disputo' ),
			'whatsapp' => esc_html__( 'Whatsapp', 'disputo' ),
            'pocket' => esc_html__( 'Pocket', 'disputo' ),
            'hackernews' => esc_html__( 'Hackernews', 'disputo' ),
            'xing' => esc_html__( 'Xing', 'disputo' ),
		),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'subtitle',
	'settings'    => $kirki_prefix . 'title_blog_templates',
	'section'     => $kirki_prefix . 'blog',
	'default'     => esc_html__( 'Blog Templates', 'disputo' )
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'blog_1_at_most',
	'label'       => esc_html__( 'Blog Page Template - 1 Column', 'disputo'),
    'description' => esc_html__( 'Maximum number of the posts.', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 4,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'blog_2_at_most',
	'label'       => esc_html__( 'Blog Page Template - 2 Column', 'disputo'),
    'description' => esc_html__( 'Maximum number of the posts.', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 6,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'blog_3_at_most',
	'label'       => esc_html__( 'Blog Page Template - 3 Column', 'disputo'),
    'description' => esc_html__( 'Maximum number of the posts.', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 9,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'blog_4_at_most',
	'label'       => esc_html__( 'Blog Page Template - 4 Column', 'disputo'),
    'description' => esc_html__( 'Maximum number of the posts.', 'disputo'),
	'section'     => $kirki_prefix . 'blog',
	'default'     => 12,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

/* User Blog */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'switch',
	'settings'    => $kirki_prefix . 'enable_user_blog',
    'label'       => esc_html__( 'Front-End Post Submission', 'disputo'),
	'description' => esc_html__( 'Give your members the ability to create blog posts.', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 0,
    'choices'     => array(
		'on'  => esc_html__( 'Enable', 'disputo' ),
		'off' => esc_html__( 'Disable', 'disputo' ),
	)
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'switch',
	'settings'    => $kirki_prefix . 'user_post_status',
    'label'       => esc_html__( 'Default User Post Status', 'disputo'),
	'description' => esc_html__( 'To allow everyone to publish post without admin approval, select "published".', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 0,
    'choices'     => array(
		'on'  => esc_html__( 'Published', 'disputo' ),
		'off' => esc_html__( 'Pending', 'disputo' ),
	)
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'user_blog_verified',
	'label'       => esc_html__( 'Only Verified Users', 'disputo'),
    'description' => esc_html__( 'Allow only verified users the ability to submit post.', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'enable_visual_teeny',
	'label'       => esc_html__( 'Teeny Mode', 'disputo'),
    'description' => esc_html__( 'Minimal version of visual editor.', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'enable_media_upload',
	'label'       => esc_html__( 'Media Upload', 'disputo'),
    'description' => esc_html__( 'Allow your members the ability to upload media files to their posts.', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'enable_visual_html',
	'label'       => esc_html__( 'HTML Editor', 'disputo'),
    'description' => esc_html__( 'Allow your members the ability to use HTML tags.', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'title_length',
	'label'       => esc_html__( 'Maximum title length', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 60,
	'choices'     => array(
		'min'  => 1,
		'max'  => 120,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'excerpt_length',
	'label'       => esc_html__( 'Maximum excerpt length', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 120,
	'choices'     => array(
		'min'  => 1,
		'max'  => 300,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'max_user_blog_post',
	'label'       => esc_html__( 'Maximum number of posts', 'disputo'),
	'description' => esc_html__( 'The maximum number of the posts which are displayed in pending and published posts tabs on user profile.', 'disputo'),
	'section'     => $kirki_prefix . 'user_blog',
	'default'     => 20,
	'choices'     => array(
		'min'  => 1,
		'max'  => 999,
		'step' => 1,
	),
));

/* Typography */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'disable_external_script',
	'label'       => esc_html__( 'Stop Using Google CDN', 'disputo'),
    'description' => esc_html__( 'The default fonts of the theme (Lato) is loaded via Google CDN.', 'disputo'),
	'section'     => $kirki_prefix . 'typography',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'default_font_size',
	'label'       => esc_html__( 'Default Browser Font Size (px)', 'disputo'),
	'section'     => $kirki_prefix . 'typography',
	'default'     => 17,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'typography',
	'settings'    => $kirki_prefix . 'body_fonts',
	'label'       => esc_html__( 'Body', 'disputo' ),
	'section'     => $kirki_prefix . 'typography',
	'default'     => array(
		'font-family'    => 'Lato',
		'variant'        => 'regular',
        'subsets'        => array( 'latin-ext' ),
		'line-height'    => '1.7',
		'letter-spacing' => '0',
		'color'          => '#6b717e'
	),
    'transport'   => 'auto',
	'output' => array(
		array(
			'element' => 'body',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'typography',
	'settings'    => $kirki_prefix . 'heading_fonts',
	'label'       => esc_html__( 'Headings', 'disputo' ),
	'section'     => $kirki_prefix . 'typography',
	'default'     => array(
		'font-family'    => 'Lato',
		'variant'        => '700',
        'subsets'        => array( 'latin-ext' ),
		'line-height'    => '1.4',
		'letter-spacing' => '0',
		'color'          => '#364253',
		'text-transform' => 'none'
	),
    'transport'   => 'auto',
	'output' => array(
		array(
			'element' => 'h1,h2,h3,h4,h5,.h1,.h2,.h3,.h4,.h5,.forum-titles,.topic-titles,.popover-header',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'typography',
	'settings'    => $kirki_prefix . 'header_title_fonts',
	'label'       => esc_html__( 'Header Title', 'disputo' ),
	'section'     => $kirki_prefix . 'typography',
	'default'     => array(
		'font-family'    => 'Lato',
		'variant'        => '700',
        'subsets'        => array( 'latin-ext' ),
		'line-height'    => '1',
		'letter-spacing' => '0',
		'text-transform' => 'uppercase',
		'font-size' => '2.5rem',
		'color'          => '#ffffff',
	),
    'transport'   => 'auto',
	'output' => array(
		array(
			'element' => '.disputo-page-title h1',
		),
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'typography',
	'settings'    => $kirki_prefix . 'header_sub_title_fonts',
	'label'       => esc_html__( 'Header Sub Title', 'disputo' ),
	'section'     => $kirki_prefix . 'typography',
	'default'     => array(
		'font-family'    => 'Lato',
		'variant'        => 'italic',
        'subsets'        => array( 'latin-ext' ),
		'line-height'    => '1.4',
		'letter-spacing' => '0',
		'text-transform' => 'none',
		'font-size' => '1.5rem',
		'color'          => '#ffffff',
	),
    'transport'   => 'auto',
	'output' => array(
		array(
			'element' => '.disputo-page-title p',
		),
	),
));

/* Woocommerce */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => $kirki_prefix . 'shop_cover_img',
	'label'       => esc_html__( 'Default Shop Cover Image', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'woocommerce_sidebar',
	'label'       => esc_html__( 'Sidebar', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'select',
	'settings'    => $kirki_prefix . 'shop_layout',
	'label'       => esc_html__( 'Product layout', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 'twocolumns',
    'choices'     => array(
		'twocolumns' => esc_html__( 'Two Columns', 'disputo'),
		'threecolumns' => esc_html__( 'Three Columns', 'disputo'),
        'fourcolumns' => esc_html__( 'Four Columns', 'disputo')
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'select',
	'settings'    => $kirki_prefix . 'product_thumbnail',
	'label'       => esc_html__( 'Product Thumbnail Size', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 'large',
    'choices'     => array(
		'large' => esc_html__( 'Large', 'disputo'),
		'full' => esc_html__( 'Full', 'disputo'),
        'medium' => esc_html__( 'Medium', 'disputo'),
        'shop_thumbnail' => esc_html__( 'Default', 'disputo')
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'select',
	'settings'    => $kirki_prefix . 'product_image',
	'label'       => esc_html__( 'Single Product Image Size', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 'full',
    'choices'     => array(
		'large' => esc_html__( 'Large', 'disputo'),
		'full' => esc_html__( 'Full', 'disputo'),
        'medium' => esc_html__( 'Medium', 'disputo'),
        'shop_single' => esc_html__( 'Default', 'disputo')
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'slider',
	'settings'    => $kirki_prefix . 'product_img_size',
	'label'       => esc_html__( 'Single Product Image Column Size in Percents', 'disputo' ),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 50,
	'choices'     => array(
		'min'  => '30',
		'max'  => '70',
		'step' => '1',
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => $kirki_prefix . 'woo_placeholder',
	'label'       => esc_html__( 'Placeholder Image', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => get_template_directory_uri() . '/images/woocommerce-placeholder.png',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'remove_related',
	'label'       => esc_html__( 'Related Products', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 1
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'toggle',
	'settings'    => $kirki_prefix . 'enable_product_sharing',
	'label'       => esc_html__( 'Social Media Sharing Buttons', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 0
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'shop_at_most',
	'label'       => esc_html__( 'Shop page show at most', 'disputo'),
    'description' => esc_html__( 'Maximum number of the products.', 'disputo'),
	'section'     => $kirki_prefix . 'woocommerce',
	'default'     => 8,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

/* Facebook Comments */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'switch',
	'settings'    => $kirki_prefix . 'activate_fb_comments',
	'label'       => esc_html__( 'Facebook Comments', 'disputo'),
    'description' => esc_html__( '(Facebook API is required).', 'disputo'),
	'section'     => $kirki_prefix . 'facebook',
	'default'     => 0,
    'choices'     => array(
		'on'  => esc_html__( 'Enable', 'disputo' ),
		'off' => esc_html__( 'Disable', 'disputo' ),
	)
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'fb_id',
	'label'       => esc_html__( 'Facebook APP ID (REQUIRED)', 'disputo'),
    'description' => esc_html__( 'For more information, please read the help documentation.', 'disputo'),
	'section'     => $kirki_prefix . 'facebook',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'text',
	'settings'    => $kirki_prefix . 'fb_title',
	'label'       => esc_html__( 'Title', 'disputo'),
	'section'     => $kirki_prefix . 'facebook',
	'default'     => '',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'select',
	'settings'    => $kirki_prefix . 'fb_color_scheme',
	'label'       => esc_html__( 'Color Scheme', 'disputo'),
	'section'     => $kirki_prefix . 'facebook',
	'default'     => 'light',
    'choices'     => array(
		'light' => esc_html__( 'Light', 'disputo'),
		'dark' => esc_html__( 'Dark', 'disputo')
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => $kirki_prefix . 'fb_max',
	'label'       => esc_html__( 'Number of the comments', 'disputo'),
	'section'     => $kirki_prefix . 'facebook',
	'default'     => 5,
	'choices'     => array(
		'min'  => 1,
		'max'  => 99,
		'step' => 1,
	),
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'select',
	'settings'    => $kirki_prefix . 'fb_order',
	'label'       => esc_html__( 'Data Order by', 'disputo'),
    'description' => esc_html__( 'The order to use when displaying comments.', 'disputo'),
	'section'     => $kirki_prefix . 'facebook',
	'default'     => 'social',
    'choices'     => array(
		'social' => esc_html__( 'Social', 'disputo'),
		'time' => esc_html__( 'Oldest', 'disputo'),
        'reverse_time' => esc_html__( 'Newest', 'disputo')
	),
));

/* Footer */

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_heading_color',
	'label'       => esc_html__( 'Heading Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_text_color',
	'label'       => esc_html__( 'Text Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#bdc3c7',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_link_color',
	'label'       => esc_html__( 'Link Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#bdc3c7',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_link_hover_color',
	'label'       => esc_html__( 'Link Hover Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_bg_color',
	'label'       => esc_html__( 'Background Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#364253',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_btn_color',
	'label'       => esc_html__( 'Button Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#ffffff',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_btn_bg_color',
	'label'       => esc_html__( 'Button Background Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#1d84b5',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
	'type'        => 'color',
	'settings'    => $kirki_prefix . 'footer_btn_bg_hover_color',
	'label'       => esc_html__( 'Button Background Hover Color', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
	'default'     => '#0076ad',
));

Kirki::add_field( $kirki_prefix . 'theme_config_id', array(
    'type'        => 'textarea',
    'settings'     => $kirki_prefix . 'footermessage',
	'label'       => esc_html__( 'Credits', 'disputo'),
	'section'     => $kirki_prefix . 'footer',
    'default'     => '',
));
?>