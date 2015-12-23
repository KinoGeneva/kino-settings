<?php

  		?>
  		<tr class="pending-candidate" data-id="<?php echo $user->ID; ?>">
  			<th><?php echo $metronom++; ?></th>
  			<?php 
  			
  					// $kino_user_role = kino_user_participation( $user->ID, $kino_fields );
  					
  					// user ID
  					echo '<td>'.$user->ID.'</td>';
  					
  					// Nom 
  					
  					echo '<td>';
  					echo '<a href="'.$url.'/members/'.$user->user_nicename.'/" target="_blank">';
  					
  					if ( empty($user->display_name) ) {
  						echo $user->user_nicename;
  					} else {
  						echo $user->display_name;
  					}

  					echo '</a>';
  					
  					// Email
  			echo ' — <a href="mailto:'. $user->user_email .'?Subject=Kino%20Kabaret" target="_top">'. $user->user_email .'</a></td>';
  					
      			$kino_user_role = kino_user_participation( 
      				$user->ID, 
      				$kino_fields
      			);
      			
      			// Rôles Kino
      			// ******************
      			
      			echo '<td>'; 
      			
      				// Réalisateur ?
      				if ( in_array( "realisateur-2016", $kino_user_role )) {
      					echo '<span class="kp-pointlist">Réalisateur-trice</span>';
      				}
      				// Technicien ?
      				if ( in_array( "technicien-2016", $kino_user_role )) {
      					echo '<span class="kp-pointlist">Artisan-ne / technicien-ne</span>';
      				}
      				// Comédien ?
      				if ( in_array( "comedien-2016", $kino_user_role )) {
      					echo '<span class="kp-pointlist">Comédien-ne</span>';
      				}
      				
      				if ( $user->ID == 231 ) {
      				
//      				echo '<pre>';
//      				var_dump($kino_user_role);
//      				echo '</pre>';

//									kino_add_to_mailpoet_list( 
//										$id, 
//										$kino_fields['mailpoet-real-kabaret'] 
//									);
									
//									$helper_user = WYSIJA::get('user','helper');
//									
//									$mail_lists = array($kino_fields['mailpoet-real-kabaret']);
									
//									$kino_user_subscribe = $helper_user->addToLists(
//									    $mail_lists,
//									    $user->ID
//									 );

//									$helper_user->addToList(
//									    $kino_fields['mailpoet-real-kabaret'],
//									    array($user->ID)
//									 );
									 
									 // echo "subscribed = " . ( $kino_user_subscribe ? "true" : "false" );      					
      				}
      				
      			echo '</td>';
      				
      			
      			// Participe commme Réal Plateforme ?	
      			// ********************
      			
      			if ( in_array( "real-platform-valid", $kino_user_role ) ) {          				            				
    				  echo '<td class="success">Accepté</td>';
    				
    				} else if ( in_array( "real-platform-rejected", $kino_user_role ) ) {
    				
    				  echo '<td class="danger">Refusé</td>';
    				  
    				  // add users to mailpoet list:
//    				   	kino_add_to_mailpoet_list( $user->ID, 
//    				   		$kino_fields['mailpoet-real-platform-rejected'] 
//    				   	);
    				
    				} else if ( in_array( "real-platform-pending", $kino_user_role ) ) {
    				
    					echo '<td class="warning">En attente</td>';
    				
    				} else {

    					echo '<td></td>';
    				}
      			            			
      			// Participe commme Réal Kab ?
      			// ********************
      			
      			// Test if : 
      				
    				if ( in_array( "real-kab-valid", $kino_user_role ) ) {          				            				
    				  echo '<td class="success">Accepté</td>';
    				
    				} else if ( in_array( "real-kab-rejected", $kino_user_role ) ) {
    				
    				  echo '<td class="danger">Refusé</td>';
    				
    				} else if ( in_array( "real-kab-pending", $kino_user_role ) ) {
    				
    					echo '<td class="warning">En attente</td>';
    				
    				} else {

    					echo '<td></td>';
    				}
      			
      			// Profil complet ?	
      			// ********************
      			
      			$ids_of_kino_complete = get_objects_in_term( 
      				$kino_fields['group-kino-complete'] , 
      				'user-group' 
      			);
      			
      			if ( in_array( $user->ID, $ids_of_kino_complete ) ) {          				            				
      			  echo '<td class="success">Complet</td>';
      			} else {
      				echo '<td></td>';	
      			}
      			
      			// Registration date
      			$shortdate = substr( $user->user_registered, 0, 10 );
      			echo '<td>'. $shortdate .'</td>';
      			
      			// Actions
      			
      				if ( $kino_show_validation == 'kabaret' ) {
      			 
      			 		echo '<td>';
      			 		echo '<a class="admin-action pending-accept kino-accept" data-action="kabaret-accept">accepter</a>';
      			 		echo '<a class="admin-action pending-reject kino-accept" data-action="kabaret-reject">refuser</a>'; 
      			 		echo '</td>'; 
      			 		
      			 } else if ( $kino_show_validation == 'plateforme' ) {
      			 
      			 		echo '<td>';
      			 		echo '<a class="admin-action pending-accept kino-accept" data-action="platform-accept">accepter</a>';
      			 		
      			 		echo '<a class="admin-action pending-reject kino-reject" data-action="platform-reject">refuser</a>';
      			 		echo '</td>'; 
      			 
      			 }
      			 			
  		echo '</tr>';
  		

