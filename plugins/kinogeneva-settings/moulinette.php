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


if ( !wp_next_scheduled( 'kino_moulinette_competences_kab_hook' ) ) {

  wp_schedule_event( 
  	strtotime('00:33:00'), 
  	'hourly', // daily hourly
  	'kino_moulinette_competences_kab_hook' 
  );

  // note: wp_schedule_event should always take GMT!
  // donc si on veut l'envoi à 17:30, il faut mettre 16:30
}

add_action( 'kino_moulinette_competences_kab_hook', 'kino_moulinette_competences_kab' );

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