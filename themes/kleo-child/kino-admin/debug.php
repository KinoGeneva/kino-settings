<?php
/**
 * Un template pour valider les inscriptions
 */
?>

<?php
$extra_classes = 'clearfix';
if ( get_cfield( 'centered_text' ) == 1 )  {
    $extra_classes .= ' text-center';
}
?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class($extra_classes); ?>>

    <div class="article-content">
        <?php the_content(); ?>
        
        <?php 
        
        /*
         * On teste TOUS les membres du site
        ***************
        ****/
        	
        $kino_debug_mode = 'on';
        
        $url = site_url();
        
        $kino_fields = kino_test_fields();
        
        // Kinoites qui cherchent un logement
        $kinoites_benevoles = array();
        
        $ids_of_kino_complete = get_objects_in_term( 
        	$kino_fields['group-kino-complete'] , 
        	'user-group' 
        );
        
        $ids_of_kino_participants = get_objects_in_term( 
        	$kino_fields['group-kino-pending'] , 
        	'user-group' 
        );

				// enlever les champs zéro: 
				$ids_of_kino_complete = array_filter($ids_of_kino_complete);
        
        echo '<p>Profil complet: '.count($ids_of_kino_complete).'</p>';
        
        // user query 1
        //***************************************
        
	        $user_query = new WP_User_Query( array( 
	        	// 'include' => $ids_of_benevoles, // IDs incluses
//	        	'orderby' => 'name',
//	        	'order' => 'ASC' 
	        	'orderby' => 'registered',
	        	'order' => 'DESC'
	        ) );
	        
	        echo '<p>Nombre de membres: '.count($user_query->results).'</p>';
        
        	// add to mailpoet
        	
        	// Add to Mailpoet List
//        	kino_add_to_mailpoet_list_array( 
//        		$ids_of_benevoles, 
//        		$kino_fields['mailpoet-benevoles'] 
//        	);
        
        // Function to generate users
        // kino_user_fields_logement()
        // in : bp-user-fields.php
        
        $metronom = 1;
        
        if ( ! empty( $user_query->results ) ) {
        	foreach ( $user_query->results as $user ) {
        		
        		// infos about WP_user object
        		$userid = $user->ID ;
        		
        		// étape 1: tester si le champ Participation Kino est coché!
        		
        		// Participe au cabaret 2016?
        		$kino_test = bp_get_profile_field_data( array(
        				'field'   => $kino_fields['kabaret'], 
        				'user_id' => $userid
        		) );
        		if ( ( $kino_test == "oui" ) || ( $kino_test == "yes" ) ) {
        					
        					echo ' / '.$metronom++;
        					echo ' : '.$userid;
        					
        					if ( in_array( $userid, $ids_of_kino_participants ) ) {          				            				
        					  echo ' ok ';
        					} else {
        						echo ' PROBLEM! ';
        						
        						// add to group
        						 kino_add_to_usergroup( $userid, 
        						 	$kino_fields['group-kino-pending'] );
        						 	
        					}
        					
        					// Ajouter au groupe "group-kino-pending"
        					
        					
        						
        					// Add to Mailpoet List
//        					kino_add_to_mailpoet_list( $id, 
//        						$kino_fields['mailpoet-real-platform'] );
        					
        					// Profil Cabaret 2016 complet? 
        					
        					
        		}
        		
        		// $kinoite_participation = kino_user_participation( $kino_userid, $kino_fields );
        	
        	} // End foreach
        } // End testing user_query_cherche	
        
        
        // ***********************************
        
        if ( !empty($kinoites_kabaret_complet) ) {
        	echo '<h2>Participants au <a href="'.$url.'/wp-admin/users.php?user-group=benevoles-kabaret">profil complet</a> ('.count($kinoites_kabaret_complet).'):</h2>';
        	
        	echo '<p>Liste des kinoïtes bénévoles ayant coché "l’organisation du Kino Kabaret".';
        	
        	?>
        	<table class="table table-hover table-bordered table-condensed">
        		<thead>
          		<tr>
          			<th>#</th>
          			<th>Nom</th>
          			<th>Real?</th>
          			<th>Rôle Kabaret</th>
          			<th>Fonction?</th>
          			<th>Choix admin</th>
          		</tr>
          	</thead>
          	<tbody>
        		<?php
        		
        				$metronom = 1;
        		
        				foreach ($kinoites_kabaret_complet as $key => $item) {
        				
        						?>
        						<tr>
        							<th><?php echo $metronom++; ?></th>
        							<?php 
        							
        							// Nom
        							echo '<td><a href="'.$url.'/members/'.$item["user-slug"].'/" target="_blank">';
        							
        							if ( empty($item["user-name"]) ) {
        								echo $item["user-slug"];
        							} else {
        								echo $item["user-name"];
        							}
        							
        							echo '</a> - <a href="mailto:'. $item["user-email"] .'?Subject=Kino%20Kabaret" target="_top">'. $item["user-email"] .'</a></td>';
        							
        							// Real?
        							// ******************
        							  							  								
				  								if ( in_array( "real-kab-valid", $item["participation"] ) ) {          				            				
				          				  echo '<td class="success">Approved</td>';
				          				
				          				} else if ( in_array( "real-kab-rejected", $item["participation"] ) ) {
				          				
				          				  echo '<td class="error">Rejected</td>';
				          				
				          				} else if ( in_array( "real-kab-pending", $item["participation"] ) ) {
				          				
				          					echo '<td class="warning">Pending</td>';
				          				
				          				} else {
				
				          					echo '<td></td>';
				  								}
        							
        							
        							// Rôles Kino
        							// ******************
        							
        							echo '<td>'; 
        							
        								// Réalisateur ?
        								if ( in_array( "realisateur-2016", $item["participation"] )) {
        									echo '<span class="kp-pointlist">Réalisateur-trice</span>';
        								}
        								// Technicien ?
        								if ( in_array( "technicien-2016", $item["participation"] )) {
        									echo '<span class="kp-pointlist">Artisan-ne / technicien-ne</span>';
        								}
        								// Comédien ?
        								if ( in_array( "comedien-2016", $item["participation"] )) {
        									echo '<span class="kp-pointlist">Comédien-ne</span>';
        								}
        								
        							echo '</td>';
        							
        							// ******************
        							
        							// Fonction
        							echo '<td>';
        							if ( $item["benevole-fonction"] ) {
        										foreach ( $item["benevole-fonction"] as $key => $value) {
        											echo '<span class="kp-pointlist">'.$value.'</span>';
        										}
        							}
        							echo '</td>';
        							
        							// Fonction
        							echo '<td>';
        							if ( $item["benevole-charge-admin"] ) {
        										foreach ( $item["benevole-charge-admin"] as $key => $value) {
        											echo '<span class="kp-pointlist">'.$value.'</span>';
        										}
        							}
        							echo '</td>';
        							
        							// ******************
        							
        									
        					echo '</tr>';
        					
        				} // end foreach
        		echo '</tbody></table>';
        }

        
        ?>
        
    </div><!--end article-content-->

    <?php  ?>
</article>
<!-- End  Article -->