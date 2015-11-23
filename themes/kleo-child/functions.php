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
		'name' => 'Tab Bottom Profil Kinoite',
		'id' => 'sidebar-48',
		'description' => 'Le texte en bas pour profil kinoite',
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
		'description' => 'Le texte en bas pour Comédien',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => 'Tab Bottom Identity Widget Area',
		'id' => 'sidebar-46',
		'description' => 'Le texte en bas pour Identité',
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


}
add_action( 'widgets_init', 'kino_widgets_init' );



/* admin interface
******************************/

require_once('functions/admin.php');

require_once('functions/bp-fields.php');

require_once('functions/bp-group-tabs.php');

require_once('functions/bp-messages.php');

/* 
kleo-google-fonts-css
*/

/* Forcer éditeur texte par défaut
***************************************/

// Set the editor to HTML ("Text")
add_filter( 'wp_default_editor', create_function(null,'return "html";') );


/* Login redirection
 * Voir discussion: https://bitbucket.org/ms-studio/kinogeneva/issues/26/
***************************************/

add_filter('login_redirect','kino_login_redirection',10,3);
// NOTE = this overrides the redirect url string!

function kino_login_redirection( $redirect_to, $request, $user ) {

		global $bp;
		//is there a user to check?
		global $user;
		
		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			
			if (function_exists('kino_user_participation')) {
				
				$kino_user_role = kino_user_participation( $user->ID );
				
				// Déjà inscrit au Kabaret?
				if ( in_array( "kabaret-2016", $kino_user_role ) ) {
					
					// Aller à la section identité
					return bp_core_get_user_domain($user->ID).'/profile/edit/group/10/';
				
				} else 
				
				// Pas inscrit? 
				// Aller à la section Profil Kinoite
				
				return bp_core_get_user_domain($user->ID).'/profile/edit/group/1/';
				
			} else {
			
				// Pas de test?
				return $redirect_to;
			}
			
		} else { // user not defined
			
			// redirect them to the default place
			return $redirect_to;
			
		}

}


function my_bp_get_users_by_xprofile( $field_id, $value ) {
 
    global $wpdb;
 
    $user_ids = $wpdb->get_col(
        $wpdb->prepare(
            "
                SELECT `user_id`
                FROM `{$wpdb->prefix}bp_xprofile_data`
                WHERE `field_id` = %d
                    AND `value` = %s
            "
            , $field_id
            , $value
        )
    );
}



