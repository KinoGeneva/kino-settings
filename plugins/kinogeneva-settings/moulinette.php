<?php 

// Good Info:
// http://wordpress.stackexchange.com/questions/179694/wp-schedule-event-every-day-at-specific-time

// wp_clear_scheduled_hook('cowork_task_hook');

if ( !wp_next_scheduled( 'kino_hourly_task_hook' ) ) {

  wp_schedule_event( 
  	strtotime('00:10:00'), 
  	'hourly', // daily hourly
  	'kino_hourly_task_hook' 
  );

  // note: wp_schedule_event should always take GMT!
  // donc si on veut l'envoi à 17:30, il faut mettre 16:30
}

add_action( 'kino_hourly_task_hook', 'kino_hourly_task' );


function kino_hourly_task() {

	/* 1: "moulinette des listes session"
	 * Vérifier les sessions des réalisateurs validés, et 
	 * les ajouter dans les listes Mailpoet
	*/
	
	$message = '';
	
	$kino_fields = kino_test_fields();
	
	$ids_real_kabaret_accepted = get_objects_in_term( 
		$kino_fields['group-real-kabaret'] , 
		'user-group' 
	);
	
	if (!empty($ids_real_kabaret_accepted)) {
		$user_query = new WP_User_Query( array( 
			'include' => $ids_real_kabaret_accepted, 
			'orderby' => 'registered',
			'order' => 'DESC'
		) );
		if ( ! empty( $user_query->results ) ) {
			
	  	foreach ( $user_query->results as $user ) {
	  		// Test Sessions
	  		$id = $user->ID;
	  		
	  		// $message .= ' / user id: '.$id.' ';
	  		
	  		$kino_session_attrib = bp_get_profile_field_data( array(
	  				'field'   => $kino_fields['session-attribuee'],
	  				'user_id' => $id
	  		) );
	  		
	  		// $message .= ' - session : '.$kino_session_attrib.' ';
	  		
	  		$value = mb_substr($kino_session_attrib, 0, 9);
	  		if ( $value == 'session 1' ) {
	  			
//	  			kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-session-un'] );
	  			
	  			// kino_remove_from_mailpoet_list( $id, $kino_fields['mailpoet-session-trois']);
						
//						kino_remove_from_mailpoet_list( $id, 
//							array( $kino_fields['mailpoet-session-deux'],
//										 $kino_fields['mailpoet-session-trois']) );
	  			
	  			$message .= ' / Action : moved user '.$id.' to:  '.$kino_session_attrib.' ';
	  			
	  		} else if ( $value == 'session 2' ) {
	  		
//	  			kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-session-deux'] );
//	  			
//	  			kino_remove_from_mailpoet_list( $id, 
//	  				array( $kino_fields['mailpoet-session-un'],
//	  							 $kino_fields['mailpoet-session-trois']) );
	  			
	  			$message .= ' / Action : moved user '.$id.' to session-deux.';
	  			
	  		} else if ( $value == 'session 3' ) {
	  		
//	  			kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-session-trois'] );
//	  			
//	  			kino_remove_from_mailpoet_list( $id, 
//	  				array( $kino_fields['mailpoet-session-un'],
//	  							 $kino_fields['mailpoet-session-deux']) );
	  			
	  			$message .= ' / Action : moved user '.$id.' to session-trois.';
	  			
	  		} else if ( $value == 'session 4' ) {
	  		
//	  			kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-session-superhuit'] );
	  			
	  			$message .= ' / Action : moved user '.$id.' to session-super8.';
	  		
	  		}
	  	}
		}
	}
	
	$to = 'ms@ms-studio.net';
	$headers[] = 'From: KinoGeneva <ms@ms-studio.net>';
	$subject = '[Kino] Debug Info';
	
	
//	wp_mail( 
//		$to,
//		$subject,
//		$message, 
//		$headers 
//	);

	/* 2: "réalisateurs en attente"
	 * 1 liste pour les réals que nous laissons sur liste d'attente
	 * > la créer manuellement (ou alors via un groupe).* 
	 * Damien : Pour la liste d'attente on pourrait dire que c'est les "Reals Kabaret en
	 attente" + "bon". 
	*/
	

} // end kino_hourly_task()


//if ( !wp_next_scheduled( 'kino_moulinette_competences_kab_hook' ) ) {
//
//  wp_schedule_event( 
//  	strtotime('00:33:00'), 
//  	'hourly', // daily hourly
//  	'kino_moulinette_competences_kab_hook' 
//  );
//
//  // note: wp_schedule_event should always take GMT!
//  // donc si on veut l'envoi à 17:30, il faut mettre 16:30
//}

// add_action( 'kino_moulinette_competences_kab_hook', 'kino_moulinette_competences_kab' );

function kino_moulinette_competences_kab() {

	/* Aussi, on a besoin de listes Mailpoet par compétences: au moins Réals, Tech ou 
	 * Comédien (uniquement inscrit au kabaret 2016). On doit envoyer d'ici demain un 
	 * mail à tous les comédiens inscrit au kabaret 2016.
	*/
	
	$message = '<p>Moulinette Compétences Kab: </p>';
	
	$kino_fields = kino_test_fields();
	
	$ids_participants_kabaret = get_objects_in_term( 
		$kino_fields['group-kino-pending'] , 
		'user-group' 
	);
	
	if (!empty($ids_participants_kabaret)) {
		$user_query = new WP_User_Query( array( 
			'include' => $ids_participants_kabaret, 
			'orderby' => 'registered',
			'order' => 'DESC'
		) );
		if ( ! empty( $user_query->results ) ) {
	  	
	  	$message = '<p>Participants en attente: '.count($user_query->results).'</p>';
	  	
	  	foreach ( $user_query->results as $user ) {
	  		// Test Sessions
	  		$id = $user->ID;
	  		$username = $user->user_email;
	  		
	  		// Test des rôles pour le Kabaret 2016
	  		$kino16_particiation_boxes = bp_get_profile_field_data( array(
	  				'field'   => $kino_fields['role-kabaret'],
	  				'user_id' => $id
	  		) );
	  		
	  		// test field = participation en tant que
	  		
	  		if ($kino16_particiation_boxes) {
	  			foreach ($kino16_particiation_boxes as $key => $value) {
	  			
	  				$value = mb_substr($value, 0, 4);
	  			
	  			  if ( $value == "Réal" ) {
	  			  	// $kup[] = "realisateur-2016";
	  			  }
	  			  if ( $value == "Comé" ) {
	  			  	// $kup[] = "comedien-2016";
//	  			  	kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-kabaret-comedien'] );
	  			  	
	  			  	$message .= ' / Added user '.$username.' ('.$id.') to list Comédiens.';
	  			  	
	  			  }
	  			  if ( $value == "Arti" ) {
	  			  	// $kup[] = "technicien-2016";
//	  			  	kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-kabaret-technicien'] );
	  			  	
	  			  	$message .= ' / Added user '.$username.' ('.$id.') to list Techniciens.';
	  			  	
	  			  }
	  			} // end foreach
	  		} // end testing kino16_particiation_boxes
	  		
	  		// Test if name field is complete!
	  		
	  	} // end foreach $user
		} // 
	}
	
	$to = 'ms@ms-studio.net';
	$headers[] = 'From: KinoGeneva <ms@ms-studio.net>';
	$subject = '[Kino] Debug Info';
	
	
//	wp_mail( 
//		$to,
//		$subject,
//		$message, 
//		$headers 
//	);
	
} // end kino_moulinette_competences_kab()

// *********************

if ( !wp_next_scheduled( 'kino_moulinette_timestamp_hook' ) ) {

  wp_schedule_event( 
  	strtotime('00:42:00'), 
  	'hourly', // daily hourly
  	'kino_moulinette_timestamp_hook' 
  );

  // note: wp_schedule_event should always take GMT!
  // donc si on veut l'envoi à 17:30, il faut mettre 16:30
}

add_action( 'kino_moulinette_timestamp_hook', 'kino_moulinette_timestamp' );

function kino_moulinette_timestamp() {
	
	// Fonctionnement:
	// On parcourt tous les profils 
	
	$kino_fields = kino_test_fields();
	
	$ids_participants_complets = get_objects_in_term( 
		$kino_fields['group-kino-complete'], 
		'user-group' 
	);
	
//	$user_fields = array( 
//		'ID',
//		'registered', 
//	);
	
	$user_query = new WP_User_Query( array( 
		// 'fields' => $user_fields,
		// 'include' => $ids_participants_kabaret,
		'exclude' => array( 0 ), 
		'orderby' => 'registered',
		'order' => 'DESC'
	) );
	
	if ( !empty( $user_query->results ) ) {
	
		$message = '<p>Voici les nouvelles du timestamp!</p>';
		$message .= '<p>Nombre de participants au profil complet: '.count($user_query->results).'</p>';
		
		foreach ( $user_query->results as $user ) {
				
				$id = $user->ID;
				
				$user_timestamp_complete = get_user_meta( $id, 'kino_timestamp_complete', true );
				
				// si l'utilisateur est dans le groupe kino-complete:
				
				if ( in_array( $id, $ids_participants_complets ) ) {
					
							$message .= '<p>Utilisateur '.$id.' dans groupe kino-complete</p>';
					
							// si le champ meta timestamp est défini: on ne fait rien
							// sinon = on le définit
							
							if ( empty($user_timestamp_complete) ) {
								
								// Y-m-d is the correct format
								
								$timestamp = date('Y-m-d\TH:i:s', strtotime('+1 hours'));
								
								update_user_meta( $id, 'kino_timestamp_complete', $timestamp );
								
								$message .= '<p>Timestamp de '.$id.' vide - on le définit: '.$timestamp.'</p>';
								
							} else {
								
//								delete_user_meta( $id, 'kino_timestamp_complete');
//								$timestamp = date('Y-m-d\TH:i:s', strtotime('+1 hours'));
//								update_user_meta( $id, 'kino_timestamp_complete', $timestamp );
								
								$message .= '<p>Timestamp de '.$id.' non vide - contenu: '.$user_timestamp_complete.'</p>';
							}
					
				} else {
					
					// si l'utilisateur N'est PAS dans le groupe kino-complete:
					
					$message .= '<p>Utilisateur '.$id.' PAS dans groupe kino-complete</p>';
					
							// si le champ meta timestamp est défini: on l'efface!
							// sinon = on ne fait rien
							
							if ( !empty($user_timestamp_complete) ) {
								
								delete_user_meta( $id, 'kino_timestamp_complete');
								
							}
							
				}
				
					// updating all email fields
//					xprofile_set_field_data(  
//						$kino_fields['courriel'],  
//						$id, 
//						$user->user_email
//					);
					
				
				
				
		} // foreach
	} // if !empty
	
//	$to[] = 'ms@ms-studio.net';
//	$headers[] = 'From: KinoGeneva <onvafairedesfilms@kinogeneva.ch>';
//	$subject = '[Kino] Timestamp de '.date('H\hi');
//	
//	wp_mail( 
//		$to,
//		$subject,
//		$message, 
//		$headers 
//	);
	
		
} // end moulinette Timestamp

// *******************


if ( !wp_next_scheduled( 'kino_super_moulinette_hook' ) ) {

  wp_schedule_event( 
  	strtotime('00:51:00'), 
  	'hourly', // daily hourly
  	'kino_super_moulinette_hook' 
  );

  // note: wp_schedule_event should always take GMT!
  // donc si on veut l'envoi à 17:30, il faut mettre 16:30
}

add_action( 'kino_super_moulinette_hook', 'kino_super_moulinette' );

function kino_super_moulinette() {

	/* cette moulinette range les inscrits du Kabaret 2016 dans différents groupes:
	
	Realisateurs = OK
	Comédiens = OK
	
	Image = OK 
	Postproduction image
	Son & Postproduction son
	Production & Scénario
	Direction artistique & HMC
	Autres talents
	
	Staff
			
	*/
	
	$message = '<p>Moulinette Compétences Kab: </p>';
	
	$kino_fields = kino_test_fields();
	
	$kino_userdata = array();
	
	// On prend les candidats complets.
	$ids_participants_kabaret = get_objects_in_term( 
		$kino_fields['group-kino-complete'], 
		'user-group' 
	);
	
	//	Comédiens
	$ids_comp_comedien = get_objects_in_term( 
		$kino_fields['group-comp-comedien'], 
		'user-competences' 
	);
	
	//	Comédiens
	$ids_comp_technicien = get_objects_in_term( 
		$kino_fields['group-comp-technicien'], 
		'user-competences' 
	);
	
	//	Image
	$ids_comp_image = get_objects_in_term( 
		$kino_fields['group-comp-image'], 
		'user-competences' 
	);
	
	//	Postproduction image
	$ids_comp_postprod_img = get_objects_in_term( 
		$kino_fields['group-comp-postprod-image'], 
		'user-competences' 
	);
	
	//	Son & Postproduction son
	$ids_comp_postprod_son = get_objects_in_term( 
		$kino_fields['group-comp-postprod-son'], 
		'user-competences' 
	);

	//	Production & Scénario
	$ids_comp_prod_scenar = get_objects_in_term( 
		$kino_fields['group-comp-prod-scenar'], 
		'user-competences' 
	);
	
	//	Direction artistique & HMC
	$ids_comp_da_hmc = get_objects_in_term( 
		$kino_fields['group-comp-da-hmc'], 
		'user-competences' 
	);
	
	//	Autres talents
	$ids_comp_autres = get_objects_in_term( 
		$kino_fields['group-comp-autres'], 
		'user-competences' 
	);
	
	//	Staff
	$ids_staff = get_objects_in_term( 
		$kino_fields['group-comp-staff'], 
		'user-competences' 
	);
	
	//	Sessions
	$ids_session_un = get_objects_in_term( 
		$kino_fields['group-session-un'], 
		'user-group' 
	);
	$ids_session_deux = get_objects_in_term( 
		$kino_fields['group-session-deux'], 
		'user-group' 
	);
	$ids_session_trois = get_objects_in_term( 
		$kino_fields['group-session-trois'], 
		'user-group' 
	);
	$ids_session_superhuit = get_objects_in_term( 
		$kino_fields['group-session-superhuit'], 
		'user-group' 
	);
	
	if (!empty($ids_participants_kabaret)) {
		$user_query = new WP_User_Query( array( 
			'include' => $ids_participants_kabaret, 
			'orderby' => 'registered',
			'order' => 'DESC'
		) );
		if ( ! empty( $user_query->results ) ) {
	  	
	  	$message = '<p>Voici les nouvelles de la Super Moulinette!</p>';
	  	
	  	$message .= '<p>Nombre de participants au profil complet: '.count($user_query->results).'</p>';
	  	
	  	foreach ( $user_query->results as $user ) {
	  		// Test Sessions
	  		$id = $user->ID;
	  		$kino_userid = $id;
	  		$username = $user->user_email;
	  		
	  		// Test des rôles pour le Kabaret 2016
	  		$kino16_particiation_boxes = bp_get_profile_field_data( array(
	  				'field'   => $kino_fields['role-kabaret'],
	  				'user_id' => $id
	  		) );
	  		
	  		// test field = participation en tant que
	  		
	  		if ($kino16_particiation_boxes) {
	  			foreach ($kino16_particiation_boxes as $key => $value) {
	  			
	  				$value = mb_substr($value, 0, 4);
	  			
	  			  if ( $value == "Réal" ) {
	  			  
	  			  		// Tests de session
	  			  		$kino_session_attrib = bp_get_profile_field_data( array(
	  			  				'field'   => $kino_fields['session-attribuee'],
	  			  				'user_id' => $id
	  			  		) );
	  			  		
	  			  		$value = mb_substr($kino_session_attrib, 0, 9);
	  			  		if ( $value == 'session 1' ) {
	  			  			if ( !in_array( $id, $ids_session_un ) ) {
	  			  				kino_add_to_usergroup( $id, $kino_fields['group-session-un'] );
	  			  				$message .= ' / Action : moved user '.$id.' to:  '.$kino_session_attrib.' ';
	  			  			}
	  			  		} else if ( $value == 'session 2' ) {
	  			  			if ( !in_array( $id, $ids_session_deux ) ) {  		
		  			  			kino_add_to_usergroup( $id, $kino_fields['group-session-deux'] );
		  			  			$message .= ' / Action : moved user '.$id.' to session-deux.';
		  			  		}
		  			  	} else if ( $value == 'session 3' ) {
	  			  			if ( !in_array( $id, $ids_session_trois ) ) {	
	  			  				kino_add_to_usergroup( $id, $kino_fields['group-session-trois'] ); 			
	  			  				$message .= ' / Action : moved user '.$id.' to session-trois.';
	  			  			}			
	  			  		} else if ( $value == 'session 4' ) {
	  			  			 if ( !in_array( $id, $ids_session_superhuit ) ) {	
	  			  			 	kino_add_to_usergroup( $id, $kino_fields['group-session-superhuit'] );  			
	  			  			 	$message .= ' / Action : moved user '.$id.' to session-super8.';
	  			  			 }		
	  			  		} // fin tests de session
	  			  	
	  			  } // fin section "Réal"
	  			  
	  			  if ( $value == "Comé" ) {
	  			  		
	  			  		if ( !in_array( $id, $ids_comp_comedien ) ) {
					  			  kino_add_to_comp( $id, $kino_fields['group-comp-comedien'] );
	  			  				$message .= ' / Added user '.$username.' ('.$id.') to group Comédiens.';
	  			  		} else {
	  			  				// $message .= ' / User '.$username.' ('.$id.') already in group Comédiens.';
	  			  		}
	  			  	
	  			  } // fin section "Comé"
	  			  
	  			  if ( $value == "Arti" ) {
	  			  
	  			  		if ( !in_array( $id, $ids_comp_technicien ) ) {
	  			  			  kino_add_to_comp( $id, $kino_fields['group-comp-technicien'] );
	  			  				$message .= ' / Added user '.$username.' ('.$id.') to group Techniciens.';
	  			  		}
	  			  
	  			  	// 6 compétences techniques à tester
	  			  	// $message .= ' / testing Technician '.$username.' ('.$id.').';
	  			  	
	  			  	// 1: Image
	  			  	
	  			  	if ( !in_array( $id, $ids_comp_image ) ) {
	  			  		  // test
	  			  		  $kino_userdata["comp-image"] = bp_get_profile_field_data( array(
	  			  		   		'field'   => $kino_fields['comp-image'],
	  			  		   		'user_id' => $id
	  			  		   ) );
	  			  		   
	  			  		  if ( !empty( $kino_userdata["comp-image"] ) ) {
	  			  		  	kino_add_to_comp( $id, $kino_fields['group-comp-image'] );
	  			  		  	$message .= ' / Added user '.$username.' ('.$id.') to group Image.';
	  			  		  } 
	  			  	}
	  			  	
	  			  	// 2 : Postproduction image
	  			  	if ( !in_array( $id, $ids_comp_postprod_img ) ) {
	  			  		  $kino_userdata["comp-postprod-image"] = bp_get_profile_field_data( array(
	  			  		   		'field'   => $kino_fields['comp-postprod-image'],
	  			  		   		'user_id' => $id
	  			  		   ) );
	  			  		  if ( !empty( $kino_userdata["comp-postprod-image"] ) ) {
	  			  		  	kino_add_to_comp( $id, $kino_fields['group-comp-postprod-image'] );
	  			  		  	$message .= ' / Added user '.$username.' ('.$id.') to group Postprod Image.';
	  			  		  } 
	  			  	}
	  			  	
	  			  	// 3 : Son & Postproduction son
	  			  	if ( !in_array( $id, $ids_comp_postprod_son ) ) {
	  			  		  $kino_userdata["comp-son"] = bp_get_profile_field_data( array(
	  			  		   		'field'   => $kino_fields['comp-son'],
	  			  		   		'user_id' => $id
	  			  		   ) );
	  			  		   $kino_userdata["comp-postprod-son"] = bp_get_profile_field_data( array(
	  			  		    		'field'   => $kino_fields['comp-postprod-son'],
	  			  		    		'user_id' => $id
	  			  		    ) );
	  			  		  if ( ( !empty($kino_userdata["comp-son"]) ) || ( !empty($kino_userdata["comp-postprod-son"]) ) ) {
	  			  		  	kino_add_to_comp( $id, $kino_fields['group-comp-postprod-son'] );
	  			  		  	$message .= ' / Added user '.$username.' ('.$id.') to group Postprod Son.';
	  			  		  } 
	  			  	}			  	
	  			  	
	  			  	// 4: Production & Scénario
	  			  	if ( !in_array( $id, $ids_comp_prod_scenar ) ) {
	  			  		  $kino_userdata["comp-production"] = bp_get_profile_field_data( array(
	  			  		   		'field'   => $kino_fields['comp-production'],
	  			  		   		'user_id' => $id
	  			  		   ) );
	  			  		   $kino_userdata["comp-scenario"] = bp_get_profile_field_data( array(
	  			  		    		'field'   => $kino_fields['comp-scenario'],
	  			  		    		'user_id' => $id
	  			  		    ) );
	  			  		  if ( ( !empty($kino_userdata["comp-production"]) ) || ( !empty($kino_userdata["comp-scenario"]) ) ) {
	  			  		  	kino_add_to_comp( $id, $kino_fields['group-comp-prod-scenar'] );
	  			  		  	$message .= ' / Added user '.$username.' ('.$id.') to group Production & Scénario.';
	  			  		  } 
	  			  	}		
	  			  		
	  			  	// 5: Direction artistique & HMC
	  			  	if ( !in_array( $id, $ids_comp_da_hmc ) ) {
	  			  		  $kino_userdata["comp-direction-artistique"] = bp_get_profile_field_data( array(
	  			  		   		'field'   => $kino_fields['comp-direction-artistique'],
	  			  		   		'user_id' => $id
	  			  		   ) );
	  			  		   $kino_userdata["comp-hmc"] = bp_get_profile_field_data( array(
	  			  		    		'field'   => $kino_fields['comp-hmc'],
	  			  		    		'user_id' => $id
	  			  		    ) );
	  			  		  if ( ( !empty($kino_userdata["comp-direction-artistique"]) ) || ( !empty($kino_userdata["comp-hmc"]) ) ) {
	  			  		  	kino_add_to_comp( $id, $kino_fields['group-comp-da-hmc'] );
	  			  		  	$message .= ' / Added user '.$username.' ('.$id.') to group Direction artistique & HMC.';
	  			  		  } 
	  			  	}
	  			  	
	  			  	// 6. Autres talents
							if ( !in_array( $id, $ids_comp_autres ) ) {
								  $kino_userdata["comp-autres-liste"] = bp_get_profile_field_data( array(
								   		'field'   => $kino_fields['comp-autres-liste'],
								   		'user_id' => $id
								   ) );
								   $kino_userdata["comp-autres-champ"] = bp_get_profile_field_data( array(
								    		'field'   => $kino_fields['comp-autres-champ'],
								    		'user_id' => $id
								    ) );
								  if ( ( !empty($kino_userdata["comp-autres-liste"]) ) || ( !empty($kino_userdata["comp-autres-champ"]) ) ) {
								  	kino_add_to_comp( $id, $kino_fields['group-comp-autres'] );
								  	$message .= ' / Added user '.$username.' ('.$id.') to group Autres Talents.';
								  } 
							}

	  			  } // end if value == Artisan/Technicien
	  			} // end foreach
	  			
	  		} // end testing kino16_particiation_boxes
	  		
	  		// Staff
	  		if ( !in_array( $id, $ids_staff ) ) {
	  			
	  			$kino_userdata["fonctions-staff"] = bp_get_profile_field_data( array(
	  			 		'field'   => $kino_fields['fonctions-staff'],
	  			 		'user_id' => $id
	  			 ) );
	  			 if ( !empty( $kino_userdata["fonctions-staff"] ) ) {
	  			 	kino_add_to_comp( $id, $kino_fields['group-comp-staff'] );
	  			 	$message .= ' / Added user '.$username.' ('.$id.') to group Staff.';
	  			 }
	  			 
	  		}
	  		
	  	} // end foreach $user
		} // 
	}
	
	
	$host = $_SERVER['HTTP_HOST'];
	
	if ( $host == 'kinogeneva.ch' ) {
			
			$to[] = 'ms@ms-studio.net';
			$to[] = 'onvafairedesfilms@kinogeneva.ch';
			$headers[] = 'From: KinoGeneva <onvafairedesfilms@kinogeneva.ch>';
			$subject = '[Kino] SuperMoulinette de '.date('H\hi');
			
			wp_mail( 
				$to,
				$subject,
				$message, 
				$headers 
			);
	
	}
	
} // end super_moulinette