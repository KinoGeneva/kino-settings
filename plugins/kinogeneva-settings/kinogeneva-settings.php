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


 */
 
// Register Post Types
include_once (plugin_dir_path(__FILE__).'content-types.php');
 
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

// Print
include_once (plugin_dir_path(__FILE__).'print.php');


//