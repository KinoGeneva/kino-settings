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
        
        - Total of users
        
        - in group: Kinogeneva 2016 (pending)
        
        - in group: real.plateforme (pending)
        
        - in group: real.kino (pending)
        
        ****/
        	
        $kino_debug_mode = 'off';
        
        $url = site_url();
        
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
        
        // Kinoites qui cherchent un logement
        $kinoites_cherchent_logement = array();
        
        // Kinoites qui offrent un logement
        $kinoites_offrent_logement = array();
        
        $kino_fields = kino_test_fields();
        
        
        //***************************************
        
        // Quel est le total d'utilisateurs?
        
        // echo '<p>Total des utilisateurs sur la plateforme: '.count($user_query->results).'</p>';
        
        if ( ! empty( $user_query->results ) ) {
        	foreach ( $user_query->results as $user ) {
        		
        		// infos about WP_user object
        		$kino_userid = $user->ID ;
        		
        		$kinoite_cherche_logement = bp_get_profile_field_data( array(
        					'field'   => $kino_fields["cherche-logement"],
        					'user_id' => $kino_userid
        			) );
        		if (	$kinoite_cherche_logement == 'OUI' ) {
        			// add info to array 
        			// echo ' '.$kinoite_cherche_logement.' ';
        			
        			$kinoites_cherchent_logement[] = array( 
        				"user-id" => $kino_userid,
        				"user-name" => $user->display_name,
        				"user-slug" => $user->user_nicename,
        				"user-email" => $user->user_email,
        				"cherche-logement-remarque" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields['cherche-logement-remarque'],
        						'user_id' => $kino_userid
        				) ),
        				"ville" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["ville"],
        						'user_id' => $kino_userid
        				) ),
        				"pays" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["pays"],
        						'user_id' => $kino_userid
        				) ),
        				"tel" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["tel"],
        						'user_id' => $kino_userid
        				) ),
        			);
        		} // end testing recherche de logement
        		
        		// test : offre logement
        		$kinoite_offre_logement = bp_get_profile_field_data( array(
        					'field'   => $kino_fields["offre-logement"],
        					'user_id' => $kino_userid
        			) );
        		if (	$kinoite_offre_logement == 'OUI' ) {
        			// add info to array 
        			// echo ' '.$kinoite_cherche_logement.' ';
        			
        			$kinoites_offrent_logement[] = array( 
        				"user-id" => $kino_userid,
        				"user-name" => $user->display_name,
        				"user-slug" => $user->user_nicename,
        				"user-email" => $user->user_email,
        				"offre-logement-remarque" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields['offre-logement-remarque'],
        						'user_id' => $kino_userid
        				) ),
        				"ville" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["ville"],
        						'user_id' => $kino_userid
        				) ),
        				"pays" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["pays"],
        						'user_id' => $kino_userid
        				) ),
        				"tel" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["tel"],
        						'user_id' => $kino_userid
        				) ),
        				"rue" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["rue"],
        						'user_id' => $kino_userid
        				) ),
        				"code-postal" => bp_get_profile_field_data( array(
        						'field'   => $kino_fields["code-postal"],
        						'user_id' => $kino_userid
        				) ),
        				
        			);
        		} // end testing: offre de logement
        		
        	} // End foreach
        } // End testing User_Query
        	
        
        
        // Kinoïtes qui cherchent un logement:
        if ( !empty($kinoites_cherchent_logement) ) {
        	echo '<h2>Kinoïtes qui cherchent un logement ('.count($kinoites_cherchent_logement).'):</h2>';
        	
        	?>
        	<table class="table table-hover table-bordered">
        		<thead>
        			<tr>
        				<th>#</th>
        				<th>Nom</th>
        				<th>Adresse</th>
        		    <th>Email</th>
        		    <th>Tel.</th>
        		    <th>Remarque</th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php
        			$metronom = 1;
        			
        			foreach ($kinoites_cherchent_logement as $key => $item) {
        					?>
        					<tr>
        						<th><?php echo $metronom++; ?></th>
        						<?php 
        								echo '<td><a href="'.$url.'/members/'.$item["user-slug"].'/" target="_blank">'.$item["user-name"].'</a></td>';
        								echo '<td>'.$item["ville"].', ';
        								echo $item["pays"].'</td>';
        						?><td><a href="mailto:<?php echo $item["user-email"] ?>?Subject=Kino%20Kabaret" target="_top"><?php echo $item["user-email"] ?></a></td>
        							<td><?php echo $item["tel"] ?></td>
        							<td><?php 
	        						if ( !empty($item["cherche-logement-remarque"]) ) {
	        							echo $item["cherche-logement-remarque"];
	        						}
	        						echo '</td>';
        					echo '</tr>'; 
        			} // end foreach
        	echo '</tbody></table>';
        }
        
        // Les logements existants:
        // **********************************
        
        $kino_logements_dispo = array();
        $kino_logements_occup = array();
        $kino_logements_total = 0;
        
        // obtenir les termes de la taxonomie user-logement
        // get terms of taxonomy : 
        
        $args = array(
            'orderby'                => 'name',
            'order'                  => 'ASC',
            'hide_empty'             => false,
            // 'meta_query'             => ''
        ); 
        $kino_logements = get_terms('user-logement', $args);
        
        if ( !empty($kino_logements) && !is_wp_error( $kino_logements ) ) {
        		
        		$kino_logements_total = count($kino_logements);
//        	echo '<pre>';
//        	var_dump($kino_logements);
//        	echo '</pre>';
        	
        	/*
        	 * Valeurs disponibles: 
        	  - term_id
        	  - name
        	  - slug
        	  - term_taxonomy_id
        	  - description
        	*/
        	
        	foreach ( $kino_logements as $logement ) {
        	   
        	   // Init
        	   $nombre_couchages = 0;
        	   $nombre_occupants = 0;
        	   $ids_occupants = array();
        	   $liste_occupants = array();
        	   
        	   // Nombre de places dispo: 
        	   
        	   $nombre_couchages = get_metadata( 
	        	   	'term', 
	        	   	$logement->term_id, 
	        	   	'kino_nombre_couchages', 
	        	   	true );
        	   
        	   // Nombre de places occupées: 
        	   // trouver les objets liés à ce terme!
        	   $ids_occupants = get_objects_in_term( 
        	   	$logement->term_id , 
        	   	'user-logement' 
        	   );
        	   
        	   if ( !empty($ids_occupants) ) {
        	   	
		        	   	/*
		        	   	 * Liste des occupants */
		        	   	
		        	   	$user_fields = array( 
		        	   		'user_login', 
		        	   		'user_nicename',  // = slug
		        	   		'display_name',
		        	   		'user_email', 
		        	   		'ID' 
		        	   	);
		        	   	
		        	   	$user_query = new WP_User_Query( array( 
		        	   		'include' => $ids_occupants, // IDs incluses
		        	   		'meta_key'  => 'last_name',
		        	   		'orderby'  => 'last_name',
		        	   	) );
		        	   	
		        	   	$nombre_occupants = count($user_query->results);
		        	   	$liste_occupants = array();
		        	   	
		        	   	if ( ! empty( $user_query->results ) ) {
		        	   		foreach ( $user_query->results as $user ) {
		        	   			// name and edit link:
		        	   			// http://kinogeneva.4o4.ch/wp-admin/user-edit.php?user_id=243&wp_http_referer=%2Fwp-admin%2Fusers.php
		        	   			$liste_occupants[] = '<a href="'.$url.'/wp-admin/user-edit.php?user_id='.$user->ID.'#user-logement">'.$user->display_name.'</a>';
		        	   			
		        	   		} // end foreach
		        	   	} // end if empty $user_query
        	   	
        	   }
        	   // end if empty $ids_occupants
        	   
        	   // Générer les données
        	   
        	   /* si le nombre de places occupées >= places dispo 
        	   	= ajouter aux logements occupés
        	   	= sinon = ajouter aux logements disponibles
        	   */ 
        	   
        	   if ( $nombre_occupants >= $nombre_couchages ) {
        	   	// ajouter aux logements occupés
        	   		$kino_logements_occup[] = array( 
        	   			"id" => $logement->term_id,
        	   			"name" => $logement->name,
        	   			"remarques" => $logement->description,
        	   			"couchages" => $nombre_couchages,
        	   			"occupants" => $ids_occupants,
        	   			"nombre-occupants" => $nombre_occupants,
        	   			"liste-occupants" => $liste_occupants,
        	   		);
        	   } else {
        	   	// ajouter aux logements disponibles
        	   				$kino_logements_dispo[] = array( 
        	   					"id" => $logement->term_id,
        	   					"name" => $logement->name,
        	   					"remarques" => $logement->description,
        	   					"couchages" => $nombre_couchages,
        	   					"occupants" => $ids_occupants,
        	   					"nombre-occupants" => $nombre_occupants,
        	   					"liste-occupants" => $liste_occupants,
        	   				);
        	   				
        	   } // if/else
        	   
        	 } // foreach	
        }
        // Fin du test logements
        
        // Logements dispo: Générer le tableau
        // $kino_logements_dispo = array();
        if ( !empty($kino_logements_dispo) ) {
        	echo '<h2>Logements disponibles ('.count($kino_logements_dispo).' / '.$kino_logements_total.'):</h2>';
        	
        	?>
        	<table class="table table-hover table-bordered">
        		<thead>
          		<tr>
          			<th>#</th>
          			<th>Nom</th>
          			<th>Description</th>
        		    <th>Nombre couchages</th>
        		    <th>Kinoïtes logés</th>
          		</tr>
          	</thead>
          	<tbody>
        		<?php
        				$metronom = 1;
        				foreach ($kino_logements_dispo as $key => $item) {
        						?>
        						<tr>
        							<th><?php echo $metronom++; ?></th>
        							<?php 
        							// Nom et lien
        									echo '<td><a href="'.$url.'/wp-admin/edit-tags.php?action=edit&taxonomy=user-logement&tag_ID='.$item["id"].'" target="_blank">'.$item["name"].'</a></td>';
											// Description
        							?><td><?php echo $item["remarques"] ?></td>
        							<?php 
        							// Nombre couchages
        							 ?><td><?php echo $item["couchages"] ?></td>
        							 <?php 
        							 // Occupants
        							  ?>
        							<td><?php 
        							if ( !empty($item["liste-occupants"]) ) {
        								//
        								foreach ( $item["liste-occupants"] as $occupant ) {
        									echo '<span class="liste-occupants">'.$occupant.' </span>';
        								}
        							}
        							echo '</td>';
        					echo '</tr>';
        				} // end foreach
        		echo '</tbody></table>';
        }
        // Fin logements dispo
        
        // Logements occupés: Générer le tableau
        // $kino_logements_occup = array();
        if ( !empty($kino_logements_occup) ) {
        	echo '<h2>Logements occupés ('.count($kino_logements_occup).' / '.$kino_logements_total.'):</h2>';
        	
        	?>
        	<table class="table table-hover table-bordered">
        		<thead>
          		<tr>
          			<th>#</th>
          			<th>Nom</th>
          			<th>Description</th>
        		    <th>Nombre couchages</th>
        		    <th>Kinoïtes logés</th>
          		</tr>
          	</thead>
          	<tbody>
        		<?php
        				$metronom = 1;
        				foreach ($kino_logements_occup as $key => $item) {
        						?>
        						<tr>
        							<th><?php echo $metronom++; ?></th>
        							<?php 
        							// Nom et lien
        									echo '<td><a href="'.$url.'/wp-admin/edit-tags.php?action=edit&taxonomy=user-logement&tag_ID='.$item["id"].'" target="_blank">'.$item["name"].'</a></td>';
        							// Description
        							?><td><?php echo $item["remarques"] ?></td>
        							<?php 
        							// Nombre couchages
        							 ?><td><?php echo $item["couchages"] ?></td>
        							 <?php 
        							 // Occupants
        							  ?>
        							<td><?php 
        							if ( !empty($item["liste-occupants"]) ) {
        								//
        								echo $item["nombre-occupants"].': ';
        								foreach ( $item["liste-occupants"] as $occupant ) {
        									echo '<span class="liste-occupants">'.$occupant.'</span>';
        								}
        							}
        							echo '</td>';
        					echo '</tr>';
        				} // end foreach
        		echo '</tbody></table>';
        }
        // Fin logements dispo
        
        // Kinoïtes qui offrent un logement:
        if ( !empty($kinoites_offrent_logement) ) {
        	echo '<h2>Kinoïtes qui offrent un logement ('.count($kinoites_offrent_logement).'):</h2>';
        	
        	?>
        	<table class="table table-hover table-bordered">
        		<thead>
	        		<tr>
	        			<th>#</th>
	        			<th>Nom</th>
	        			<th>Adresse</th>
	    			    <th>Email</th>
	    			    <th>Tel.</th>
	    			    <th>Nombre et type</th>
	        		</tr>
	        	</thead>
	        	<tbody>
        		<?php
        		
        				$metronom = 1;
        		
        				foreach ($kinoites_offrent_logement as $key => $item) {
        						?>
        						<tr>
        							<th><?php echo $metronom++; ?></th>
        							<?php 
        									echo '<td><a href="'.$url.'/members/'.$item["user-slug"].'/" target="_blank">'.$item["user-name"].'</a></td>';
        									echo '<td>'.$item["rue"].', '.$item["code-postal"].' '.$item["ville"].', '.$item["pays"].'</td>';
        							?><td><a href="mailto:<?php echo $item["user-email"] ?>?Subject=Kino%20Kabaret" target="_top"><?php echo $item["user-email"] ?></a></td>
        							<td><?php echo $item["tel"] ?></td>
        							<td><?php 
        							if ( !empty($item["offre-logement-remarque"]) ) {
        								echo $item["offre-logement-remarque"];
        							}
        							echo '</td>';
        					echo '</tr>';
        				} // end foreach
        		echo '</tbody></table>';
        }
        
                
         ?>
        
    </div><!--end article-content-->

    <?php  ?>
</article>
<!-- End  Article -->