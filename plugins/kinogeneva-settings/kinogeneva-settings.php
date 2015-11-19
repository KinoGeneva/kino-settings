<?php
/*
Plugin Name: KinoGeneva Settings
Plugin URI: 
Description: Functionality for KinoGeneva
Version: 1.0.1
Author: Manu + Jul’
Author URI: 
*/


/*
 *

What this plugin does:

- UI customisation

 */
 
// UI customisation
include_once (plugin_dir_path(__FILE__).'ui-customization.php');
 
// Translations
include_once (plugin_dir_path(__FILE__).'translation.php');

// Cron
include_once (plugin_dir_path(__FILE__).'cron-groups.php');


// remove action

remove_action( 'init', 'wp_register_default_user_type_taxonomy', 10 );

add_action( 'plugins_loaded' , 'kino_remove_stuff' , 10 );
function kino_remove_stuff() {
 remove_action( 'init', 'wp_register_default_user_type_taxonomy', 999 );
}

// login redirection

add_filter('login_redirect','kino_login_redirection',100,3);

function kino_login_redirection($redirect_url,$request_url,$user) {
	global $bp;
	return bp_core_get_user_domain($user->ID).'/profile/edit/group/10/'; // returns url to user account
}

//