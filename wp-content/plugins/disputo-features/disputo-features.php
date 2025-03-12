<?php
/**
* Plugin Name: Disputo Features
* Plugin URI: https://1.envato.market/1k3gD
* Description: Custom post types, widgets and shortcodes
* Version: 4.3
* Author: Egemenerd
* Author URI: https://1.envato.market/1k3gD
* License: http://themeforest.net/licenses?ref=egemenerd
*/

if ( !class_exists('bbPressProfileTabs') ) {
    require_once('bbPressProfileTabs.php');
}

/* Include required files */

$disputo_follow_user = get_theme_mod('disputo_bbpress_follow_user');
$disputo_enable_user_blog = get_theme_mod('disputo_enable_user_blog');
$disputo_lead_topic = get_theme_mod('disputo_lead_topic', 1);
$disputo_solved_topic = get_theme_mod('disputo_solved_topic');
$disputo_private_reply = get_theme_mod('disputo_bbpress_private_reply', 1);

/* Custom post type */
include_once('faq.php');

/* Statistics */
include_once('statistics.php');	

/* Shortcodes */
include_once('shortcodes.php');

/* Widgets */
include_once('so-widgets.php');	

/* bbPress */
if (class_exists( 'bbPress' )) {
    if ($disputo_private_reply) {
        include_once('class-bbp-private-replies.php');
    }
    if ($disputo_lead_topic && $disputo_solved_topic) {
        include_once('class-bbp-solved-topic.php');
    }
    include_once('verified-users.php');	
    if ($disputo_follow_user) {
        include_once('mywall.php');	
    }
    if ($disputo_enable_user_blog) {
        include_once('myblog.php');	
    }
}

/* Create An Empty Tab */
function disputo_placeholder_tab() {
    return \bbPressProfileTabs::create(
        [
            'slug' => 'placeholder',
            'menu-item-text' => 'Placeholder',
            'menu-item-position' => 99,
            'visibility' => 'profile-owner'
        ]
    )->init();
}
add_action('plugins_loaded', 'disputo_placeholder_tab', 99);

function disputo_features_main_function(){  
    /* IF CMB2 PLUGIN IS LOADED */
    if ( defined( 'CMB2_LOADED' ) ) {
        include_once('adsadmin.php');
        include_once('disputo-post-form.php');
    }
}

add_action('plugins_loaded','disputo_features_main_function');

//Create table when you activate the plugin
register_activation_hook( __FILE__, 'bbpf_activate');
function bbpf_activate() {
    global $wpdb;
    $wpdb->query("CREATE TABLE IF NOT EXISTS `bbpress_follow` (
    `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) UNSIGNED NOT NULL,
    `follower_id` bigint(20) UNSIGNED NOT NULL,
    `start_follow` DATETIME NOT NULL,
    PRIMARY KEY (`ID`)
    )");
    bbPressProfileTabs::flushRewriteRules();
}

/* Register Scripts and Styles */

function disputo_cpt_scripts() {
    $disputo_fb_check = get_theme_mod('disputo_activate_fb_comments');
    $disputo_bbpress_flags = get_theme_mod('disputo_bbpress_flags');
    wp_register_style('disputoytv', plugin_dir_url( __FILE__ ) . 'css/ytv.css', true, '1.0'); 
    wp_register_script('disputoytv', plugin_dir_url( __FILE__ ) . 'js/ytv.js', array( 'jquery' ), '1.0', true );
    // Facebook Comments
    if (is_singular('post') && ($disputo_fb_check)) {
        wp_enqueue_script('disputo-fb-comments', plugin_dir_url( __FILE__ ) . 'js/facebook-comments.js', '', '1.0.0', false );
        $disputo_fb_id = esc_js(get_theme_mod('disputo_fb_id'));
        $disputo_fb_language = get_locale();       
        $disputo_fb_param = array(
            "disputo_fb_id" => !empty($disputo_fb_id) ? $disputo_fb_id : '',
            "disputo_fb_language" => !empty($disputo_fb_language) ? $disputo_fb_language : 'en_US'
        );
        wp_localize_script('disputo-fb-comments', 'disputo_fb_vars', $disputo_fb_param);
    }
    wp_enqueue_style('disputo-cpt-styles', plugin_dir_url( __FILE__ ) . 'css/style.css', true, '1.0'); 
    if ( is_rtl() ) {
        wp_enqueue_style('disputo-cpt-rtl-styles', plugin_dir_url( __FILE__ ) . 'css/rtl.css', true, '1.0'); 
    }   
    if (is_singular()) {
        wp_enqueue_style('disputo-share', plugin_dir_url( __FILE__ ) . 'css/rrssb.css', false, '1.0.0');
        wp_enqueue_script('disputo-share', plugin_dir_url( __FILE__ ) . 'js/rrssb.min.js', array( 'jquery' ), '1.0.0', false );                       
    }
    if ($disputo_bbpress_flags) {
        wp_enqueue_style('disputo-flags', plugin_dir_url( __FILE__ ) . 'css/flags.css', false, '1.0.0');
    }
    if ( is_page_template('faq.php') || is_page_template('faq-fullwidth.php') ) {
        wp_enqueue_script('disputo-faq', plugin_dir_url( __FILE__ ) . 'js/faq.js', array( 'jquery' ), '1.0', true );   
    }
}
add_action('wp_enqueue_scripts','disputo_cpt_scripts');

/* Register Admin Scripts */

function disputo_features_admin_scripts() {
    $disputo_js_script_ajax_nonce = wp_create_nonce( "disputo_js_script_ajax_nonce" );
    wp_enqueue_script('disputo_features_admin_script', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'disputo_features_admin_script', 'disputo_vars', array( 'disputo_ajax_url'   => admin_url( 'admin-ajax.php' ),'disputo_plugin_dir'   => plugins_url('',__FILE__) ,'disputo_js_script_ajax_nonce'=>$disputo_js_script_ajax_nonce)); 
}

add_action('admin_enqueue_scripts', 'disputo_features_admin_scripts');

/*---------------------------------------------------
Custom Image Sizes
----------------------------------------------------*/

add_image_size( 'disputo-thumbnail', 640, 480, true);
add_image_size( 'disputo-hero', 1300, 650, true);
add_filter('image_size_names_choose', 'disputo_image_sizes');

function disputo_image_sizes($disputosizes) {
    $disputoaddsizes = array(
        "disputo-thumbnail" => esc_attr__( 'Disputo Thumbnail', 'disputo'),
        "disputo-hero" => esc_attr__( 'Disputo Hero Image', 'disputo')
    );
    $disputonewsizes = array_merge($disputosizes, $disputoaddsizes);
    return $disputonewsizes;
}

/*---------------------------------------------------
Faq Count
----------------------------------------------------*/

function disputo_count_faq_in_cat($catid) {
    $disputo_faq_args = array(
    'post_type' => 'disputofaq',
    'tax_query' => array(
		array(
			'taxonomy' => 'disputofaqcats',
			'field'    => 'term_id',
            'terms'    => $catid
        ),
    ),
    ); 
    $disputo_faq_query = new WP_Query( $disputo_faq_args );
    echo esc_html($disputo_faq_query->post_count);
    wp_reset_postdata();
}

/*---------------------------------------------------
Tinymce custom button
----------------------------------------------------*/

if ( is_admin() ) {
add_action('init', 'disputo_shortcodes_add_button');  
function disputo_shortcodes_add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
     add_filter('mce_external_plugins', 'disputo_add_plugin', 10);  
     add_filter('mce_buttons', 'disputo_register_button', 10);  
   }  
} 

function disputo_register_button($buttons) {
    array_push($buttons, "disputo_mce_button");
    return $buttons;  
}  

function disputo_add_plugin($plugin_array) {
    $plugin_array['disputo_mce_button'] = plugin_dir_url( __FILE__ ) . 'js/shortcodes.js';
    return $plugin_array;  
}
    
function disputo_mce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'disputo_mce_buttons_2');  
    
function disputo_before_init_insert_formats( $init_array ) {  
    $style_formats = array(  
        array(  
            'title' => 'Lead Text',  
            'block' => 'span',  
            'classes' => 'lead',
            'wrapper' => true  
        ),
        array(  
            'title' => 'Primary Text',  
            'block' => 'span',  
            'classes' => 'text-primary',
            'wrapper' => true  
        ),
        array(  
            'title' => 'Success Text',  
            'block' => 'span',  
            'classes' => 'text-success',
            'wrapper' => true  
        ),
        array(  
            'title' => 'Info Text',  
            'block' => 'span',  
            'classes' => 'text-info',
            'wrapper' => true  
        ),
        array(  
            'title' => 'Warning Text',  
            'block' => 'span',  
            'classes' => 'text-warning',
            'wrapper' => true  
        ),
        array(  
            'title' => 'Danger Text',  
            'block' => 'span',  
            'classes' => 'text-danger',
            'wrapper' => true  
        ),
        array(  
            'title' => 'Light Text',  
            'block' => 'span',  
            'classes' => 'text-light',
            'wrapper' => true  
        )
    );
    $init_array['style_formats'] = json_encode( $style_formats );      
    return $init_array;  
   
}
add_filter( 'tiny_mce_before_init', 'disputo_before_init_insert_formats' );     
}

/* ---------------------------------------------------------
Custom Pagination
----------------------------------------------------------- */

function disputo_update_query( $query ) { 
    if (function_exists('is_woocommerce') && is_woocommerce()) {
        return;
    }
    if (($query->is_search() || $query->is_archive()) && $query->is_main_query() && !is_admin()) {
        $disputo_post_per_page = get_theme_mod( 'disputo_archive_at_most', 6 );
        $query->set( 'posts_per_page', $disputo_post_per_page );
        
    }
    if ($query->is_author() && $query->is_main_query() && !is_admin()) {
        $disputo_post_per_page = get_theme_mod( 'disputo_author_at_most', 6 );
        $query->set( 'posts_per_page', $disputo_post_per_page );
    }
    
}
add_action( 'pre_get_posts', 'disputo_update_query', 99 );

/* ---------------------------------------------------------
Custom Metaboxes - https://github.com/WebDevStudios/CMB2
----------------------------------------------------------- */

// Check for PHP version and use the correct one
$disputodir = ( version_compare( PHP_VERSION, '5.3.0' ) >= 0 ) ? __DIR__ : dirname( __FILE__ );

if ( file_exists(  $disputodir . '/cmb2/init.php' ) ) {
	require_once  $disputodir . '/cmb2/init.php';
} elseif ( file_exists(  $disputodir . '/CMB2/init.php' ) ) {
	require_once  $disputodir . '/CMB2/init.php';
}

/* ---------------------------------------------------------
Ads Manager
----------------------------------------------------------- */

function disputo_features_cmb2_function(){  
    include_once('adsmanager.php');
}

add_action('cmb2_init','disputo_features_cmb2_function');

function disputo_add_new_post_form() {
    echo do_shortcode('[disputo_frontend_form]');
}

/* ---------------------------------------------------------
FAQ functions
----------------------------------------------------------- */

function disputo_faq_content() {
    include('faq-content.php');
}

function disputo_faq_menu() {
    include('faq-menu.php');
}

function disputo_faq_search() {
    include('faq-search.php');
}

/* ---------------------------------------------------------
Social Media Sharing Buttons
----------------------------------------------------------- */

function disputo_social_media_buttons() {
    include('social-media.php');
}

/* ---------------------------------------------------------
Facebook Comments
----------------------------------------------------------- */

function disputo_fbcomments() {
    include('fbcomments.php');
}

/* ---------------------------------------------------------
Report Content
----------------------------------------------------------- */

$disputo_enable_report = get_theme_mod('disputo_bbpress_report');

if ($disputo_enable_report) {
    require_once( plugin_dir_path( __FILE__ ) . 'class-bbpress-report-content.php' );
    add_action( 'plugins_loaded', array( 'bbp_ReportContent', 'get_instance' ) );
    register_activation_hook( __FILE__, array( 'bbp_ReportContent', 'activation_check' ) );
}

function disputo_do_shortcode($content) {
  $pattern = get_shortcode_regex(array('bquote'));
  $content = preg_replace_callback("/$pattern/", 'do_shortcode_tag', $content);
  return $content;
}

/*---------------------------------------------------
Ajax Search
----------------------------------------------------*/

$disputo_live_search = get_theme_mod('disputo_live_search');

function disputo_post_title_filter($where, &$wp_query) {
    global $wpdb;
    if ( $search_term = $wp_query->get( 'disputo_search_post_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $search_term ) . '%\'';
    }
    return $where;
}

function disputo_ajax_post_search() {
    $disputo_live_search_at_most = get_theme_mod('disputo_live_search_at_most', 5);
    $term = strtolower( $_GET['term'] );
    $suggestions = array();
    
    add_filter( 'posts_where', 'disputo_post_title_filter', 10, 2 );
    $loop = new WP_Query( 
        array(
            'post_type' => 'post', 
            'post_status' => 'publish',
            'posts_per_page' => $disputo_live_search_at_most, 
            'disputo_search_post_title' => $term
        )
    );
    remove_filter( 'posts_where', 'disputo_post_title_filter', 10 );
		
    if ($loop->have_posts()) {
    while( $loop->have_posts() ) {
        $loop->the_post();
        $suggestion = array();
        $suggestion['label'] = html_entity_decode(get_the_title());
        $suggestion['value'] = get_permalink();
        $suggestions[] = $suggestion;
    }
    } else {
        $suggestion = array();
        $suggestion['label'] = '';
        $suggestion['value'] = '';
        $suggestions[] = $suggestion;
    }
		
    wp_reset_postdata();
    	
    $response = wp_json_encode( $suggestions );
    print $response;
    exit();
}

if ($disputo_live_search) {
    add_action( 'wp_ajax_disputo_ajax_post_search', 'disputo_ajax_post_search' );
    add_action( 'wp_ajax_nopriv_disputo_ajax_post_search', 'disputo_ajax_post_search' );
}

/* ---------------------------------------------------------
bbPress Ajax Search
----------------------------------------------------------- */

function disputo_bbpress_title_filter($where, &$wp_query) {
    global $wpdb;
    if ( $search_term = $wp_query->get( 'disputo_search_bbpress_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $search_term ) . '%\'';
    }
    return $where;
}

function disputo_ajax_search() {
    $disputo_live_search_at_most = get_theme_mod('disputo_live_search_at_most', 5);
    $term = strtolower( $_GET['term'] );
    $suggestions = array();
    
    add_filter( 'posts_where', 'disputo_bbpress_title_filter', 10, 2 );
    $loop = new WP_Query( 
        array(
            'post_type' => array('forum','topic'), 
            'post_status' => 'publish',
            'posts_per_page' => $disputo_live_search_at_most, 
            'disputo_search_bbpress_title' => $term
        )
    );
    remove_filter( 'posts_where', 'disputo_bbpress_title_filter', 10 );
		
    if ($loop->have_posts()) {
        while( $loop->have_posts() ) {
            $loop->the_post();
            $suggestion = array();
            $suggestion['label'] = html_entity_decode(get_the_title());
            $suggestion['value'] = get_permalink();
            $suggestions[] = $suggestion;
        }
        } else {
            $suggestion = array();
            $suggestion['label'] = '';
            $suggestion['value'] = '';
            $suggestions[] = $suggestion;
        }
		
		wp_reset_postdata();

    	$response = wp_json_encode( $suggestions );
    	print $response;
    	exit();
}
if ($disputo_live_search) {
    add_action( 'wp_ajax_disputo_ajax_search', 'disputo_ajax_search' );
    add_action( 'wp_ajax_nopriv_disputo_ajax_search', 'disputo_ajax_search' );
}

/* ---------------------------------------------------------
FLAGS
----------------------------------------------------------- */

function disputo_flags_array() {
    $countries = array(
        'none' => esc_html__( 'Select a flag', 'disputo'),
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua And Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia And Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, Democratic Republic',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (Malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island & Mcdonald Islands',
        'VA' => 'Holy See (Vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic Of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle Of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KR' => 'Korea',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States Of',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts And Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre And Miquelon',
        'VC' => 'Saint Vincent And Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome And Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia And Sandwich Isl.',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard And Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad And Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks And Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.S.',
        'WF' => 'Wallis And Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    );
    return $countries;
}


/* ---------------------------------------------------------
DEMO IMPORT
----------------------------------------------------------- */

function disputo_import_files() {
    return array(
        array(
            'import_file_name'           => 'Demo Import',
            'import_file_url'            => 'http://disputo.egemenerd.com/demo/demo1.xml',
            'import_widget_file_url'     => 'http://disputo.egemenerd.com/demo/widgets.wie',
            'import_customizer_file_url' => 'http://disputo.egemenerd.com/demo/customizer.dat'
        )
    );
}
add_filter( 'pt-ocdi/import_files', 'disputo_import_files' );


function disputo_after_import_setup() {
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'disputo-main-menu' => $main_menu->term_id,
        )
    );
    $front_page_id = get_page_by_title( 'Welcome to Disputo Forum' );
    $blog_page_id  = get_page_by_title( 'Blog' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'disputo_after_import_setup' );
?>