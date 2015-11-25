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

/*
 * Message Dashboard Edit Profile
 
 * Message à afficher pour aider à compléter le profil
 * 
**************************************/

 function kino_edit_profile_notifications( $userid ) {
 	
 	if ( empty( $userid ) ) {
 		$userid = bp_loggedin_user_id();
 	}
 	
 	$kino_notification = '';
 	
 	$kino_notification_email = '';
 	
 	$kino_fields = kino_test_fields();
 	
 	// run our test battery...
 	
 	$kino_user_role = kino_user_participation( $userid );
 	
 	// For Debugging:
 	
// 	echo '<pre>';
// 	var_dump($kino_user_role);
// 	echo '</pre>';
 	
// 	$kino_dispo_kab = bp_get_profile_field_data( array(
// 			'field'   => 1122, // trouver ID du champ!
// 			'user_id' => $userid
// 	) );
// 	
// 	echo '<pre>';
// 		var_dump($kino_dispo_kab);
// 		echo '</pre>';
 	

 	
 	
 	/*
 		 * Before performing tests, organise groups for Réalisateurs
 		 *
 		 * - real-platform-pending
 		 * - real-kabaret-pending
 		***/
 			
 			if ( in_array( "realisateur", $kino_user_role ) ) {
 				
 				 		if( has_term( 
 				 				$kino_fields['group-real-platform'], 
 				 				'user-group', 
 				 				$userid ) ) {
 				 				// do nothing
 				 		} else if( has_term( 
 							$kino_fields['group-real-platform-pending'], 
 							'user-group', 
 							$userid ) ) {
 								// do nothing
 				 		} else if( has_term( 
 				 			$kino_fields['group-real-platform-rejected'], 
 				 			'user-group', 
 				 			$userid ) ) {
 				 				// do nothing
 				 		} else {
 				 				// move to group: real-platform-pending
 				 				wp_set_object_terms( 
 				 					$userid, // $object_id, 
 				 					$kino_fields['group-real-platform-pending'], // $terms, 
 				 					'user-group', // $taxonomy, 
 				 					true // $append 
 				 				);
 				 		}
 				
 		} // end testing "realisateur"
 		
 		
 		if ( in_array( "realisateur-2016", $kino_user_role ) ) {
 					
 					 		if( has_term( 
 					 				$kino_fields['group-real-kabaret'], 
 					 				'user-group', 
 					 				$userid ) ) {
 					 				// do nothing
 					 		} else if( has_term( 
 								$kino_fields['group-real-kabaret-pending'], 
 								'user-group', 
 								$userid ) ) {
 									// do nothing
 					 		} else if( has_term( 
 					 			$kino_fields['group-real-kabaret-rejected'], 
 					 			'user-group', 
 					 			$userid ) ) {
 					 				// do nothing
 					 		} else {
 					 				// move to group: real-kabaret-pending
 					 				wp_set_object_terms( 
 					 					$userid, // $object_id, 
 					 					$kino_fields['group-real-kabaret-pending'], // $terms, 
 					 					'user-group', // $taxonomy, 
 					 					true // $append 
 					 				);
 					 		}
 					
 			} // end testing "realisateur-2016"
 		
 	
 	
 	// Massive Conditional Testing
 	
 	// DO WHILE structure
 	// src: http://stackoverflow.com/questions/7468836/any-way-to-break-if-statement-in-php
 	
 	do {
 		 
 		// Q : is user in group "Participants Kino 2016 (profil complet)"?
 		
 		if( has_term( 
 			$kino_fields['group-kino-complete'], 
 			'user-group', 
 			$userid ) 
 		) { 
 		
 			// Profile is already complete = do nothing!
 			break;
 		}
 		
 		/*Q0 : taking part in Kino 2016? */
 		
 	  if( !in_array( "kabaret-2016", $kino_user_role ) ) { 
 	    
 	    // un peu de pub...
 	    $kino_notification = 'Le prochain Kino Kabaret se déroule du 18 au 28 janvier 2016! N’oubliez pas <a href="'.bp_core_get_user_domain( $userid ).'profile/edit/group/1/">de vous inscrire par ici</a>, et d’enregistrer tous les onglets jusqu’à celui du Kino Kabaret.';
 	    
 	    break; }
 		
 		// if we continue = the user joins the Kabaret 2016
 		
 		
 		$kino_notification_email .= "Votre inscription au Kino Kabaret est bien prise en compte. Quant au paiement des frais de participation, il s’effectue en liquide et sur place, au lieu central.
 		
Pour toutes les informations pratiques et le programme du Kino Kabaret, voir: http://kinogeneva.ch/informations-pratiques/ ";
 			
 	  /* Q1 : is the ID part complete? */
 	
 	  if( !in_array( "id-complete", $kino_user_role ) ) { 
 	  		
 	  		// user subscribed but:
 	  		// id section = incomplete
 	  		
 	  		$kino_notification = 'Complétez votre profil (identité)';
 	  		break; }
 	
 	  /* Q2 : is "Compétence Comédien" complete? */
 	  
 	  if( in_array( "comedien", $kino_user_role ) && !in_array( "comedien-complete", $kino_user_role ) ) { 
 	   		$kino_notification = 'Complétez votre profil (Compétence Comédien).';
 	   		break; }
 	   		
 		
 		// Q3 : is "Compétence Tech" complete?
 		
 		if( in_array( "technicien", $kino_user_role ) && !in_array( "technicien-complete", $kino_user_role ) ) { 
 		  		$kino_notification = 'Complétez votre profil (Compétence Technicien).';
 		  		break; }
 	  		
		// Q4 : is "Compétence Réal" complete?
		
		if ( in_array( "realisateur", $kino_user_role ) ) {
		
			if ( in_array( "realisateur-complete", $kino_user_role ) ) {
				
				// Cette personne vient de compléter la section "Compétence Réalisateur"!
				
				$kino_notification_email .= "
				
PS: Votre candidature en tant que réalisateur-trice est soumise au comité de sélection et vous serez notifié-e par e-mail des résultats.";
			
			} else {
				
				$kino_notification = 'Complétez votre profil (Compétence Réalisateur).';
					break;
			}
		}  
		
		
		// Q5 : is "Aide Bénévole" complete?
		
		if( in_array( "benevole", $kino_user_role ) && !in_array( "benevole-complete", $kino_user_role ) ) {
		 
		 		$kino_notification = 'Merci de vous proposer comme bénévole. Complétez votre profil d’aide bénévole.';
		 		break; }
		
		
		// Q6 : is "Kino Kabaret 2016" complete?
		if( in_array( "kabaret-2016", $kino_user_role ) && !in_array( "kabaret-complete", $kino_user_role ) ) { 
		 		$kino_notification = 'Complétez les informations relatives à votre participation au Kino Kabaret.';
		 		break; }
		
		
		// Q7 : is "Photo du Profil" complete?
		
		if( !in_array( "avatar-complete", $kino_user_role ) ) { 
		 		$kino_notification = 'Bravo, votre profil est presque complet! Il ne vous reste plus qu’à <a href="'.bp_core_get_user_domain( $userid ).'profile/change-avatar/">choisir une photo d’avatar</a>.';
		 		break; }
		
		// Q8 : is already in group "Participants Kino 2016 (profil complet)"?
		
		if( has_term( 
			$kino_fields['group-kino-complete'], 
			'user-group', 
			$userid ) 
		) { 
		
			// Profile is complete - do nothing
			break;
			
		} else {
			
			$kino_notification = 'Votre profil est complet. Vous pouvez régulièrement mettre à jour les informations de votre profil en vous connectant avec votre mot de passe.
				<script>
					mixpanel.track(
					    "Completed Profile"
					);
				</script>
			';
				
				// action 1 = add user to group
				
				wp_set_object_terms( 
					$userid, // $object_id, 
					$kino_fields['group-kino-complete'], // $terms, 
					'user-group', // $taxonomy, 
					true // $append 
				);
				
				// action 2 = send email notification!
				// wp_mail( $to, $subject, $message, $headers, $attachments ); 
				
				$headers[] = 'From: KinoGeneva <onvafairedesfilms@kinogeneva.com>';
				$headers[] = 'Bcc: Manu <ms@ms-studio.net>';
				
				// load user info
				$user = get_user_by( 'id', $userid );
				
				$kino_notification_email .= '

(Debug: message envoyé depuis la page '.$_SERVER[REQUEST_URI].' à '. date( 'H:i:s', time() ) .')';
				
				
				 wp_mail( 
				 	$user->user_email, 
				 	'KinoGeneva: Confirmation', 
				 	$kino_notification_email, 
				 	$headers 
				 );
				
				break;
		
		}
		
		
 	} while (0);
 	
 	
 	return $kino_notification;
 	
 }

 ?>