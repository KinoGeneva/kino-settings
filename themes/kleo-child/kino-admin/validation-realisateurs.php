<?php
/**
 * Un template pour valider les réalisateurs
 */
?>

<?php
$extra_classes = 'clearfix';
if ( get_cfield( 'centered_text' ) == 1 )  {
    $extra_classes .= ' text-center';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($extra_classes); ?>>

    <div class="article-content">
        <?php the_content(); ?>
        
        <?php 
        
        /*
         * pour gérer le suivi dans l’immédiat ainsi que par la suite, il peut s’avérer pratique d’avoir une vue tabulaire de ces groupes (comme fait pour bénévoles, les participants, etc.) en séparant donc les trois groupes:
         
         “En attente: Réalisateurs Plateforme”
         
         “En attente: Réalisateurs Plateforme ONLY”
         
         “En attente: Réalisateurs Kino Kabaret 2016”
        
        ****/
        
        $kino_debug_mode = 'off';
        	
        $url = site_url();
        	
        $kino_fields = kino_test_fields();
        
        $ids_real_platform_pending = get_objects_in_term( 
        	$kino_fields['group-real-platform-pending'] , 
        	'user-group' 
        );
        
        $ids_real_kabaret_pending = get_objects_in_term( 
        	$kino_fields['group-real-kabaret-pending'] , 
        	'user-group' 
        );
        
        // remove user 0
//        wp_remove_object_terms( 
//        	0, 
//        	$kino_fields['group-real-kabaret-pending'], 
//        	'user-group' 
//        );
        
 				
 				$ids_real_both = array_intersect( $ids_real_platform_pending, $ids_real_kabaret_pending );
 				
 				$ids_platform_only = array_diff( $ids_real_platform_pending, $ids_real_kabaret_pending );
 					
 				$ids_kabaret_only = array_diff( $ids_real_kabaret_pending, $ids_real_platform_pending );
 				
 				echo '<p>Réalisateurs en attente <b>Plateforme</b>: '.count($ids_real_platform_pending).'</p>';
 				echo '<p>Réalisateurs en attente <b>Kabaret</b>: '.count($ids_real_kabaret_pending).'</p>';
 				echo '<p>Réalisateurs en attente <b>pour les deux</b>: '.count($ids_real_both).'</p>';
 				echo '<p>Réalisateurs en attente <b>Plateforme uniquement</b>: '.count($ids_platform_only).'</p>';
 				echo '<p>Réalisateurs en attente <b>Kabaret uniquement</b>: '.count($ids_kabaret_only).'</p>';
 				
 				
 				$kino_table_header = '<table class="table table-hover table-bordered table-condensed">
 					<thead>
 						<tr>
 							<th>#</th>
 							<th>ID</th>
 							<th>Nom</th>
 					    <th>Email</th>
 					    <th>Réal Plateforme?</th>
 					    <th>Réal Kab?</th>
 					    <th>Complet?</th>
 					    <th>Enregistrement</th>
 						</tr>
 					</thead>
 					<tbody>';
 				
 				
 				// array_diff(A,B) returns all elements from A, which are not elements of B (= A without B).
 				
 				//***************************************
        
        // 1) “En attente: Réalisateurs Plateforme”
        
        $user_fields = array( 
        	'user_login', 
        	'user_nicename', 
        	'display_name',
        	'user_email', 
        	'ID' 
        );
        
        $user_query = new WP_User_Query( array( 
        	// 'fields' => $user_fields
        	'include' => $ids_real_platform_pending, 
        	'orderby' => 'registered',
        	'order' => 'DESC'
        ) );
        
				//***************************************
								
				// User Loop
				if ( ! empty( $user_query->results ) ) {

				        	$metronom = 1;
				        	
				        	echo '<h2>En attente: Réalisateurs Plateforme ('.count($user_query->results).')</h2>';
				        	
				        	echo $kino_table_header;
				        
				        	foreach ( $user_query->results as $user ) {
				        		
				        		include('validation-real-loop.php');
				        		
				        	}
				        	echo '</tbody></table>';
				  }
				        
				 // End testing User_Query
				
				//***************************************
				
				// 2) “En attente: Réalisateurs Plateforme ONLY”
				
				$user_query = new WP_User_Query( array( 
					// 'fields' => $user_fields
					'include' => $ids_platform_only, 
					'orderby' => 'registered',
					'order' => 'DESC'
				) );
				
				// User Loop
				if ( ! empty( $user_query->results ) ) {

				        	$metronom = 1;
				        	
				        	echo '<h2>En attente: Réalisateurs Plateforme ONLY ('.count($user_query->results).')</h2>';
				        	
				        	echo $kino_table_header;
				        
				        	foreach ( $user_query->results as $user ) {
				        		
				        		include('validation-real-loop.php');
				        		
				        		
				        	}
				        	echo '</tbody></table>';
				        	
//				        	echo '<pre>';
//				        	var_dump($data_subscriber);
//				        	echo '</pre>';
				        	
				  }
				  
				  //***************************************
				  								
				  // 3) “En attente: Réalisateurs Kino Kabaret 2016”
				  
				  $user_query = new WP_User_Query( array( 
				  	// 'fields' => $user_fields
				  	'include' => $ids_real_kabaret_pending, 
				  	'orderby' => 'registered',
				  	'order' => 'DESC'
				  ) );
				  
				  // User Loop
				if ( ! empty( $user_query->results ) ) {

				        	$metronom = 1;
				        	
				        	echo '<h2>En attente: Réalisateurs Kino Kabaret 2016 ('.count($user_query->results).')</h2>';
				        	
				        	echo $kino_table_header;
				        
				        	foreach ( $user_query->results as $user ) {
				        		
				        		include('validation-real-loop.php');
				        		
				        	}
				        	echo '</tbody></table>';
				  }
				  
				  
				  //***************************************
				  								
				  // 4) “En attente: Réalisateurs Kino Kabaret 2016”
				  
				  if (!empty($ids_kabaret_only)) {
				  
					  $user_query = new WP_User_Query( array( 
					  				  	// 'fields' => $user_fields
					  	'include' => $ids_kabaret_only, 
					  	'orderby' => 'registered',
					  	'order' => 'DESC'
					  ) );
					
				  
						  // User Loop
						if ( ! empty( $user_query->results ) ) {
		
						        	$metronom = 1;
						        	
						        	echo '<h2>En attente: Réalisateurs Kino Kabaret ONLY ('.count($user_query->results).')</h2>';
						        	
						        	echo $kino_table_header;
						        
						        	foreach ( $user_query->results as $user ) {
						        		
						        		include('validation-real-loop.php');
						        		
						        	}
						        	echo '</tbody></table>';
						  }
				  
				  }
				  
				
     ?>
        
    </div><!--end article-content-->

    <?php  ?>
</article>
<!-- End  Article -->