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
         * Une page pour faciliter la gestion des inscriptions kino
        ***************
        
        ****/
        
        $kino_debug_mode = 'off';
        $url = site_url();
        $kino_fields = kino_test_fields();
        
        // On montre les membres faisant partie du groupe: 
        // Participants Kino 2016 : profil complet
        
        $ids_of_kino_complete = get_objects_in_term( 
        	$kino_fields['group-kino-complete'] , 
        	'user-group' 
        );
        
        echo '<h3>Total des participants au profil complet: '.count( $ids_of_kino_complete ) .'</h3>';
        
        echo '<p><b>Note: </b> Ce tableau liste tous les utilisateurs qui sont dans le groupe "Participants Kino 2016 : profil complet". Il n’inclut donc PAS les usagers ayant coché la participation, mais dont le profil n’est pas encore complet.</p>';
        	
        echo '<p><b>Voir aussi les <a href="'.$url.'/kino-admin/membres-hors-kabaret/">membres hors-Kabaret</a>.</b></p>';
        // Voir Participants Kabaret pour une vue plus détaillée	
        	
        $user_fields = array( 
        	'user_login', 
        	'user_nicename', // = slug
        	'display_name',
        	'user_email', 
        	'ID',
        	'registered', 
        );
        
        $user_query = new WP_User_Query( array( 
        	// 'fields' => $user_fields,
        	'include' => $ids_of_kino_complete,
        	'orderby' => 'registered',
        	'order' => 'DESC'
        ) );
        
        //***************************************
       
        if ( ! empty( $user_query->results ) ) {
        
        // Contenu du tableau
        	// Nom
        	// email
        	// Init:
        	$metronom = 1;
        	
        	?>
        	<table class="table table-hover table-bordered table-condensed">
        		<thead>
        			<tr>
        				<th>#</th>
        				<th>Nom/Email</th>
        		    <th>Rôle Kabaret</th>
        		    <th>Réal?</th>
        		    <th>Inscription</th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php
        
        	foreach ( $user_query->results as $user ) {
        		
        		?>
        		<tr>
        			<th><?php echo $metronom++; ?></th>
        			<?php 
        			
        					$kino_user_role = kino_user_participation( 
        						$user->ID, 
        						$kino_fields
        					);
        					
        					// Name
        					echo '<td>';
        					echo '<a href="'.$url.'/members/'.$user->user_nicename.'/" target="_blank">';
		        					if ( empty($user->display_name) ) {
		        						echo $user->user_nicename;
		        					} else {
		        						echo $user->display_name;
		        					}
        					echo '</a>';
        					
        					// Email
        			echo ' – <a href="mailto:'. $user->user_email .'?Subject=Kino%20Kabaret" target="_top">'. $user->user_email .'</a></td>';
        					
        					// Rôle Kino?
        					
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
        						
        					echo '</td>';
        					
            			            			
            			// Participe commme Réal ?
            			// ******************
            			
            			// Test if : 
            				
          				if ( in_array( "real-kab-valid", $kino_user_role ) ) {          				            				
          				  echo '<td class="success">Approved</td>';
          				
          				} else if ( in_array( "real-kab-rejected", $kino_user_role ) ) {
          				
          				  echo '<td class="error">Rejected</td>';
          				
          				} else if ( in_array( "real-kab-pending", $kino_user_role ) ) {
          				
          					echo '<td class="warning">Pending</td>';
          				
          				} else {

          					echo '<td></td>';
          				}
            			
            			
            			
            			// Registration date
            			$shortdate = substr( $user->user_registered, 0, 10 );
            			echo '<td>'. $shortdate .'</td>';
        			
        		echo '</tr>';
        		
        	}
        	
        	echo '</tbody></table>';
        }
        
         ?>
        
    </div><!--end article-content-->
  
    <?php  ?>
</article>
<!-- End  Article -->

