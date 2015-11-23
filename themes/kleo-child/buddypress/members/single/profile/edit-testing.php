<?php 
	
	// Test Area, only seen by admins.
	
	//						$kino_role = bp_get_profile_field_data( array(
	//								'field'   => '100',
	//								'user_id' => bp_loggedin_user_id()
	//							) );
	//						echo '<pre>';
	//						var_dump($kino_role);
	//						echo '</pre>';
	
				// echo '<p>group id: '.bp_get_current_profile_group_id().'</p>';

?><?php
	
//	$userIDs = get_objects_in_term( 65, 'user-group');
//	
//	foreach ($userIDs as $k => $id) {
//		// echo 'id = '.$id;
//	  $user_info = get_user_by( 'id', $id );
//	  // echo $user_info->user_email;
//	 }
			
			
 
 			$kino_user_role = kino_user_participation( bp_loggedin_user_id() );
 			
 				// candidat cabaret 2016?
// 				$kino_seize_particiation_roles = bp_get_profile_field_data( array(
// 						'field'   => '1258',
// 						'user_id' => bp_loggedin_user_id()
// 				) );
// 				
// 				echo '<pre>';
// 				var_dump($kino_seize_particiation_roles);
// 				echo '</pre>';
 				
 				$kino_candidate_message = "";
 				
 				if (in_array( "kabaret-2016", $kino_user_role )) {
 				
 					$kino_candidate_message .= 'Votre inscription au Kino Kabaret est bien prise en compte. ';
 					
 					// real aussi pour cabaret?
 					
 					if (in_array( "realisateur-2016", $kino_user_role )) {
 								
 								// oui!
 								$kino_candidate_message .= 'Votre candidature en tant que réalisateur-trice est soumise au comité de sélection et vous serez notifié-e par e-mail des résultats. ';
 						}
 					
 				} else {
 				
 					if (in_array( "realisateur", $kino_user_role )) {
 							
 							$kino_candidate_message .= 'Vous serez contacté-e prochainement concernant votre demande de statut de réalisateur-trice sur cette plateforme. ';
 							
 							// real aussi pour cabaret?
 							
 							
 						}
 						
 				}
 				
				if ( $kino_candidate_message != '' ) {
				
					// echo '<p class="alert alert-success">'.$kino_candidate_message.'</p>';
					
				} 
								
				// Test Avatar
				
				if (in_array( "id-complete", $kino_user_role )) {
					
					if (in_array( "avatar-complete", $kino_user_role )) {
								
					} else {
							
							echo '<p class="alert alert-danger">Vous n’avez pas fourni d’avatar — merci de <a href="'.bp_core_get_user_domain( bp_loggedin_user_id() ).'profile/edit/group/10/" class="alert-link">choisir une photo avatar</a> pour compléter votre profil.</p>';
					}
				
				} else {
				
				// ID incomplete!
				
					echo '<p class="alert alert-danger">Votre profil est incomplet, merci de <a href="'.bp_core_get_user_domain( bp_loggedin_user_id() ).'profile/change-avatar/" class="alert-link">compléter tous les champs obligatoires</a>.</p>';
					
				}
				
				
 
 ?>
 
<?php 
 // end of file
?>