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

// Cron operations
include_once (plugin_dir_path(__FILE__).'cron-groups.php');

// User settings
include_once (plugin_dir_path(__FILE__).'users.php');

// Stats
include_once (plugin_dir_path(__FILE__).'statistics.php');



//