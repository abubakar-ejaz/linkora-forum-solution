<?php
/**
* Plugin Name: Disputo Rating System
* Plugin URI: http://www.egemenerd.com/
* Description: Like & dislike rating system.
* Version: 1.0
* Author: Egemenerd
* Author URI: http://www.egemenerd.com/
* License: https://themeforest.net/licenses?ref=egemenerd
*/

if ( ! defined( 'ABSPATH' ) ) exit;

function disputo_system_main_function(){  
    /* IF CMB2 PLUGIN IS LOADED */
    if ( defined( 'CMB2_LOADED' ) ) {
        include_once('rating_system_admin.php');
    }  
    include_once('posts-pages.php');
    include_once('metabox.php');
    include_once('comments.php');		
}

add_action('plugins_loaded','disputo_system_main_function');
?>