<?php 

function kino_test_fields() {

	// Permet de définir les numéros de champs xprofile à tester 
	// dans un unique endroit!

	$kino_fields = array();
	
	
	$kino_fields['profile-role'] = 135; // Profil Kinoite Role
	$kino_fields['kabaret'] = 100; // Participe au cabaret 2016?
	$kino_fields['role-kabaret'] = 1258; // Test des rôles pour le Kabaret 2016
	
	// Les trois options des rôles pour le Kabaret 2016
	$kino_fields['role-kabaret-comed'] = '1458_0';
	$kino_fields['role-kabaret-tech'] = '1459_1';
	$kino_fields['role-kabaret-real'] = '1460_2';
	
	// Les champs Choix de Session pour le Kabaret 2016
	$kino_fields['session-un'] = 1101;
	$kino_fields['session-deux'] = 1106;
	$kino_fields['session-trois'] = 1116;
	
	$kino_fields['benevole'] = 1313; // Aide Bénévole?
	$kino_fields['benevole-kabaret'] = 1320; // Aide benevole pour le Kabaret 2016
	
	$kino_fields['id-presentation'] = 31; // is ID complete? champ: Présentation
	$kino_fields['profil-real-complete'] = 545; // Profil Realisateur complet? champ: présentation
	$kino_fields['profil-comed-complete'] = 927;// Profil Comédien complet? 
	$kino_fields['profil-tech-complete'] = 1075;// Profil Technicien complet? 
	$kino_fields['profil-kabaret-complete'] = 1122;// test = Disponibilités cabaret 
	
	$kino_fields['session-attribuee'] = 1461;// Only visible for Admin 
	
	// Group IDs - 
	// voir https://bitbucket.org/ms-studio/kinogeneva/wiki/WordPress-User-Groups
	
	// En attente
	$kino_fields['group-real-kabaret-pending'] = 74 ; // En attente: Réalisateurs Kino Kabaret 2016
	$kino_fields['group-real-platform-pending'] = 77 ; // En attente: Réalisateurs Plateforme
	
	// Validés
	$kino_fields['group-real-kabaret'] = 65 ; // Validés: Réalisateurs Kino Kabaret
	$kino_fields['group-real-platform'] = 66 ; // Validés: Réalisateurs Plateforme
	$kino_fields['group-benevoles-kabaret'] = 67 ; // Bénévoles Kabaret
	
	// Refusés
	$kino_fields['group-real-kabaret-rejected'] = 69 ; // Refusés: Réalisateurs Kino Kabaret 2016
	$kino_fields['group-real-platform-rejected'] = 70 ; // Refusés: Réalisateurs Plateforme
	
	// Profil Kino
	$kino_fields['group-kino-incomplete'] = 72 ; // Participants Kino 2016 : profil incomplet
	$kino_fields['group-kino-complete'] = 71 ; // Participants Kino 2016 : profil complet
	$kino_fields['group-kino-approved'] = 73 ; // Participants Kino 2016 : validés
	
	
	
	return $kino_fields;
}



function kino_user_participation( $userid ) {
	
			// 
			
			if ( empty( $userid ) ) {
				$userid = bp_loggedin_user_id();
			}
			
			$kino_user_participation = array();
			
			$kino_fields = kino_test_fields();
			
			// is Comédien? // is Realisateur? // is Technicien?
			$kino_particiation_boxes = bp_get_profile_field_data( array(
					'field'   => $kino_fields['profile-role'],
					'user_id' => $userid
			) );
			if ($kino_particiation_boxes) {
				foreach ($kino_particiation_boxes as $key => $value) {
					
					$value = mb_substr($value, 0, 4);
				  
				  if ( $value == "Réal" ) {
				  	$kino_user_participation[] = "realisateur";
				  	
				  	
				  	// Profil Realisateur complet? 
				  	$kino_profil_real = bp_get_profile_field_data( array(
				  			'field'   => $kino_fields['profil-real-complete'],
				  			'user_id' => $userid
				  	) );
				  	if ( $kino_profil_real != "" ) {
				  			$kino_user_participation[] = "realisateur-complete";
				  	}
				  	
				  	
				  }
				  if ( $value == "Comé" ) {
				  	$kino_user_participation[] = "comedien";
				  	
				  	// Profil Comédien complet? 
				  	$kino_profil_comedien = bp_get_profile_field_data( array(
				  			'field'   => $kino_fields['profil-comed-complete'],
				  			'user_id' => $userid
				  	) );
				  	if ( $kino_profil_comedien ) {
				  			$kino_user_participation[] = "comedien-complete";
				  	}
				  	
				  }
				  if ( $value == "Arti" ) {
				  	$kino_user_participation[] = "technicien";
				  	
				  	// Profil Technicien complet? 
				  	$kino_profil_tech = bp_get_profile_field_data( array(
				  			'field'   => $kino_fields['profil-tech-complete'], // trouver ID du champ!
				  			'user_id' => $userid
				  	) );
				  	if ( $kino_profil_tech ) {
				  			$kino_user_participation[] = "technicien-complete";
				  	}
				  	
				  	
				  }
				  
				} // end foreach
			} // end testing field
			
			
			// Participe au cabaret 2016?
			$kino_test = bp_get_profile_field_data( array(
					'field'   => $kino_fields['kabaret'], 
					'user_id' => $userid
			) );
			if ( ( $kino_test == "oui" ) || ( $kino_test == "yes" ) ) {
						
						$kino_user_participation[] = "kabaret-2016";
						
						// Profil Cabaret 2016 complet? 
						
						$kino_dispo_kab = bp_get_profile_field_data( array(
								'field'   => $kino_fields['profil-kabaret-complete'], // trouver ID du champ!
								'user_id' => $userid
						) );
						if ( $kino_dispo_kab ) {
								$kino_user_participation[] = "kabaret-complete";
						}
						
			}
			
			// Aide Bénévole?
			$kino_aide_benevole = bp_get_profile_field_data( array(
					'field'   => $kino_fields['benevole'], 
					'user_id' => $userid
			) );
			if ( ( $kino_aide_benevole == "oui" ) || ( $kino_aide_benevole == "yes" ) ) {
						$kino_user_participation[] = "benevole";
			}
			
			// Aide benevole pour le Kabaret 2016
			$kino_benevole_boxes = bp_get_profile_field_data( array(
					'field'   => $kino_fields['benevole-kabaret'],
					'user_id' => $userid
			) );
			if ($kino_benevole_boxes) {
			
				$kino_user_participation[] = "benevole-complete";
				
				foreach ($kino_benevole_boxes as $key => $value) {
				  if ( $value == "l’organisation du Kino Kabaret" ) {
				  	$kino_user_participation[] = "benevole-kabaret";
				  }
				} // end foreach
			} //
			
			
			
			// Test des rôles pour le Kabaret 2016
			$kino16_particiation_boxes = bp_get_profile_field_data( array(
					'field'   => $kino_fields['role-kabaret'],
					'user_id' => $userid
			) );
			// test field 135 = participation en tant que
			if ($kino16_particiation_boxes) {
				foreach ($kino16_particiation_boxes as $key => $value) {
				
					$value = mb_substr($value, 0, 4);
				
				  if ( $value == "Réal" ) {
				  	$kino_user_participation[] = "realisateur-2016";
				  }
				  if ( $value == "Comé" ) {
				  	$kino_user_participation[] = "comedien-2016";
				  }
				  if ( $value == "Arti" ) {
				  	$kino_user_participation[] = "technicien-2016";
				  }
				} // end foreach
			} //
			
			
			// Is ID complete ?
			$kino_id_field = bp_get_profile_field_data( array(
					'field'   => $kino_fields['id-presentation'], // = Présentation
					'user_id' => $userid
			) );
			if ($kino_id_field != "" ) {
					$kino_user_participation[] = "id-complete";
			}
			
			
			
			
			
			
			// Test avatar
			// src: https://buddypress.org/support/topic/detecting-if-user-uploaded-an-avatar/
			
			$kino_avatar = bp_core_fetch_avatar( array( 
				'item_id' => $userid, 
				'no_grav' => true, 
				'html' => false) );
			
			if ( $kino_avatar == 'http://kinogeneva.ch/wp-content/plugins/buddypress/bp-core/images/mystery-man.jpg' ) {
				// no avatar
			} else {
				$kino_user_participation[] = "avatar-complete";
			}
			
			
			return $kino_user_participation;
			
			/*
			// au final, les valeurs retournées:

			- realisateur
			- technicien
			- comedien
			
			- realisateur-2016
			- technicien-2016
			- comedien-2016
			- kabaret-2016
			
			- id-complete
			- realisateur-complete
			- comedien-complete
			- technicien-complete
			- benevole-complete
			- avatar-complete
			
			*/
			
}

 ?>