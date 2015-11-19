<?php 

// Function: replace email message sent by BuddyPress:

/*

On reçoit un message qui dit actuellement “Merci pour votre inscription! Pour activer votre compte, veuillez cliquer sur le lien suivant:”

Le remplacer par “Merci d’avoir créé un compte sur la plateforme KinoGeneva. Vous devez activer votre compte en cliquant sur le lien suivant:”

Note: le code se trouve dans buddypress/bp-core/bp-core-filters.php

// $message = apply_filters( 'bp_core_activation_signup_user_notification_message', $message, $user, $user_email, $key, $meta );

// exemples: http://websistent.com/custom-buddypress-activation-email/

*/

add_filter( 'bp_core_activation_signup_user_notification_message', 'custom_buddypress_activation_message', 10, 5 );
 
function custom_buddypress_activation_message( $message, $user, $user_email, $key, $meta ) {
    
    // Set up activation link
    $activate_url = bp_get_activation_page() . "?key=$key";
    $activate_url = esc_url( $activate_url );
    
    // Email contents
    $message =  "Merci d’avoir créé un compte sur la plateforme KinoGeneva. Vous devez activer votre compte en cliquant sur le lien suivant:
$activate_url
";	
		return $message;
}

/* Partie 2: */

// changer message: msgid "You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address."

// needs to be changed in PoMo files

  

 ?>