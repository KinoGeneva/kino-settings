<?php 

// Masquer la barre admin pour les subscribers:
// source: http://wpbeg.in/Hg3djT

add_action('after_setup_theme', 'kino_remove_admin_bar');

function kino_remove_admin_bar() {
	if ( current_user_can('subscriber') && !is_admin() ) {
  	show_admin_bar(false);
	}
}

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
add_action( 'admin_init', 'kino_redirect_admin' );


// WP User Groups 

// we don't need Types taxonomy, groups is enough

add_action( 'init' , 'kino_remove_stuff' , 0 );
function kino_remove_stuff() {
 remove_action( 'init', 'wp_register_default_user_type_taxonomy' );
}


?>