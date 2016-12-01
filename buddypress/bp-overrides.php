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