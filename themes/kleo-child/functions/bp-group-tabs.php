<?php  


/* modify form action = jump to next item in list */

function kino_the_profile_group_edit_form_action() {
	echo kino_get_the_profile_group_edit_form_action();
}

function kino_get_the_profile_group_edit_form_action() {
		global $group;

		$bp = buddypress();
		
		$groups = bp_profile_get_field_groups();
		
		// figure out ID of current group
		$current_group_id = $group->id;
		
		// give a fallback value
		$next_group_id = $current_group_id;
		
		$count = count( $groups );
		
		for ( $i = 0, $count; $i < $count; ++$i ) {
			if ( $current_group_id == $groups[ $i ]->id ) {
			
					$j = $i+1;
					if ( $j < $count) { 
						$next_group_id = '/edit/group/' . $groups[ $j ]->id .'/';
					} else {
					
					// $next_group_id = '/change-avatar/'; 
					// NOTE = problem, submissions don't get changed!
						
						$next_group_id = '/edit/group/' . $next_group_id .'/';
						
					}
				
			} // end if.
		} // end for.
		
		/**
		 * Filters the action for the profile group edit form.
		 *
		 * @since BuddyPress (1.1.0)
		 *
		 * @param string $value URL for the action attribute on the
		 *                      profile group edit form.
		 */
		 
		 $kino_form_action = bp_displayed_user_domain() . $bp->profile->slug . $next_group_id ;
		 
		 // (could add #buddypress to jump in place)
				 
		return apply_filters( 'bp_get_the_profile_group_edit_form_action', $kino_form_action );
}


function kino_user_participation() {
	
			// 
			
			$kino_user_participation = array();
			
			
			// is Comédien? // is Realisateur? // is Technicien?
			$kino_particiation_boxes = bp_get_profile_field_data( array(
					'field'   => '135',
					'user_id' => bp_loggedin_user_id()
			) );
			if ($kino_particiation_boxes) {
				foreach ($kino_particiation_boxes as $key => $value) {
					
					$value = mb_substr($value, 0, 4);
				  
				  if ( $value == "Réal" ) {
				  	$kino_user_participation[] = "realisateur";
				  }
				  if ( $value == "Comé" ) {
				  	$kino_user_participation[] = "comedien";
				  }
				  if ( $value == "Arti" ) {
				  	$kino_user_participation[] = "technicien";
				  }
				  
				} // end foreach
			} // end testing field #135
			
			
			// Participe au cabaret 2016?
			$kino_particip_kabaret_seize = bp_get_profile_field_data( array(
					'field'   => '100', 
					'user_id' => bp_loggedin_user_id()
			) );
			
			if ( ( $kino_particip_kabaret_seize == "oui" ) || ( $kino_particip_kabaret_seize == "yes" ) ) {
						$kino_user_participation[] = "kabaret-2016";
			}
			
			// Bénévole?
			$kino_aide_benevole = bp_get_profile_field_data( array(
					'field'   => '1313', 
					'user_id' => bp_loggedin_user_id()
			) );
			
			if ( ( $kino_aide_benevole == "oui" ) || ( $kino_aide_benevole == "yes" ) ) {
						$kino_user_participation[] = "benevole";
			}
			
			// Test benevole pour le Kabaret 2016
			$kino_benevole_boxes = bp_get_profile_field_data( array(
					'field'   => '1320',
					'user_id' => bp_loggedin_user_id()
			) );
			if ($kino_benevole_boxes) {
				foreach ($kino_benevole_boxes as $key => $value) {
				  if ( $value == "l’organisation du Kino Kabaret" ) {
				  	$kino_user_participation[] = "benevole-kabaret";
				  }
				} // end foreach
			} //
			
			
			
			// Test des rôles pour le Kabaret 2016
			$kino16_particiation_boxes = bp_get_profile_field_data( array(
					'field'   => '1258',
					'user_id' => bp_loggedin_user_id()
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
			
			
			// test if ID is complete
			$kino_id_field = bp_get_profile_field_data( array(
					'field'   => '31', // = Présentation
					'user_id' => bp_loggedin_user_id()
			) );
			
			if ($kino_id_field != "" ) {
					$kino_user_participation[] = "id-complete";
			}
			
			// Profil Realisateur complet? 
			$kino_profil_real = bp_get_profile_field_data( array(
					'field'   => '545', // trouver ID du champ!
					'user_id' => bp_loggedin_user_id()
			) );
			if ( $kino_profil_real != "" ) {
					$kino_user_participation[] = "realisateur-complete";
			}
			
			// Profil Comédien complet? 
			$kino_profil_comedien = bp_get_profile_field_data( array(
					'field'   => '927', // trouver ID du champ!
					'user_id' => bp_loggedin_user_id()
			) );
			if ( $kino_profil_comedien ) {
					$kino_user_participation[] = "comedien-complete";
			}
			
			// Profil Technicien complet? 
			$kino_profil_tech = bp_get_profile_field_data( array(
					'field'   => '1075', // trouver ID du champ!
					'user_id' => bp_loggedin_user_id()
			) );
			if ( $kino_profil_tech ) {
					$kino_user_participation[] = "technicien-complete";
			}
			
			
			// Test avatar
			// src: https://buddypress.org/support/topic/detecting-if-user-uploaded-an-avatar/
			
			$kino_avatar = bp_core_fetch_avatar( array( 
				'item_id' => $user->ID, 
				'no_grav' => true, 
				'html'=>false) );
			
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
			- avatar-complete
			
			*/
			
}



/* Decide what groups are visible, or hidden 
****************************** */

add_filter( 'bp_profile_get_field_groups', 'kino_get_field_group_conditions', 10 );

function kino_get_field_group_conditions( $groups ){

  // $groups = array();
  // $number_of_groups = count( $groups );
  
//  	$kino_role = bp_get_profile_field_data( array(
//  		'field'   => '1',
//  		'user_id' => bp_loggedin_user_id()
//  	) );
		
		$forbidden_groups = array(
			"5.a Inscription Kabaret",
			"5.b Kabaret suite",
		);
  	
  	// champs à tester:
  	
  	$kino_user_role = kino_user_participation();

  	
  	if (!in_array( "realisateur", $kino_user_role )) {
  		$forbidden_groups[] = "Compétence Réalisateur";
  	}
  	
  	if (!in_array( "comedien", $kino_user_role )) {
  		$forbidden_groups[] = "Compétence Comédien";
  	}
  	
  	if (!in_array( "technicien", $kino_user_role )) {
  		$forbidden_groups[] = "Compétence Technicien";
  	}
  	
  	if (!in_array( "benevole", $kino_user_role )) {
  		$forbidden_groups[] = "Aide bénévole";
  	}
  	
  	if (!in_array( "kabaret-2016", $kino_user_role )) {
  		// bénévole pour kabaret ? 
  		if (!in_array( "benevole-kabaret", $kino_user_role )) {
  			$forbidden_groups[] = "Kino Kabaret 2016";
  		}
  	}
  	
  	$forbidden_group_ids = array(
  		// 7, // Technicien = 7
  		// 9, // Kabaret = 9
  		// 12, // Kabaret = 12
  	);
  	
  	$groups_updated = array();
  
  	for ( $i = 0, $count = count( $groups ); $i < $count; ++$i ) {
			
			$group_name = $groups[ $i ]->name;
			$group_id= $groups[ $i ]->id;
			
			// hide forbidden groups
			if (in_array( $group_name, $forbidden_groups)) {
				// Do Nothing = group is hidden
			} else {
				// Add to array
				$groups_updated[] = $groups[ $i ];
			}
			
  	} // end for loop.
  	
  return $groups_updated;
}



/* Prevent links on profile page
************************************ */

function remove_xprofile_links() {
    remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
}
add_action( 'bp_init', 'remove_xprofile_links', 20 );
// source: https://codex.buddypress.org/themes/bp-custom-php/




//