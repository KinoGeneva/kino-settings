<?php 

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