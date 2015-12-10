<?php 


function kino_user_participation( $userid, $kino_fields ) {
	
			// 
			
			if ( empty( $userid ) ) {
				$userid = bp_loggedin_user_id();
			}
			
			if ( empty( $kino_fields ) ) {
				$kino_fields = kino_test_fields();
			}
			
			$kino_user_participation = array();
			
			
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

// This functions returns a very complete array of fields

function kino_user_fields( $kino_userid, $kino_fields ) {
	
	if ( empty( $kino_userid ) ) {
		$kino_userid = bp_loggedin_user_id();
	}
	
	if ( empty( $kino_fields ) ) {
		$kino_fields = kino_test_fields();
	}
	
	$kino_userdata = array();
	
	$kino_userdata['participation'] = kino_user_participation( 
		$kino_userid, 
		$kino_fields
	);
	
	// Define our fields
	// Ville, Pays
	
	$kino_userdata["ville"] = bp_get_profile_field_data( array(
			'field'   => $kino_fields["ville"],
			'user_id' => $kino_userid
	) );
	$kino_userdata["pays"] = bp_get_profile_field_data( array(
			'field'   => $kino_fields["pays"],
			'user_id' => $kino_userid
	) );
	$kino_userdata["birthday"] = bp_get_profile_field_data( array(
			'field'   => $kino_fields["birthday"],
			'user_id' => $kino_userid
	) );
	
	// Method to find age in years...
	 // Simple method:
	 $kino_birthyear = substr($kino_userdata["birthday"], -4);
	 $kino_userdata["userage"] = 2015 - $kino_birthyear;
	
	// Sessions
	
	$kino_userdata["sessions"] = bp_get_profile_field_data( array(
	 		'field'   => $kino_fields['session-attribuee'],
	 		'user_id' => $kino_userid
	 ) );
	 
	 // Disponibilité
	  
	  $kino_userdata["dispo"] = bp_get_profile_field_data( array(
	   		'field'   => $kino_fields['dispo'],
	   		'user_id' => $kino_userid
	   ) );
	   
	   $kino_userdata["dispo-partiel"] = bp_get_profile_field_data( array(
	     		'field'   => $kino_fields['dispo-partiel'],
	     		'user_id' => $kino_userid
	     ) );
	  
	  // Présentation
	  
	  $kino_userdata["presentation"] = bp_get_profile_field_data( array(
	  		'field'   => $kino_fields['id-presentation'],
	  		'user_id' => $kino_userid
	  ) );
	  
	  $kino_userdata["photo"] = bp_get_profile_field_data( array(
	   		'field'   => $kino_fields['id-photo'],
	   		'user_id' => $kino_userid
	   ) );
	  
	  // Role Technicien ??
	  
	  $kino_userdata["role-tech"] = bp_get_profile_field_data( array(
	   		'field'   => $kino_fields['role-kabaret-tech'],
	   		'user_id' => $kino_userid
	   ) );
	   
	   $kino_userdata["comp-production"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-production'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-scenario"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-scenario'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-realisation"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-realisation'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-image"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-image'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-postprod-image"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-postprod-image'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-son"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-son'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-postprod-son"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-postprod-son'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-direction-artistique"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-direction-artistique'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-hmc"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-hmc'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-autres-liste"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-autres-liste'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["comp-autres-champ"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['comp-autres-champ'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["equipement"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['equipement'],
	    		'user_id' => $kino_userid
	    ) );
	   $kino_userdata["equipement-spec"] = bp_get_profile_field_data( array(
	    		'field'   => $kino_fields['equipement-spec'],
	    		'user_id' => $kino_userid
	    ) );
	   
	  // Role Comédien ??
	  
	  $kino_userdata["role-comed"] = bp_get_profile_field_data( array(
	     		'field'   => $kino_fields['role-kabaret-comed'],
	     		'user_id' => $kino_userid
	   ) );
	   
	  // Role Réalisateur ??
	   
	   $kino_userdata["role-real"] = bp_get_profile_field_data( array(
	      		'field'   => $kino_fields['role-kabaret-real'],
	      		'user_id' => $kino_userid
	    ) );
	 
	
	return $kino_userdata;
	
}
