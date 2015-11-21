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

// Cron
include_once (plugin_dir_path(__FILE__).'users.php');



// login redirection

// add_filter('login_redirect','kino_login_redirection',100,3);

// NOTE = this overrides the redirect url string!

function kino_login_redirection($redirect_url,$request_url,$user) {
	global $bp;
	return bp_core_get_user_domain($user->ID).'/profile/edit/group/10/'; // returns url to user account
}

//