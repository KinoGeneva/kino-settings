<?php 

// Masquer la barre admin pour les subscribers:
// source: http://wpbeg.in/Hg3djT

function kino_remove_admin_bar() {
	if ( current_user_can('subscriber') && !is_admin() ) {
  	show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'kino_remove_admin_bar');

/**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
function kino_redirect_admin(){
	if ( ! defined('DOING_AJAX') && current_user_can('subscriber') ) {
		wp_redirect( site_url() );
		exit;		
	}
}
// add_action( 'admin_init', 'kino_redirect_admin' );
// NOTE: cela empêche de changer l'adresse email!

// Dashboard: remove Visual composer for subscribers
function kino_remove_menus() {
  if ( current_user_can( 'subscriber' ) ) {
		  remove_menu_page( 'index.php' );
		  remove_menu_page( 'admin.php?page=vc-welcome' );
		  
		  remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
  }
}
add_action( 'admin_menu', 'kino_remove_menus', 999);

add_action( 'init', 'kino_subscriber_hide_groups', 0 );
function kino_subscriber_hide_groups() {
    if ( current_user_can( 'subscriber' ) ) {
    	remove_action( 'show_user_profile', 'edit_user_relationships', 999 );
    	remove_action( 'edit_user_profile', 'edit_user_relationships', 999 );
    }
}

// remove Visual Composer Menu
function kino_vc_admin_css() {
  if ( current_user_can( 'subscriber' ) ) {
		  echo '<style>
		 #toplevel_page_vc-welcome,
		 tr.user-admin-bar-front-wrap,
		 tr.user-url-wrap,
		 tr.user-description-wrap,
		 #profile-nav 
		 {
		 	display: none;
		 }
		 div#profile-page.wrap form#your-profile {
		 	padding-top: 0px;
		 }
		  </style>';
	}
}
add_action('admin_head', 'kino_vc_admin_css');

// WP User Groups 

// we don't need Types taxonomy, groups is enough

function kino_remove_stuff() {
 remove_action( 'init', 'wp_register_default_user_type_taxonomy' );
}
add_action( 'init' , 'kino_remove_stuff' , 0 );

// ajouter taxonomie "Logements"

function kino_register_logement_taxonomy() {
	
	// Logements
	new WP_User_Taxonomy( 'user-logement', 'users/logement', array(
		'singular' => 'Logement',
		'plural'   => 'Logements'
	) );
	
	// Competences
	new WP_User_Taxonomy( 'user-competences', 'users/competences', array(
		'singular' => 'Compétence',
		'plural'   => 'Compétences'
	) );
	
	// Comptabilité
	new WP_User_Taxonomy( 'user-compta', 'users/compta', array(
		'singular' => 'Compta',
		'plural'   => 'Compta'
	) );
	
}
add_action( 'init', 'kino_register_logement_taxonomy', 20 );

function kino_limit_group_access() {

	global $wp_taxonomies;
//	$wp_taxonomies['user-group'] = new StdClass;
//	$wp_taxonomies['user-logement'] = new StdClass;
	$wp_taxonomies['user-group']->cap->assign_terms = 'list_users';
	$wp_taxonomies['user-logement']->cap->assign_terms = 'list_users';
	
	// Warning: Creating default object from empty value in /kinogeneva-settings/users.php on line 103
	

}
add_action('init','kino_limit_group_access', 11);


