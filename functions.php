<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

/**
 * Kleo Child Theme Functions
 * Add custom code below
*/ 

/*
    Add this into a custom plugin or your active theme's functions.php
*/




function kino_widgets_init() {
	register_sidebar( array(
		'name' => 'Checkout Widget Area',
		'id' => 'sidebar-40',
		'description' => 'Pour le texte en haut du formulaire de checkout pour un niveau d\'adhésion',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Widget Area',
		'id' => 'sidebar-41',
		'description' => 'Le texte en haut du formulaire d\'édtion de profil',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Bottom Widget Area',
		'id' => 'sidebar-42',
		'description' => 'Le texte en bas du formulaire d\'édtion de profil',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => 'Tab Bottom Director Widget Area',
		'id' => 'sidebar-44',
		'description' => 'Le texte en bas pour réalisateurs',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Bottom Comedian Widget Area',
		'id' => 'sidebar-45',
		'description' => 'Le texte en bas pour comédien 1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Bottom Comedian 2 Widget Area',
		'id' => 'sidebar-46',
		'description' => 'Le texte en bas pour comédien 2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Bottom Technician Widget Area',
		'id' => 'sidebar-47',
		'description' => 'Le texte en bas pour artisans',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Bottom Kabaret 1 Widget Area',
		'id' => 'sidebar-48',
		'description' => 'Le texte en bas ppur Kabaret 1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Bottom Kabaret 2 Widget Area',
		'id' => 'sidebar-49',
		'description' => 'Le texte en bas de Kabaret 2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'kino_widgets_init' );

/*add_action( 'bp_profile_header_meta', 'display_user_color_pref' );
function display_user_color_pref() {
    $args = array(
        'field'   => 'Sexe', // Field name or ID.
        );
    $favorite_color = bp_get_profile_field_data( $args );
 
    if ($favorite_color) {
        echo 'sexe: ' . $favorite_color;
    }
     
}*/

/* admin interface
******************************/

require_once('functions/admin.php');

require_once('functions/bp-group-tabs.php');

/* 
kleo-google-fonts-css
*/


