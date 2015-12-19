<?php

  		?>
  		<tr>
  			<th><?php echo $metronom++; ?></th>
  			<?php 
  			
  					// $kino_user_role = kino_user_participation( $user->ID, $kino_fields );
  					
  					// user ID
  					echo '<td>'.$user->ID.'</td>';
  					
  					// $user->ID
  					echo '<td><a href="'.$url.'/members/'.$user->user_nicename.'/" target="_blank">'.$user->user_login.'</a> ('.$user->display_name.')</td>';
  					
  					// Email
  			echo '<td><a href="mailto:'. $user->user_email .'?Subject=Kino%20Kabaret" target="_top">'. $user->user_email .'</a></td>';
  					
      			$kino_user_role = kino_user_participation( 
      				$user->ID, 
      				$kino_fields
      			);
      			
      			// Participe commme Réal Plateforme ?	
      			// ********************
      			
      			if ( in_array( "real-platform-valid", $kino_user_role ) ) {          				            				
    				  echo '<td class="success">Approved</td>';
    				
    				} else if ( in_array( "real-platform-rejected", $kino_user_role ) ) {
    				
    				  echo '<td class="error">Rejected</td>';
    				
    				} else if ( in_array( "real-platform-pending", $kino_user_role ) ) {
    				
    					echo '<td class="warning">Pending</td>';
    				
    				} else {

    					echo '<td></td>';
    				}
      			            			
      			// Participe commme Réal Kab ?
      			// ********************
      			
      			// Test if : 
      				
    				if ( in_array( "real-2016-valid", $kino_user_role ) ) {          				            				
    				  echo '<td class="success">Approved</td>';
    				
    				} else if ( in_array( "real-2016-rejected", $kino_user_role ) ) {
    				
    				  echo '<td class="error">Rejected</td>';
    				
    				} else if ( in_array( "real-2016-pending", $kino_user_role ) ) {
    				
    					echo '<td class="warning">Pending</td>';
    				
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
      			  echo '<td class="success">OUI</td>';
      			} else {
      				echo '<td></td>';	
      			}
      			
      			// Registration date
      			$shortdate = substr( $user->user_registered, 0, 10 );
      			echo '<td>'. $shortdate .'</td>';
  			
  		echo '</tr>';
  		

