<?php
/**
* Plugin Name: Disputo Messages
* Plugin URI: https://themeforest.net/user/egemenerd/portfolio?ref=egemenerd
* Description: Private messaging system for bbPress.
* Version: 2.1
* Author: Egemenerd
* Author URI: http://themeforest.net/user/egemenerd?ref=egemenerd
* License: http://themeforest.net/licenses?ref=egemenerd
*/

/* Define File */

if ( !defined('BBP_MESSAGES_FILE') ) {
    define('BBP_MESSAGES_FILE', __FILE__);
}

/**
  * Require version and dependencies check class
  *
  * Making sure client has PHP 5.3 at least, required
  * for PHP namespaces and closures.
  *
  * Making sure client has bbPress parent plugin
  * installed and activated
  */
$bbPMCheckReady = require('CheckReady.php');

if ($bbPMCheckReady instanceof bbPMCheckReady) {
    if ( method_exists($bbPMCheckReady, 'check') ) {
        // activation check
        register_activation_hook(BBP_MESSAGES_FILE, array($bbPMCheckReady, 'check'));
    }

    // load plugin
    require('BbpMessages.php');

    // init
    global $bbpm_loader;
    // loader class
    $bbpm_loader = new \BBP_MESSAGES\BbpMessages;
    // setup
    $bbpm_loader->setup();
}

function bbp_messages_loaded(){
    global $bbpm_loader;

    if( ! class_exists('bbPress') ) {
        return add_action('admin_init', array($bbpm_loader, 'deactivate'));
    }

    $bbpm_loader->init();
}
add_action('plugins_loaded', 'bbp_messages_loaded', 10, 0);

function disputo_messages_menu_item() {
    echo '<a class="dropdown-item" href="' . bbp_get_user_profile_url(get_current_user_id()) . 'messages">' . esc_html__('Messages', 'disputo') . '<span class="badge badge-primary">' . do_shortcode('[bbpm-unread-count]') . '</span></a>';
}

add_action ('disputo_messages_link', 'disputo_messages_menu_item');
?>