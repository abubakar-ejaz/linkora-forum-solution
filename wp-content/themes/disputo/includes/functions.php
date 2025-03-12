<?php
if ( !defined('ABSPATH')) exit;

if ( ! function_exists( 'disputo_theme_setup' ) ) {
    function disputo_theme_setup() {
        
        // Set the default content width.
        $GLOBALS['content_width'] = 1370;
        
        /* Translations */
        load_theme_textdomain( 'disputo', get_template_directory() .'/languages' );
        $disputo_locale = get_locale();
        $disputo_locale_file = get_template_directory() ."/languages/$disputo_locale.php";
        if ( is_readable($disputo_locale_file) ) {
	       require_once($disputo_locale_file);
        }
        
        /* Add theme support */
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'title-tag' );
        
        /* Woocommerce */
        add_theme_support( 'woocommerce', array(
            'gallery_thumbnail_image_width' => 200
        ) );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
        
        /* Logo */
        $disputo_logo = array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true
        );
        add_theme_support( 'custom-logo', $disputo_logo );
        
        /* Background */
        $disputo_bg = array(
            'default-color' => 'f1f1f1'
        );
        add_theme_support( 'custom-background', $disputo_bg );
        
        /* Add tinymce editor style */
        add_editor_style();
        
        /* Register Menus */
        register_nav_menus(
            array(
                'disputo-main-menu' => esc_html__( 'Main Menu', 'disputo' )
            )
        );
        
        /* Add thumbnail support to bbPress forums */
        add_post_type_support('forum', 'thumbnail');
        
    }
}
add_action( 'after_setup_theme', 'disputo_theme_setup' );

/*---------------------------------------------------
Change logo link class
----------------------------------------------------*/
function disputo_change_logo_class( $html ) {
    $html = str_replace( 'custom-logo-link', 'navbar-brand', $html );
    return $html;
}

add_filter( 'get_custom_logo', 'disputo_change_logo_class' );

/*---------------------------------------------------
Add a body class
----------------------------------------------------*/

if ( ! function_exists( 'disputo_body_classes' ) ) {
function disputo_body_classes( $classes ) {
    $classes[] = 'disputo';    
    return $classes;    
}
}
add_filter( 'body_class','disputo_body_classes' );

/*---------------------------------------------------
Add a pingback url auto-discovery header for single posts, pages, or attachments.
----------------------------------------------------*/

function disputo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'disputo_pingback_header' );

/*---------------------------------------------------
Add active class to the menu items
----------------------------------------------------*/

if ( ! function_exists( 'disputo_nav_class' ) ) {
function disputo_nav_class ($classes, $item) {
    if (in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ){
        $classes[] = 'disputo-active-menu-item ';
    }
    return $classes;
}
}
add_filter('nav_menu_css_class' , 'disputo_nav_class' , 10 , 2);

/*---------------------------------------------------
Add <span> tags to Archive page titles
----------------------------------------------------*/

if ( ! function_exists( 'disputo_archive_title' ) ) {
function disputo_archive_title( $title ) {
    $parts = explode( ':', $title );
    if ( count( $parts ) > 1 ) {
        $label = array_shift( $parts );
        $parts = implode( ':', $parts );
        $title = sprintf( '<span class="disputo-archive-span">%s: </span>%s', $label, $parts );
    }
    return $title;
}
}
add_filter( 'get_the_archive_title', 'disputo_archive_title' );

/*---------------------------------------------------
Wrap category widget post count in a span
----------------------------------------------------*/
if ( ! function_exists( 'disputo_cat_count_span' ) ) {
function disputo_cat_count_span($links) {
  $links = str_replace('</a> (', '</a> <span class="badge badge-primary">', $links);
  $links = str_replace(')', '</span>', $links);
  return $links;
}
}
add_filter('wp_list_categories', 'disputo_cat_count_span');

/*---------------------------------------------------
Create a wrapper and add provider name to the class
----------------------------------------------------*/
if ( ! function_exists( 'disputo_oembed_wrapper' ) ) {
function disputo_oembed_wrapper($return, $data, $url) {
    
    /* HTML5 Validation */
    $return = str_replace( array('frameborder="0"', 'webkitallowfullscreen', 'mozallowfullscreen'),'', $return );
    $return = preg_replace('/(<[^>]+) allow=".*?"/i', '$1', $return);
    /* HTML5 Validation END */
    
    $provider = '';
    if(isset($data->provider_name)) {
        $provider = esc_attr($data->provider_name);
    }
    if($provider) {
        return "<div class='disputo-iframe-outer'><div class='disputo-iframe $provider'>{$return}</div></div>";
    } else {
        return "<div class='disputo-iframe-outer'><div class='disputo-iframe'>{$return}</div></div>";
    }
}
}
add_filter('oembed_dataparse','disputo_oembed_wrapper',10,3);

/*---------------------------------------------------
Stylesheets
----------------------------------------------------*/

if ( ! function_exists( 'disputo_theme_styles' ) ) {
function disputo_theme_styles()  
{   
    $disputo_disable_external_script = get_theme_mod('disputo_disable_external_script');
    
    // Default Font
    if (!$disputo_disable_external_script) {
        wp_enqueue_style('disputo-font', '//fonts.googleapis.com/css?family=Lato:400,400i,700&subset=latin-ext', false, '');
    }
    
    // Plugins
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/fontawesome.css', false, '1.0.0');
    wp_enqueue_style('slick', get_template_directory_uri() . '/css/slick.css', false, '1.8.0');
    
    // Main Styles
    wp_enqueue_style('disputo-bootstrap', get_template_directory_uri() . '/css/bootstrap.css', false, '4.0.0');
    if (is_rtl()) {
        wp_enqueue_style('disputo-bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', false, '4.0.0');
    }
    wp_enqueue_style('disputo-style', get_stylesheet_uri());
    

    $disputo_default_font_size = esc_attr(get_theme_mod('disputo_default_font_size', 17));
    $disputo_logo_height = esc_attr(get_theme_mod('disputo_logo_height', 50));
    $disputo_logo_width = esc_attr(get_theme_mod('disputo_logo_width', 200));
    $disputo_header_bg_color = esc_attr(get_theme_mod('disputo_header_bg_color', '#364253'));
    $disputo_overlay_bg_color = esc_attr(get_theme_mod('disputo_overlay_bg_color', 'rgba(29,132,181,0.7)'));
    $disputo_overlay_2_bg_color = esc_attr(get_theme_mod('disputo_overlay_2_bg_color', 'rgba(54,66,83,0.9)'));
    $disputo_menu_text_color = esc_attr(get_theme_mod('disputo_menu_text_color', '#ffffff'));
    $disputo_dropdown_text_color = esc_attr(get_theme_mod('disputo_dropdown_text_color', '#ffffff'));
    $disputo_dropdown_bg_color = esc_attr(get_theme_mod('disputo_dropdown_bg_color', '#1d84b5'));
    $disputo_footer_bg_color = esc_attr(get_theme_mod('disputo_footer_bg_color', '#364253'));
    $disputo_link_color = esc_attr(get_theme_mod('disputo_link_color', '#364253'));
    $disputo_link_hover_color = esc_attr(get_theme_mod('disputo_link_hover_color', '#1d84b5'));
    $disputo_header_heading_color = esc_attr(get_theme_mod('disputo_header_heading_color', '#ffffff'));
    $disputo_footer_heading_color = esc_attr(get_theme_mod('disputo_footer_heading_color', '#ffffff'));
    $disputo_footer_text_color = esc_attr(get_theme_mod('disputo_footer_text_color', '#bdc3c7'));  
    $disputo_footer_link_color = esc_attr(get_theme_mod('disputo_footer_link_color', '#bdc3c7')); 
    $disputo_footer_link_hover_color = esc_attr(get_theme_mod('disputo_footer_link_hover_color', '#ffffff')); 
    $disputo_primary_btn_color = esc_attr(get_theme_mod('disputo_primary_btn_color', '#ffffff'));
    $disputo_primary_btn_bg_color = esc_attr(get_theme_mod('disputo_primary_btn_bg_color', '#364253'));
    $disputo_primary_btn_bg_hover_color = esc_attr(get_theme_mod('disputo_primary_btn_bg_hover_color', '#2a3441'));
    $disputo_info_btn_color = esc_attr(get_theme_mod('disputo_info_btn_color', '#ffffff'));
    $disputo_info_btn_bg_color = esc_attr(get_theme_mod('disputo_info_btn_bg_color', '#1d84b5'));
    $disputo_info_btn_bg_hover_color = esc_attr(get_theme_mod('disputo_info_btn_bg_hover_color', '#0076ad'));   
    $disputo_header_btn_color = esc_attr(get_theme_mod('disputo_header_btn_color', '#ffffff'));
    $disputo_header_btn_bg_color = esc_attr(get_theme_mod('disputo_header_btn_bg_color', '#1d84b5'));
    $disputo_header_btn_bg_hover_color = esc_attr(get_theme_mod('disputo_header_btn_bg_hover_color', '#0076ad'));  
    $disputo_footer_btn_color = esc_attr(get_theme_mod('disputo_footer_btn_color', '#ffffff'));
    $disputo_footer_btn_bg_color = esc_attr(get_theme_mod('disputo_footer_btn_bg_color', '#1d84b5'));
    $disputo_footer_btn_bg_hover_color = esc_attr(get_theme_mod('disputo_footer_btn_bg_hover_color', '#0076ad'));   
    $disputo_tooltip_color = esc_attr(get_theme_mod('disputo_tooltip_color', '#ffffff'));
    $disputo_tooltip_bg_color = esc_attr(get_theme_mod('disputo_tooltip_bg_color', '#1d84b5'));   
    $disputo_primary_badge_color = esc_attr(get_theme_mod('disputo_primary_badge_color', '#ffffff'));
    $disputo_primary_badge_bg_color = esc_attr(get_theme_mod('disputo_primary_badge_bg_color', '#364253'));
    $disputo_info_badge_color = esc_attr(get_theme_mod('disputo_info_badge_color', '#ffffff'));
    $disputo_info_badge_bg_color = esc_attr(get_theme_mod('disputo_info_badge_bg_color', '#1d84b5'));
    $disputo_header_padding = esc_attr(get_theme_mod('disputo_header_padding', 180));
    $disputo_header_m_padding = esc_attr(get_theme_mod('disputo_header_m_padding', 80));
    $disputo_dropdown_min_width = esc_attr(get_theme_mod('disputo_dropdown_min_width', 12));
    
    $disputo_inline_style = '';
    
    if ((!empty($disputo_header_padding) && ($disputo_header_padding != 180))) {
        $disputo_inline_style .= '.disputo-page-title {padding: ' . $disputo_header_padding . 'px 0px ' . ($disputo_header_padding + 60) . 'px 0px;}@media only screen and (max-width: 1439px) {.disputo-page-title {padding: ' . ($disputo_header_padding - 40) . 'px 0px;}}';
        $disputo_inline_style .= '.disputo-page-title.noboxed-title {padding: ' . $disputo_header_padding . 'px 0px;}@media only screen and (max-width: 1439px) {.disputo-page-title.noboxed-title {padding: ' . ($disputo_header_padding - 40) . 'px 0px;}}';
    }
    
    if ((!empty($disputo_header_m_padding) && ($disputo_header_m_padding != 80))) {
        $disputo_inline_style .= '@media only screen and (max-width: 767px) {.disputo-page-title {padding: ' . ($disputo_header_m_padding + 40) . 'px 0px;}}@media only screen and (max-width: 576px) {.disputo-page-title {padding: ' . $disputo_header_m_padding . 'px 0px;}}';
    }
    
    if ((!empty($disputo_default_font_size) && ($disputo_default_font_size != 17))) {
        $disputo_inline_style .= 'html { font-size:' . esc_attr($disputo_default_font_size) . 'px }@media only screen and (max-width: 767px) { html {font-size:' . esc_attr($disputo_default_font_size - 1) . 'px}}@media only screen and (max-width: 480px) { html {font-size:' . esc_attr($disputo_default_font_size - 2) . 'px} }';
    }
    
    if ((!empty($disputo_logo_height) && ($disputo_logo_height != 50))) {
        $disputo_inline_style .= '.navbar-brand{ line-height:' . $disputo_logo_height . 'px;}.navbar-brand img { height: ' . $disputo_logo_height . 'px;}';
    }
    
    if ((!empty($disputo_logo_width) && ($disputo_logo_width != 200))) {
        $disputo_inline_style .= '@media only screen and (max-width: 991px) {.navbar-brand img { max-width: ' . $disputo_logo_width . 'px;}}';
    }

    if ((!empty($disputo_dropdown_min_width) && ($disputo_dropdown_min_width != 12))) {
        $disputo_inline_style .= '.dropdown-menu{ min-width:' . $disputo_dropdown_min_width . 'em;}';
    }
    
    if ((!empty($disputo_tooltip_color)) && ($disputo_tooltip_color != '#ffffff')) {
        $disputo_inline_style .= '.tooltip-inner {color:' . $disputo_tooltip_color . ';}';
    }
    
    if ((!empty($disputo_tooltip_bg_color)) && ($disputo_tooltip_bg_color != '#1d84b5')) {
        $disputo_inline_style .= '.tooltip-inner {background-color:' . $disputo_tooltip_bg_color . ';}.bs-tooltip-top .arrow::before,.bs-tooltip-auto[x-placement^="top"] .arrow::before {border-top-color: ' . $disputo_tooltip_bg_color . ';}.bs-tooltip-right .arrow::before,.bs-tooltip-auto[x-placement^="right"] .arrow::before {border-right-color: ' . $disputo_tooltip_bg_color . ';}.bs-tooltip-bottom .arrow::before,.bs-tooltip-auto[x-placement^="bottom"] .arrow::before {border-bottom-color: ' . $disputo_tooltip_bg_color . ';}.bs-tooltip-left .arrow::before,.bs-tooltip-auto[x-placement^="left"] .arrow::before {border-left-color: ' . $disputo_tooltip_bg_color . ';}';
    }
    
    if ((!empty($disputo_link_color)) && ($disputo_link_color != '#364253')) {
        $disputo_inline_style .= 'a,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a {color:' . $disputo_link_color . ';}';
    }
    
    if ((!empty($disputo_link_hover_color)) && ($disputo_link_hover_color != '#1d84b5')) {
        $disputo_inline_style .= 'a:hover,h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,h6 a:hover,.disputo-meta a:hover {color:' . $disputo_link_hover_color . ';}';
    }
    
    if ((!empty($disputo_primary_badge_color)) && ($disputo_primary_badge_color != '#ffffff')) {
        $disputo_inline_style .= '.badge-primary {color:' . $disputo_primary_badge_color . ';}';
    }
    
    if ((!empty($disputo_primary_badge_bg_color)) && ($disputo_primary_badge_bg_color != '#364253')) {
        $disputo_inline_style .= '.badge-primary {background-color:' . $disputo_primary_badge_bg_color . ';}';
    }
    
    if ((!empty($disputo_info_badge_color)) && ($disputo_info_badge_color != '#ffffff')) {
        $disputo_inline_style .= '.badge-info {color:' . $disputo_info_badge_color . ';}';
    }
    
    if ((!empty($disputo_info_badge_bg_color)) && ($disputo_info_badge_bg_color != '#1d84b5')) {
        $disputo_inline_style .= '.badge-info {background-color:' . $disputo_info_badge_bg_color . ';}';
    }
    
    if ((!empty($disputo_primary_btn_color)) && ($disputo_primary_btn_color != '#ffffff')) {
        $disputo_inline_style .= '.btn-primary,.disputo-carousel-view-more a,.disputo-carousel .slick-prev, .disputo-carousel .slick-next {color:' . $disputo_primary_btn_color . ';}';
    }
    
    if ((!empty($disputo_primary_btn_bg_color)) && ($disputo_primary_btn_bg_color != '#364253')) {
        $disputo_inline_style .= '.btn-primary,.disputo-carousel-view-more a,.disputo-carousel .slick-prev, .disputo-carousel .slick-next {background-color:' . $disputo_primary_btn_bg_color . ';border-color:' . $disputo_primary_btn_bg_color . ';}';
    }
    
    if ((!empty($disputo_primary_btn_bg_hover_color)) && ($disputo_primary_btn_bg_hover_color != '#2a3441')) {
        $disputo_inline_style .= '.btn-primary:hover,.disputo-carousel-view-more a:hover,.disputo-carousel .slick-prev:hover, .disputo-carousel .slick-next:hover,.disputo-carousel-view-more {background-color:' . $disputo_primary_btn_bg_hover_color . ';border-color:' . $disputo_primary_btn_bg_hover_color . ';}';
    }
     
    if ((!empty($disputo_info_btn_color)) && ($disputo_info_btn_color != '#ffffff')) {
        $disputo_inline_style .= '.btn-info,#cmb2-metabox-disputo_usercover button.button-secondary {color:' . $disputo_info_btn_color . ';}';
    }
    
    if ((!empty($disputo_info_btn_bg_color)) && ($disputo_info_btn_bg_color != '#1d84b5')) {
        $disputo_inline_style .= '.btn-info,#cmb2-metabox-disputo_usercover button.button-secondary {background-color:' . $disputo_info_btn_bg_color . ';border-color:' . $disputo_info_btn_bg_color . ';}';
    }
    
    if ((!empty($disputo_info_btn_bg_hover_color)) && ($disputo_info_btn_bg_hover_color != '#0076ad')) {
        $disputo_inline_style .= '.btn-info:hover,#cmb2-metabox-disputo_usercover button.button-secondary:hover {background-color:' . $disputo_info_btn_bg_hover_color . ';border-color:' . $disputo_info_btn_bg_hover_color . ';}';
    }

    if ((!empty($disputo_header_bg_color)) && ($disputo_header_bg_color != '#364253')) {
        $disputo_inline_style .= '#disputo-page-title-img {background-color:' . $disputo_header_bg_color . ';}@media only screen and (max-width: 991px) {#disputo-main-menu{background: ' . $disputo_header_bg_color . ';}}';
    }
    
    if ((!empty($disputo_header_btn_color)) && ($disputo_header_btn_color != '#ffffff')) {
        $disputo_inline_style .= '#header-wrapper .btn, #header-wrapper input[type="submit"]:not(.slick-arrow),#header-wrapper button[type="submit"]:not(.slick-arrow),#header-wrapper input[type="button"]:not(.slick-arrow),#header-wrapper button[type="button"]:not(.slick-arrow) {color:' . $disputo_header_btn_color . ';}';
    }
    
    if ((!empty($disputo_header_btn_bg_color)) && ($disputo_header_btn_bg_color != '#1d84b5')) {
        $disputo_inline_style .= '#header-wrapper .btn, #header-wrapper input[type="submit"]:not(.slick-arrow),#header-wrapper button[type="submit"]:not(.slick-arrow),#header-wrapper input[type="button"]:not(.slick-arrow),#header-wrapper button[type="button"]:not(.slick-arrow) {background-color:' . $disputo_header_btn_bg_color . ';border-color:' . $disputo_header_btn_bg_color . ';}@media only screen and (max-width: 991px) {#disputo-main-menu-wrapper .navbar-toggler {background:' . $disputo_header_btn_bg_color . ';}}';
    }
    
    if ((!empty($disputo_header_btn_bg_hover_color)) && ($disputo_header_btn_bg_hover_color != '#0076ad')) {
        $disputo_inline_style .= '#header-wrapper .btn:hover,#header-wrapper input[type="submit"]:hover,#header-wrapper button[type="submit"]:hover,#header-wrapper input[type="button"]:hover,#header-wrapper button[type="button"]:hover {background-color:' . $disputo_header_btn_bg_hover_color . ';border-color:' . $disputo_header_btn_bg_hover_color . ';}';
    }
    
    if ((!empty($disputo_menu_text_color)) && ($disputo_menu_text_color != '#ffffff')) {
        $disputo_inline_style .= '.navbar-dark .navbar-brand,.bg-transparent .navbar-brand,.bg-transparent .navbar-brand:hover,.bg-transparent .navbar-brand:focus.navbar-dark .navbar-brand:hover,.navbar-dark .navbar-brand:focus,.bg-transparent .navbar-nav .nav-link,.navbar-dark .navbar-nav .nav-link,.bg-transparent .navbar-nav .nav-link:hover,.bg-transparent .navbar-nav .nav-link:focus.navbar-dark .navbar-nav .nav-link:hover,.navbar-dark .navbar-nav .nav-link:focus,.bg-transparent .navbar-nav .show > .nav-link,.bg-transparent .navbar-nav .active > .nav-link,.bg-transparent .navbar-nav .nav-link.show,.bg-transparent .navbar-nav .nav-link.active,.navbar-dark .navbar-nav .show > .nav-link,.navbar-dark .navbar-nav .active > .nav-link,.navbar-dark .navbar-nav .nav-link.show,.navbar-dark .navbar-nav .nav-link.active,.bg-transparent .navbar-toggler,.navbar-dark .navbar-toggler,#disputo-header-search input[type="text"] {color:' . $disputo_menu_text_color . ';}';
    }
    
    if ((!empty($disputo_dropdown_bg_color)) && ($disputo_dropdown_bg_color != '#1d84b5')) {
        $disputo_inline_style .= '.dropdown-menu {background:' . $disputo_dropdown_bg_color . ';}@media only screen and (min-width: 992px) {#disputo-main-menu > ul > li:hover:before,#disputo-main-menu > ul > li.disputo-active-menu-item:before {background:' . $disputo_dropdown_bg_color . ';}}@media only screen and (max-width: 991px) {#disputo-main-menu{background:' . $disputo_dropdown_bg_color . ';}}';
    }
    
    if ((!empty($disputo_dropdown_text_color)) && ($disputo_dropdown_text_color != '#ffffff')) {
        $disputo_inline_style .= '.dropdown-menu,.dropdown-item,.dropdown-item:hover,.dropdown-item:focus,.disputo-login-form-links a,.disputo-login-form-links a:hover {color:' . $disputo_dropdown_text_color . ';}';
    }
    
    if ((!empty($disputo_overlay_bg_color)) && (($disputo_overlay_bg_color != 'rgba(29,132,181,0.7)') || (($disputo_overlay_2_bg_color != '#364253')))) {
        if (empty($disputo_overlay_2_bg_color)) {
            $disputo_overlay_2_bg_color = $disputo_overlay_bg_color;
        }
        $disputo_inline_style .= '#disputo-page-title-overlay {background:' . $disputo_overlay_bg_color . ';background: -webkit-linear-gradient(to right, ' . $disputo_overlay_bg_color . ', ' . $disputo_overlay_2_bg_color . ');background: linear-gradient(to right, ' . $disputo_overlay_bg_color . ', ' . $disputo_overlay_2_bg_color . ');}';
    }
    
    if ((!empty($disputo_header_heading_color)) && ($disputo_header_heading_color != '#ffffff')) {
        $disputo_inline_style .= '#disputo-header-search input[type="text"]::placeholder,#disputo-header-search input[type="text"],#disputo-header-search input[type="text"]:focus {color:' . $disputo_header_heading_color . ';}';
    }
    
    if ((!empty($disputo_footer_text_color)) && ($disputo_footer_text_color != '#bdc3c7')) {
        $disputo_inline_style .= '#disputo-footer,#disputo-footer .form-control::placeholder,#disputo-footer .form-control {color:' . $disputo_footer_text_color . ';}';
    }
    
    if ((!empty($disputo_footer_link_color)) && ($disputo_footer_link_color != '#bdc3c7')) {
        $disputo_inline_style .= '#disputo-footer a {color:' . $disputo_footer_link_color . ';}';
    }
    
    if ((!empty($disputo_footer_link_hover_color)) && ($disputo_footer_link_hover_color != '#ffffff')) {
        $disputo_inline_style .= '#disputo-footer a:hover {color:' . $disputo_footer_link_hover_color . ';}';
    }
    
    if ((!empty($disputo_footer_heading_color)) && ($disputo_footer_heading_color != '#ffffff')) {
        $disputo_inline_style .= '#disputo-footer h1,#disputo-footer h2,#disputo-footer h3,#disputo-footer h4,#disputo-footer h5,#disputo-footer h6,#disputo-footer a:hover {color:' . $disputo_footer_heading_color . ';}';
    }
    
    if ((!empty($disputo_footer_bg_color)) && ($disputo_footer_bg_color != '#364253')) {
        $disputo_inline_style .= '#disputo-footer {background:' . $disputo_footer_bg_color . ';}';
    }
    
    if ((!empty($disputo_footer_btn_color)) && ($disputo_footer_btn_color != '#ffffff')) {
        $disputo_inline_style .= '#disputo-footer .btn, #disputo-footer input[type="submit"]:not(.slick-arrow),#disputo-footer button[type="submit"]:not(.slick-arrow),#disputo-footer input[type="button"]:not(.slick-arrow),#disputo-footer button[type="button"]:not(.slick-arrow),.disputo-social-icons li #disputo-go-to-top,.disputo-social-icons li #disputo-go-to-top:hover {color:' . $disputo_footer_btn_color . ';}';
    }
    
    if ((!empty($disputo_footer_btn_bg_color)) && ($disputo_footer_btn_bg_color != '#1d84b5')) {
        $disputo_inline_style .= '#disputo-footer .btn,#disputo-footer input[type="submit"]:not(.slick-arrow),#disputo-footer button[type="submit"]:not(.slick-arrow),#disputo-footer input[type="button"]:not(.slick-arrow),#disputo-footer button[type="button"]:not(.slick-arrow),.disputo-social-icons li #disputo-go-to-top {background-color:' . $disputo_footer_btn_bg_color . ';border-color:' . $disputo_footer_btn_bg_color . ';}';
    }
    
    if ((!empty($disputo_footer_btn_bg_color)) && ($disputo_footer_btn_bg_color != '#1d84b5')) {
        $disputo_inline_style .= '#disputo-footer .widget_mc4wp_form_widget:before,#disputo-footer .so-panel.widget_mc4wp_form_widget:before {color:' . $disputo_footer_btn_bg_color . ';}';
    }
    
    if ((!empty($disputo_footer_btn_bg_hover_color)) && ($disputo_footer_btn_bg_hover_color != '#0076ad')) {
        $disputo_inline_style .= '#disputo-footer .btn:hover,#disputo-footer input[type="submit"]:hover,#disputo-footer button[type="submit"]:hover,#disputo-footer input[type="button"]:hover,#disputo-footer button[type="button"]:hover,.disputo-social-icons li #disputo-go-to-top:hover {background-color:' . $disputo_footer_btn_bg_hover_color . ';border-color:' . $disputo_footer_btn_bg_hover_color . ';}';
    }
    
    wp_add_inline_style( 'disputo-style', $disputo_inline_style );
}
}
add_action('wp_enqueue_scripts', 'disputo_theme_styles');

/*---------------------------------------------------
javascript files
----------------------------------------------------*/

if ( ! function_exists( 'disputo_script_register' ) ) {
function disputo_script_register() {
    $disputo_quote_check = get_theme_mod('disputo_bbpress_quote');
    
    // Html5 support for old browsers
    wp_enqueue_script('html5shiv', get_template_directory_uri() . '/js/html5.js', '', '3.7.0', false );
    wp_script_add_data('html5shiv', 'conditional', 'lt IE 9' );
    
    // Bootstrap
    wp_enqueue_script('disputo-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '4.0.0', true );
    
    // Responsive Grid
    wp_enqueue_script('salvattore', get_template_directory_uri() . '/js/salvattore.min.js', array( 'jquery' ), '1.1', true );
    
    // Slick Carousel
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick/slick.min.js', array( 'jquery' ), '1.8.0', true );
    
    // Comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( "comment-reply" );
    }
    
    // bbPress Quote Replies and Topics
    if ($disputo_quote_check) {
        wp_enqueue_script('disputo-quote', get_template_directory_uri() . '/js/quote.js', array( 'jquery' ), '1.0.0', true );
    }
    
    // Ajax Search
    $disputo_live_search = get_theme_mod('disputo_live_search');
    
    if ($disputo_live_search) {
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script( 'disputo-autocomplete', get_template_directory_uri() . '/js/autocomplete.js', array( 'jquery', 'jquery-ui-autocomplete' ), '1.0', false );
        wp_localize_script( 'disputo-autocomplete', 'DisputoAutocomplete', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
    }
    
    // Custom scripts
    wp_enqueue_script('disputo-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '3.0', true );
    
    $disputo_bbpress_visual = get_theme_mod('disputo_bbpress_visual');
    $disputo_wp_editor = 0;
    if ($disputo_bbpress_visual) {
        $disputo_wp_editor = 1;
    }
    $disputo_dropdown_align = 'dropdown-menu-left';
    $disputo_dropdown_align_2 = 'dropdown-menu-right';
    if (is_rtl()) {
        $disputo_dropdown_align = 'dropdown-menu-right';
        $disputo_dropdown_align_2 = 'dropdown-menu-left';
    }
    
    $disputo_dropdown_param = array(
        "disputo_wp_editor" => $disputo_wp_editor,
        "disputo_dropdown_align" => $disputo_dropdown_align,
        "disputo_dropdown_align_2" => $disputo_dropdown_align_2
    );
    wp_localize_script('disputo-custom', 'disputo_dropdown_vars', $disputo_dropdown_param);
}
}
add_action( 'wp_enqueue_scripts', 'disputo_script_register' );

/*---------------------------------------------------
Dashboard scripts
----------------------------------------------------*/

if ( ! function_exists( 'disputo_theme_admin_scripts' ) ) {
function disputo_theme_admin_scripts(){
    wp_enqueue_style('disputo-theme-admin-style', get_template_directory_uri() . '/includes/css/admin-general.css', false, '1.0');
}
}
add_action( 'admin_enqueue_scripts', 'disputo_theme_admin_scripts', 99 );

/*---------------------------------------------------
Register Sidebars
----------------------------------------------------*/

if ( ! function_exists( 'disputo_sidebars_widgets_init' ) ) {
function disputo_sidebars_widgets_init() {
    register_sidebar( array(
        'name' => esc_html__( 'Main Sidebar', 'disputo'),
        'id' => 'disputo_sidebar',
        'description' => esc_html__( 'Main Sidebar is displayed on blog pages.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-sidebar-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
    register_sidebar( array(
        'name' => esc_html__( 'Page Sidebar', 'disputo'),
        'id' => 'disputo_page_sidebar',
        'description' => esc_html__( 'Page Sidebar is displayed only on page-sidebar template.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-sidebar-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
    register_sidebar( array(
        'name' => esc_html__( 'bbPress Forum Sidebar', 'disputo'),
        'id' => 'disputo_bbpress_forum_sidebar',
        'description' => esc_html__( 'bbPress Sidebar is displayed on forums.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-sidebar-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
    register_sidebar( array(
        'name' => esc_html__( 'bbPress Topic Sidebar', 'disputo'),
        'id' => 'disputo_bbpress_topic_sidebar',
        'description' => esc_html__( 'bbPress Sidebar is displayed on topics.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-sidebar-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
    register_sidebar( array(
        'name' => esc_html__( 'bbPress Search Sidebar', 'disputo'),
        'id' => 'disputo_bbpress_search_sidebar',
        'description' => esc_html__( 'bbPress Sidebar is displayed on search page.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-sidebar-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
    register_sidebar( array(
        'name' => esc_html__( 'FAQ Sidebar', 'disputo'),
        'id' => 'disputo_faq_sidebar',
        'description' => esc_html__( 'FAQ Sidebar is displayed only on FAQ page.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-sidebar-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
    register_sidebar( array(
        'name' => esc_html__( 'Woocommerce Sidebar', 'disputo'),
        'id' => 'disputo_woo_sidebar',
        'description' => esc_html__( 'Woocommerce Sidebar Widget Field.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-sidebar-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
    register_sidebar( array(
        'name' => esc_html__( 'Footer', 'disputo'),
        'id' => 'disputofooterwidgets',
        'description' => esc_html__( 'You can use SiteOrigin Layout Builder Widget to create columns for your widgets.', 'disputo' ),
        'before_widget' => '<div id="%1$s" class="%2$s disputo-footer-box">',
        'after_widget' => "</div>",
        'before_title' => '<h5 class="disputo-widget-title"><span>',
        'after_title' => '</span></h5>',
    ));
}
}
add_action( 'widgets_init', 'disputo_sidebars_widgets_init' );

/*---------------------------------------------------
Custom excerpt dots
----------------------------------------------------*/

if ( ! function_exists( 'disputo_excerpt_read_more' ) ) {
function disputo_excerpt_read_more( $more ) {
	return '...';
}
}
add_filter('excerpt_more', 'disputo_excerpt_read_more');

/*---------------------------------------------------
Custom tag cloud
----------------------------------------------------*/
if ( ! function_exists( 'disputo_wp_generate_tag_cloud' ) ) {
function disputo_wp_generate_tag_cloud($content, $tags, $args)
{ 
    if ( ! is_admin() ) {
        $count=0;
        $output=preg_replace_callback('(</a\s*>)', function($match) use ($tags, &$count) {
            return "<span class=\"disputo-tag-count\">".$tags[$count++]->count."</span></a>";  
        }, $content);
    } else {
        $output = $content;
    }
  return $output;    
}
}
add_filter('wp_generate_tag_cloud','disputo_wp_generate_tag_cloud', 10, 3);

if ( ! function_exists( 'disputo_tag_cloud_args' ) ) {
    function disputo_tag_cloud_args($args) {
        $disputo_args = array('smallest' => 14, 'largest' => 14, 'orderby' => 'count','unit' => 'px','order' => 'DESC');
        $args = wp_parse_args( $args, $disputo_args );
        return $args;
    }
}
add_filter('widget_tag_cloud_args','disputo_tag_cloud_args');

/*---------------------------------------------------
Custom comments
----------------------------------------------------*/
if ( ! function_exists( 'disputo_comment' ) ) {
function disputo_comment($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">      
    <div id="comment-<?php comment_ID(); ?>" class="disputo_comments"> 
        <?php if ($comment->comment_approved == '0') : ?>
        <em><?php echo esc_attr('Your comment is awaiting moderation.', 'disputo'); ?></em>
        <br />
        <?php endif; ?> 
        <div class="disputo_comment">
            <div class="disputo_comment_inner">
                <?php $disputo_bbpress_user_avatar = get_theme_mod('disputo_bbpress_user_avatar'); ?>
                <?php $disputo_avatar = get_avatar( $comment, 60 ); ?>
                <?php $disputo_custom_avatar = get_user_meta($comment->user_id, 'disputo_cmb2_user_avatar' ); ?>
                <?php $custom_avatar_img = wp_get_attachment_image_src( get_user_meta( $comment->user_id, 'disputo_cmb2_user_avatar_id', 1 ), 'thumbnail' ); ?>
                <?php if ((!empty($disputo_custom_avatar)) && ($disputo_bbpress_user_avatar)) { ?>
                <div class="disputo_comment_left">
                    <img src="<?php echo $custom_avatar_img[0]; ?>" alt="<?php echo esc_attr(get_comment_author($comment->comment_ID)); ?>" />
                </div>
                <?php } elseif (!empty($disputo_avatar)) { ?>
                <div class="disputo_comment_left">
                    <?php echo get_avatar( $comment, 60 ); ?> 
                </div>
                <?php } ?>
                <div class="disputo_comment_right">
                    <div class="disputo_comment_right_inner <?php if (empty($disputo_avatar)) { ?>disputo_no_avatar<?php } ?>">
                    <cite class="disputo_fn"><?php printf(esc_attr('%s'), get_comment_author_link()) ?></cite>
                    <div class="disputo_comment_text">
                        <?php comment_text(); ?>
                    </div>
                    <div class="disputo_comment_links">
                        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><i class="fa fa-clock-o"></i> <?php printf(esc_html__('%1$s at %2$s', 'disputo'), get_comment_date(),  get_comment_time()) ?></a> - <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?><?php edit_comment_link(esc_html__('(Edit)', 'disputo'),'  ','') ?>
                    </div>
                    <?php if ( function_exists( 'disputo_render_for_comments' ) ) { disputo_render_for_comments(); } ?>    
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}          
}

/* ---------------------------------------------------------
Additional user menu items
----------------------------------------------------------- */

function disputo_get_user_menu_items($priority) {
    $disputo_user_menu_items = get_theme_mod( 'disputo_user_menu_items' );
    if (!empty($disputo_user_menu_items)) {
        foreach ($disputo_user_menu_items as $entry) {
            $title = $destination = $get_priority = '';
            if ( isset( $entry['title'] ) ) {            
                $title = $entry['title'];
            }
            if ( isset( $entry['destination_url'] ) ) {            
                $destination = $entry['destination_url'];
            }
            if ( isset( $entry['priority'] ) ) {            
                $get_priority = $entry['priority'];
            } 
            if ($priority == $get_priority) {
    ?>
    <a class="dropdown-item" href="<?php echo esc_url($destination); ?>"><?php echo esc_html($title); ?></a>
    <?php
            }
        }
    }
}

/* ---------------------------------------------------------
Add a class to Mailchimp form
----------------------------------------------------------- */
add_filter( 'mc4wp_form_css_classes', function( $classes ) { 
	$classes[] = 'disputo-mailchimp';
	return $classes;
});

/* ---------------------------------------------------------
TGM Activation Class
----------------------------------------------------------- */

require_once(get_template_directory() . '/includes/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'disputo_register_required_plugins' );

function disputo_register_required_plugins() {
	$disputo_plugins = array(
		array(
			'name'     				=> esc_html__( 'Disputo Features', 'disputo'),
			'slug'     				=> 'disputo-features',
			'source'   				=> get_template_directory_uri() . '/plugins/disputo-features.zip',
			'required' 				=> true,
            'version' 				=> '4.3',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
		),
        array(
			'name'     				=> esc_html__( 'Disputo Messages', 'disputo'),
			'slug'     				=> 'disputo-messages',
			'source'   				=> get_template_directory_uri() . '/plugins/disputo-messages.zip',
			'required' 				=> false,
            'version' 				=> '2.1',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
		),
        array(
			'name'     				=> esc_html__( 'Disputo Rating System', 'disputo'),
			'slug'     				=> 'disputo-rating-system',
			'source'   				=> get_template_directory_uri() . '/plugins/disputo-rating-system.zip',
			'required' 				=> false,
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
		),
        array(
			'name'     				=> esc_html__( 'Kirki', 'disputo'),
			'slug'     				=> 'kirki',
			'required' 				=> true,
		),
        array(
			'name'     				=> esc_html__( 'bbPress', 'disputo'),
			'slug'     				=> 'bbpress',
			'required' 				=> true,
		),
        array(
			'name'     				=> esc_html__( 'Siteorigin Panels', 'disputo'),
			'slug'     				=> 'siteorigin-panels',
			'required' 				=> true,
		),
        array(
			'name'     				=> esc_html__( 'SiteOrigin Widgets Bundle', 'disputo'),
			'slug'     				=> 'so-widgets-bundle',
			'required' 				=> true,
		),
        array(
			'name'     				=> esc_html__( 'One Click Demo Import', 'disputo'),
			'slug'     				=> 'one-click-demo-import',
			'required' 				=> false,
		),
        array(
			'name'     				=> esc_html__( 'Custom Login Page Customizer', 'disputo'),
			'slug'     				=> 'colorlib-login-customizer',
			'required' 				=> false,
		),
        array(
			'name'     				=> esc_html__( 'WooCommerce', 'disputo'),
			'slug'     				=> 'woocommerce',
			'required' 				=> false,
		),
        array(
			'name'     				=> esc_html__( 'DV Shortcode Whitelist', 'disputo'),
			'slug'     				=> 'dv-shortcode-whitelist',
			'required' 				=> false,
		),
        array(
			'name'     				=> esc_html__( 'Contact Form 7', 'disputo'),
			'slug'     				=> 'contact-form-7',
			'required' 				=> false,
		)
	);

	$disputo_config = array(
        'id'           => 'disputo',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $disputo_plugins, $disputo_config );

}
?>