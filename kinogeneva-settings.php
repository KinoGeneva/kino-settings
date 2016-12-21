<?php
/*
Plugin Name: KinoGeneva Settings
Plugin URI: 
Description: Functionality for KinoGeneva
Version: 1.0.2
Author: Collectif WP
Author URI: http://collectifwp.ch/
*/


 
// Register Post Types
include_once (plugin_dir_path(__FILE__).'content-types.php');
 
// UI customisation
include_once (plugin_dir_path(__FILE__).'ui-customization.php');
 
// User settings
include_once (plugin_dir_path(__FILE__).'users.php');

// Term metadata - for logements
include_once (plugin_dir_path(__FILE__).'term-meta.php');

// Stats
include_once (plugin_dir_path(__FILE__).'statistics.php');

// Print
include_once (plugin_dir_path(__FILE__).'print.php');

// Ajax
include_once (plugin_dir_path(__FILE__).'ajax.php');

// BuddyPress Settings

include_once (plugin_dir_path(__FILE__).'buddypress/bp-fields.php');

include_once (plugin_dir_path(__FILE__).'buddypress/bp-overrides.php');

// Utilities

include_once (plugin_dir_path(__FILE__).'utilities.php');

//mailpoet added
include_once (plugin_dir_path(__FILE__).'mailpoet-add.php');


// end file
