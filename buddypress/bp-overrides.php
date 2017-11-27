<?php 


/* Change Default Members Profile Landing Tab
************************************ */

/**
 * Change BuddyPress default Members landing tab.
 * https://codex.buddypress.org/getting-started/guides/change-members-profile-landing-tab/
 */
define('BP_DEFAULT_COMPONENT', 'profile' );



/* Prevent links on profile page
************************************ */

function remove_xprofile_links() {
    remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
}
add_action( 'bp_init', 'remove_xprofile_links', 20 );
// source: https://codex.buddypress.org/themes/bp-custom-php/


/* Hide specific BuddyPress pages from non-logged visitors
*************************************************** */

function kino_bp_guest_redirect() {
	
	if ( function_exists('bp_is_activity_component') ) {
		
		global $bp;
		
		if ( bp_is_activity_component() || bp_is_forums_component()  ) {
			// enter the slug or component conditional here
			
			if ( !is_user_logged_in() ) { // not logged in user
			
				wp_redirect( home_url( 'inscription-membre' ) );
			
			} // user will be redirect to any link to want
		
		}
	
	}
	
}
add_filter('get_header', 'kino_bp_guest_redirect' , 1 );



/* Make new groups private by default
*******************************************/

// override: bp_get_new_group_status = 
// return apply_filters( 'bp_get_new_group_status', $status );

// Options are: public, private, hidden
// We want: private:

add_filter( 'bp_get_new_group_status', 'kino_set_new_group_status', 10 );

function kino_set_new_group_status( $status ){
  $status = 'private';
  return $status;
}

// Ce code masque le premier bloc des options de confidentialité.

add_action( 'bp_before_group_settings_creation_step', 'kino_new_group_javascript', 10 );

function kino_new_group_javascript() {

	echo '<script type="text/javascript">
	
	 jQuery(document).ready(function($){	
	 
	 	$("#group-create-body div.radio > label").first().hide(); 
	 
	 });
	
	</script>';
}


// Ce code modifie l'envoi de notifications

add_filter( 'messages_notification_new_message_headers', 'kino_set_notification_headers', 10, 4 );

function kino_set_notification_headers( $headers, $sender_name, $sender_id, $ud ){
  
  // get the email address of $sender_id
  $sender_data = get_userdata($sender_id);
  
  // $headers = array( 'Reply-To' => $sender_name." <".$sender_data->user_email.">" );
  $headers = 'Reply-To: '.$sender_name.' <'.$sender_data->user_email.'>' . "\r\n";
  
  return $headers;
}

// Ce code permet aux Réalisateurs de créer des Groupes:
// Voir https://bitbucket.org/ms-studio/kinogeneva/issues/180/fiche-projet-gestion-des-droits
// Note: this filter takes two parameters: $can_create, $restricted

add_filter( 'bp_user_can_create_groups', 'kino_real_create_project', 10, 2 );

function kino_real_create_project( $can_create, $restricted ){
  
  $user_ID = get_current_user_id();
  
  $kino_fields = kino_test_fields();
  
  $ids_of_kino_realisateurs = get_objects_in_term( 
  		$kino_fields['group-real-kabaret'], 
  		'user-group' 
  	);
  	
  // test if current user belongs to group real-kabaret		
  if ( in_array( $user_ID, $ids_of_kino_realisateurs )) {
  	$can_create = true;
  	$restricted = 0;
  }	

   return $can_create;
   return $restricted;
  
}

