<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
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
         * Liste: Réalisateurs Plate-forme Kino : à valider
        *******/
        
        /**
         * Get users by BuddyPress xprofile data.
         *
         * @author J.D. Grimes <jdg@codesymphony.co>
         *
         * @param int    $field_id The ID of the field to search in.
         * @param string $value    The value to search for.
         * 
         * @return int[] The IDs of the users matching the search.
         */
 				
 				$kino_debug_mode = 'off';
        
        $user_fields = array( 
        	'user_login', 
        	'user_nicename', 
        	'display_name',
        	'user_email', 
        	'ID' 
        );
        
        $user_query = new WP_User_Query( array( 
        	'fields' => $user_fields 
        ) );
        
//        echo '<pre>';
//        var_dump($user_query);
//        echo '</pre>';

				// Réalisateur-trice en attente : Kabaret 2016
				$kino_pending_real_kab = array();
				
				// Réalisateur-trice en attente : Plateforme
				$kino_pending_real_platform = array();
				
				// Réalisateur-trice validé : Kabaret 2016
				$kino_valid_real_kab = array();
				
				// Réalisateur-trice validé : Plateforme
				$kino_valid_real_platform = array();
				
				$kino_fields = kino_test_fields();
				
//				echo '<pre>';
//				echo 'array of kino_test_fields()';
//				var_dump($kino_fields);
//				echo '</pre>';

				// START DEBUGGING
				// *******************
				
				// ['group-real-kabaret']
				
				// test also: real-kabaret-pending = ['group-real-kabaret-pending']
				
				echo '<p>for debugging, show list of IDs in term '.$kino_fields['group-real-kabaret-pending'].':</p>';
				
				$ids_of_real_valid_kab = get_objects_in_term( $kino_fields['group-real-kabaret'] , 'user-group' );
				
				echo '<pre>';
				echo 'list of IDs in "group-real-kabaret"';
					var_dump($ids_of_real_valid_kab);
				echo '</pre>';
				
				// END DEBUGGING
				// *******************
								
				// User Loop
				if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {
						
						// infos about WP_user object
						
						$kino_userid = $user->ID ;
						echo ' '.$kino_userid.' ';
						
						// $kino_user_facts = kino_user_participation( $user->ID );
						// = très lourd à faire sur l'ensemble des utilisateurs... environ 5000 queries!
						
						// is Valid Réal for Kabaret 2016?
						// ********************************
						// method = test user-group
						
						// START DEBUGGING
						// *******************
	
						// test if $kino_userid is in $ids_of_real_valid_kab
						
						if ( in_array( $kino_userid, $ids_of_real_valid_kab ) ) {
						    // echo '<p>with in_array(), user '.$user->user_login.' / '.$kino_userid.' is <b>approved</b> : Réalisateurs Kino 2016</p>';
						    echo '<p>according to in_array(), user '.$user->ID.' belongs to group X.</p>';
						}
						
						// END DEBUGGING
						// *******************
						
						if( has_term( 
							$kino_fields['group-real-kabaret'],  // term ID to check for !!
							'user-group', // taxonomy name
							$kino_userid ) // post to check
						) {
						    
						    // START DEBUGGING
						    // *******************
						    
						    // echo '<p>with has_term(), user '.$user->user_login.' / '.$kino_userid.' is <b>approved</b> : Réalisateurs Kino 2016</p>';
						    echo '<p>according to has_term(), user '.$user->ID.' belongs to group X.</p>';
						    
						    // END DEBUGGING
						    // *******************
						    
						    // Add user info to array:
						    $kino_valid_real_kab[] = array( 
						        	"user-id" => $kino_userid,
						        	"user-name" => $user->display_name,
						        	"user-slug" => $user->user_nicename,
						        	// "title" => get_the_title(),
						        	// "permalink" => get_permalink(),
						     );
						     
						} else {
						
							// else :
							// is "Pending Réal" for Kabaret 2016?
							// ********************************
							// method = test xprofile field
							
							// Test des rôles pour le Kabaret 2016
							$kino16_particiation_boxes = bp_get_profile_field_data( array(
									'field'   => $kino_fields['role-kabaret'],
									'user_id' => $kino_userid
							) );
							// test field 135 = participation en tant que
							if ($kino16_particiation_boxes) {
								foreach ($kino16_particiation_boxes as $key => $value) {
								
									$value = mb_substr($value, 0, 4);
								
								  if ( $value == "Réal" ) {
								  	// echo '<p>user '.$user->user_login.' has requested : Réalisateurs Kino 2016</p>';
								  	
								  	// on peut 
								  	
								  	// Add user info to array:
								  	$kino_pending_real_kab[] = array( 
								  	    	"user-id" => $kino_userid,
								  	    	"user-name" => $user->display_name,
								  	    	"user-slug" => $user->user_nicename,
								  	    	"user-email" => $user->user_email,
								  	    	"user-presentation" => bp_get_profile_field_data( array(
								  	    			'field'   => $kino_fields['profil-real-complete'],
								  	    			'user_id' => $kino_userid
								  	    	) ),
								  	    	// "title" => get_the_title(),
								  	    	// "permalink" => get_permalink(),
								  	 );
								  	
								  }
								  
								} // end foreach
							} // end ELSE (kabaret 2016 test)
						
						
						}
						
						
						
						// is Valid Réal for Plateforme Kino?
						// ********************************
						// method = test user-group
						
						// else :
						// is Pending Réal for Plateforme Kino?
						// ********************************
						// method = test xprofile field
						
						// echo '<p>' . $user->user_login . '</p>';
					}
				} 
				
				
				// STEP 2: We have built our arrays - now we produce the output:
				
				
				// for $kino_pending_real_kab[]
				
				if (!empty($kino_pending_real_kab) ) {
						
						echo '<div>';
						echo '<h2>Réalisateurs-trices en attente : Kabaret 2016</h2>';
				
						foreach ($kino_pending_real_kab as $key => $item) {
						
								?>
								<div class="alert alert-warning">
									<?php 
											echo '<b>Nom:</b> ';
											echo $kino_pending_real_kab[$key]["user-name"];
									?> <br/><b>Email:</b> <a href="mailto:<?php echo $kino_pending_real_kab[$key]["user-email"] ?>?Subject=Kino%20Kabaret" target="_top"><?php echo $kino_pending_real_kab[$key]["user-email"] ?></a>
									
									<br/><b>Présentation:</b> <?php echo $kino_pending_real_kab[$key]["user-presentation"] ?>
								<br/>
								
								<p>Is user <?php echo $kino_pending_real_kab[$key]["user-id"] ?> in the group "profile-complete"? Let's test:</p>
								
								<?php 
									
									if( has_term( 
											$kino_fields['group-real-valid-kabaret'],  // ['group-real-valid-kabaret']
											'user-group', 
											$kino_pending_real_kab[$key]["user-id"] ) 
										) { 
													echo '<p>Yes: for user Nr '.$kino_pending_real_kab[$key]["user-id"].', has_term returns TRUE</p>';
										} else {
										
											echo '<p>No: for user Nr '.$kino_pending_real_kab[$key]["user-id"].', has_term returns FALSE</p>';
										}
								
								?>
								
								<a href="//kinogeneva.ch/members/<?php echo $kino_pending_real_kab[$key]["user-slug"]; ?>/profile/" target="_blank" class="btn btn-default">Voir le profil complet</a> 
								
								<a href="//kinogeneva.ch/wp-admin/user-edit.php?user_id=<?php echo $kino_pending_real_kab[$key]["user-id"] ?>#user-group" target="_blank" class="btn btn-default">Modifier groupes</a>
								<?php 
								/*
							*	<form id='useraction-id  echo $kino_pending_real_kab[$key]["user-id"] 
							* ' action='#' method='GET' class="hidden">
							*							    <input type='submit' name="action" value='Approuver' class="btn btn-success">
							*								    <input type='submit' name="action" value='Refuser' class="btn btn-danger">
							*								</form>
							*/
								 ?>
								</div>
							<?php 
						}
						echo '</div>';
				} // end looping array
				
				
				// for $kino_valid_real_kab[]
				
				if (!empty($kino_valid_real_kab) ) {
						
						echo '<div>';
						echo '<h2>Réalisateurs-trices validés : Kabaret 2016</h2>';
				
						foreach ($kino_valid_real_kab as $key => $item) {
						
								?>
								<p class="alert alert-success">
									<?php 
											echo 'Nom: ';
									?>
									<a href="//kinogeneva.ch/members/<?php echo $kino_valid_real_kab[$key]["user-slug"]; ?>/profile/"><?php 
											echo $kino_valid_real_kab[$key]["user-name"];
									?></a>
								</p>
								
								<p>Is user <?php echo $kino_pending_real_kab[$key]["user-id"] ?> in the group "group-real-valid-kabaret"? Let's test:</p>
								<?php 
									
									if( has_term( 
											$kino_fields['group-real-valid-kabaret'],  // ['group-real-valid-kabaret']
											'user-group', 
											$kino_valid_real_kab[$key]["user-id"] ) 
										) { 
													echo '<p>Yes: for user Nr '.$kino_valid_real_kab[$key]["user-id"].', has_term returns TRUE</p>';
										} else {
										
											echo '<p>No: for user Nr '.$kino_valid_real_kab[$key]["user-id"].', has_term returns FALSE</p>';
										}
								
								?>
								
								<p>Is user <?php echo $kino_pending_real_kab[$key]["user-id"] ?> in the group "group-group-kino-complete"? Let's test:</p>
								<?php 
									
									if( has_term( 
											$kino_fields['group-kino-complete'],  // ['group-real-valid-kabaret']
											'user-group', 
											$kino_valid_real_kab[$key]["user-id"] ) 
										) { 
													echo '<p>Yes: for user Nr '.$kino_valid_real_kab[$key]["user-id"].', has_term returns TRUE</p>';
										} else {
										
											echo '<p>No: for user Nr '.$kino_valid_real_kab[$key]["user-id"].', has_term returns FALSE</p>';
										}
								
								?>
								
							<?php 
						}
						echo '</div>';
				} // end looping array
     ?>
        
    </div><!--end article-content-->

    <?php  ?>
</article>
<!-- End  Article -->

