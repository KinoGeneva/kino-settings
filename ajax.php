<?php 

// Code from: 
// http://wordpress.stackexchange.com/questions/212212/how-to-create-a-form-button-that-executes-a-function/
// kindly provided by Jesse Graupmann - https://github.com/jgraup

add_action('init', function () {

    // Register AJAX handlers

    add_action('wp_ajax_set_kino_state', 'set_kino_state');
    add_action('wp_ajax_nopriv_set_kino_state', 'set_kino_state');

    // AJAX handler (PRIV / NO PRIV)

    function set_kino_state()
    {
        if( empty ($_POST['action']) || $_POST['action'] !== 'set_kino_state') {
            if (!empty ($fail_message)) {
                wp_send_json_error(array(
                    'message' => "Sorry!"
                )); // die
            }
        }

        $id = $_POST['id'];
        $state = $_POST['state'];
        $kino_fields = kino_test_fields();
        
        if ( !empty($state) ) {

        		if ( ( $state == 'platform-accept' ) || ( $state == 'platform-reject') || ( $state == 'platform-cancel') ) {
        		
        			// remove from : platform pending
        			
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-real-platform-pending'] );
        			
        			// remove from mailpoet list:
        			
//        			kino_remove_from_mailpoet_list( $id,
//        				$kino_fields['mailpoet-real-platform-only'] );
        		
        		}
        		
        		if ( $state == 'platform-accept' ) {
        		
        			// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-platform'] );
        				
        			// Add to Mailpoet List
//        			kino_add_to_mailpoet_list( $id, 
//        				$kino_fields['mailpoet-real-platform'] );
        			
        			// add checkbox!
        			kino_check_real_platform_checkbox( $id, $kino_fields );
        			
        		}
        		
        		if ( $state == 'platform-cancel' ) {
        			
        			// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-platform-canceled'] );
        			
        			// Add to Mailpoet List
//        			kino_add_to_mailpoet_list( $id, 
//        				$kino_fields['mailpoet-real-platform-canceled'] );
        			
        			// remove checkbox!
        			kino_remove_real_platform_checkbox( $id, $kino_fields );
        			
        		}
        		
        		if ( $state == 'platform-reject' ) {
        			
        			// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-platform-rejected'] );
        			
        			// Add to Mailpoet List
//        			kino_add_to_mailpoet_list( $id, 
//        				$kino_fields['mailpoet-real-platform-rejected'] );
        			
        			// remove checkbox!
        			kino_remove_real_platform_checkbox( $id, $kino_fields );
        			
        		}
        		
        		// ******************
        		
        		if ( ( $state == 'kabaret-accept' ) || ( $state == 'kabaret-reject' ) || ( $state == 'kabaret-cancel') || ( $state == 'kabaret-moyen') || ( $state == 'kabaret-bien') ) {
        		
        			// remove from pending
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-real-kabaret-pending'] );
        				
//        			kino_remove_from_mailpoet_list( $id,
//        				$kino_fields['mailpoet-real-platform-only'] );
        		
        		}
        		
        		if ( ( $state == 'kabaret-accept' ) ) {
        			
        			// remove from groups
        			
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-candidats-vus-moyens'] );
        				
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-candidats-vus-biens'] );
        				
//        			kino_remove_from_mailpoet_list( $id,
//        				$kino_fields['mailpoet-real-kabaret-pending'] );
        				
        			// add to groups
        			
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-kabaret'] );
        				
//        			kino_add_to_mailpoet_list( $id, 
//        				$kino_fields['mailpoet-real-kabaret'] );
        				
        			// s'assurer que le champ Réalisateur Kabaret est coché
        			kino_check_real_kabaret_checkbox( $id, $kino_fields );
        		
        		} else if ( $state == 'kabaret-cancel') {
        		
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-kabaret-canceled'] );
        				
//        			kino_add_to_mailpoet_list( $id, 
//        				$kino_fields['mailpoet-real-kabaret-canceled'] );
        			
//        			kino_remove_from_mailpoet_list( $id,
//        				$kino_fields['mailpoet-real-kabaret-pending'] );
        			
        			// décocher le champ Réalisateur Kabaret!
        			kino_remove_real_kabaret_checkbox( $id, $kino_fields );
        			
        				
        		} else if ( $state == 'kabaret-reject') {
        		
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-kabaret-rejected'] );
        				
//        			kino_add_to_mailpoet_list( $id, 
//        				$kino_fields['mailpoet-real-kabaret-rejected'] );
        			
//        			kino_remove_from_mailpoet_list( $id,
//        				$kino_fields['mailpoet-real-kabaret-pending'] );
        			
        			// décocher le champ Réalisateur Kabaret!
        			kino_remove_real_kabaret_checkbox( $id, $kino_fields );
        			
        		} // END else/if
        		
        		if ( $state == 'kabaret-moyen' ) {
        		        			
	        			kino_add_to_usergroup( $id, 
	        				$kino_fields['group-candidats-vus-moyens'] );
	        			// s'assurer que le champ Réalisateur Kabaret est coché
	        			kino_check_real_kabaret_checkbox( $id, $kino_fields );

        		}
        		
        		if ( $state == 'kabaret-bien' ) {
        		        			
        				kino_add_to_usergroup( $id, 
        					$kino_fields['group-candidats-vus-biens'] );
        					
        				// s'assurer que le champ Réalisateur Kabaret est coché
        				kino_check_real_kabaret_checkbox( $id, $kino_fields );
   		
        		}
        		
        		// ACTIONS Payment
        		
        		if ( $state == 'payment-25' ) {
        			kino_add_to_compta( $id, 
        				$kino_fields['compta-paid-25'] );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de 25.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		if ( $state == 'payment-100' ) {
        			kino_add_to_compta( $id, 
        				$kino_fields['compta-paid-100'] );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de 100.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		if ( $state == 'payment-reset' ) {
        			kino_remove_from_compta( $id, 
        				$kino_fields['compta-paid-25'] );
        			kino_remove_from_compta( $id, 
        				$kino_fields['compta-paid-100'] );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement annulé pour '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		if ( $state == 'repas-60' ) {
        			kino_add_to_compta( $id, 
        				$kino_fields['compta-repas-60'] );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement pour Carte Repas de 60.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		if ( $state == 'repas-100' ) {
        			kino_add_to_compta( $id, 
        				$kino_fields['compta-repas-100'] );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement pour Carte Repas de 100.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		if ( $state == 'repas-reset' ) {
        			kino_remove_from_compta( $id, 
        				$kino_fields['compta-repas-60'] );
        			kino_remove_from_compta( $id, 
        				$kino_fields['compta-repas-100'] );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de Carte Repas annulé pour '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		if (!empty($message_compta)) {
        			
        			// $message_compta .= '<p>Date de la transaction: '.date('H:i:s').'.</p>';
        			
        			$to[] = 'compta@kinogeneva.ch';
        			// $to[] = 'ms@ms-studio.net';
        			$headers[] = 'From: KinoGeneva <onvafairedesfilms@kinogeneva.ch>';
        			$subject = '[KinoGeneva] transaction pour '.$userdata->user_login.' ('.$id.')';
        			
        				wp_mail( 
        					$to,
        					$subject,
        					$message_compta, 
        					$headers 
        				);
        		
        		}
        		
        } // end !empty($state)

        wp_send_json_success(array(
            'action' => $_POST['action'],
            'message' => 'State Was Set To ' . $state,
            'state' => $state,
            'ID' => $id
        )); // die
    } // end function set_real_kabaret_state()
    
});


function kino_remove_real_kabaret_checkbox( $id, $kino_fields ) {

		// A: get the field
		$kino_participation_xfield = bp_get_profile_field_data( array(
			'field'   => $kino_fields['role-kabaret'],
			'user_id' => $id
		) );
		
		if (!empty($kino_participation_xfield)) {
		
				// B: remove 'Réalisateur-trice' from array	      						
				$del_val = 'Réalisateur-trice';
				if(($key = array_search($del_val, $kino_participation_xfield)) !== false) {
				    unset($kino_participation_xfield[$key]);
				}
				
				// C: save the user data
				xprofile_set_field_data(  
					$kino_fields['role-kabaret'],  
					$id,  
					$kino_participation_xfield
					);
		
		} // test if !empty $kino_participation_xfield
	
}

function kino_remove_real_platform_checkbox( $id, $kino_fields ) {

		// A: get the field
		$kino_participation_xfield = bp_get_profile_field_data( array(
			'field'   => $kino_fields['profile-role'],
			'user_id' => $id
		) );
		
		if (!empty($kino_participation_xfield)) {
		
				// B: remove 'Réalisateur-trice' from array	      						
				$del_val = 'Réalisateur-trice';
				if ( ($key = array_search($del_val, $kino_participation_xfield) ) !== false) {
				    unset($kino_participation_xfield[$key]);
				}
				
				// C: save the user data
				xprofile_set_field_data(  
					$kino_fields['profile-role'],  
					$id,  
					$kino_participation_xfield
					);
		
		} // test if !empty $kino_participation_xfield
	
}

function kino_check_real_platform_checkbox( $id, $kino_fields ) {

		// A: get the field
		$kino_participation_xfield = bp_get_profile_field_data( array(
			'field'   => $kino_fields['profile-role'],
			'user_id' => $id
		) );

				// B: add 'Réalisateur-trice' to array	      						
				$del_val = 'Réalisateur-trice';
				if ( !in_array( $del_val, $kino_participation_xfield )) {
				    $kino_participation_xfield[] = $del_val;
				}
				
				// C: save the user data
				xprofile_set_field_data(  
					$kino_fields['profile-role'],  
					$id, $kino_participation_xfield );
	
}

function kino_check_real_kabaret_checkbox( $id, $kino_fields ) {

		// A: get the field
		$kino_participation_xfield = bp_get_profile_field_data( array(
			'field'   => $kino_fields['role-kabaret'],
			'user_id' => $id
		) );

				// B: add 'Réalisateur-trice' to array	      						
				$del_val = 'Réalisateur-trice';
				if ( !in_array( $del_val, $kino_participation_xfield )) {
				    $kino_participation_xfield[] = $del_val;
				}
				
				// C: save the user data
				xprofile_set_field_data(  
					$kino_fields['role-kabaret'],  
					$id, $kino_participation_xfield );
	
}



function kino_table_header( $validation, $tableid = null ) {
	
		if (!empty($tableid)) {
			$tableid = 'id="'.$tableid.'"';
		}
	
		$kino_table_header = '<table '.$tableid.' class="table table-hover table-bordered table-condensed pending-form">
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Nom/Email</th>
						<th>Rôle Kabaret</th>
				    <th>Réal Plateforme</th>
				    <th>Réal Kabaret</th>
				    <th>Profil</th>
				    <th>Enregistrement</th>';
		
		if ( $validation == 'true' ) {
		
			$kino_table_header .= '<th class="validation">Validation</th>';
		
		} else if ( $validation == 'plateforme' ) {
		
			$kino_table_header .= '<th class="validation">Validation Plateforme</th>';
		
		} else if ( $validation == 'kabaret' || $validation == 'kabaret-plus' ) {
		
			$kino_table_header .= '<th class="validation">Validation Kabaret</th>';
		
		}
				
		$kino_table_header .= '</tr>
					</thead>
					<tbody>';
		
		return $kino_table_header;
		
}

