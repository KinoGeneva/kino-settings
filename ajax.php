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
        if(isset($_POST['value'])){
			$value =  htmlspecialchars($_POST['value']);
		}
		else {
			$value = '';
		}
        $kino_fields = kino_test_fields();
        
        if ( !empty($state) ) {
			
				//note offre logement
				if( $state == 'offre-logement-add-info') {
					
					if(!empty( $old_value = get_user_meta( $id, 'kino-admin-offre-logement-remarque', true ) ) ){
						update_user_meta( $id, 'kino-admin-offre-logement-remarque', $old_value . '<br/>' . $value );
					}
					else {
						add_user_meta( $id, 'kino-admin-offre-logement-remarque', $value, true );
					}
				}
				//note cherche logement
				if( $state == 'cherche-logement-add-info') {
					
					if(!empty( $old_value = get_user_meta( $id, 'kino-admin-cherche-logement-remarque', true ) ) ){
						update_user_meta( $id, 'kino-admin-cherche-logement-remarque', $old_value . '<br/>' . $value );
					}
					else {
						add_user_meta( $id, 'kino-admin-cherche-logement-remarque', $value, true );
					}
				}
				//note bénévole
				if( $state == 'benevole-add-info') {
					
					if(!empty( $old_value = get_user_meta( $id, 'kino-admin-gestion-benevole-remarque', true ) ) ){
						update_user_meta( $id, 'kino-admin-gestion-benevole-remarque', $old_value . '<br/>' . $value );
						
					}
					else {
						add_user_meta( $id, 'kino-admin-gestion-benevole-remarque', $value, true );
					}
				}
				
				//réal plateforme
        		if ( ( $state == 'platform-accept' ) || ( $state == 'platform-reject') || ( $state == 'platform-cancel') ) {
        		
        			// remove from : platform pending
        			
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-real-platform-pending'] );
        			
        			//mailpoet
        			//pas de liste mailpoet pour les réal plateforme en attente
        		}
        		
        		if ( $state == 'platform-accept' ) {
        		
        			// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-platform'] );
        			
        			// mailpoet
					if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-real-platform'] 
						);					
					}

        			// add checkbox!
        			kino_check_real_platform_checkbox( $id, $kino_fields );        			
        		}
        		
        		if ( $state == 'platform-cancel' ) {
        			
        			// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-platform-canceled'] );
        			
        			// mailpoet
        			//pas de liste mailpoet pour les réal plateforme annulé
        			
        			// remove checkbox!
        			kino_remove_real_platform_checkbox( $id, $kino_fields );
        			
        		}
        		
        		if ( $state == 'platform-reject' ) {
        			
        			// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-platform-rejected'] );
        			
        			// mailpoet
					if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-real-platform-rejected'] 
						);					
					}
   			
        			// remove checkbox!
        			kino_remove_real_platform_checkbox( $id, $kino_fields );
        			
        		}
        		
        		// ******************
        		// réal Kabaret
        		
        		if ( ( $state == 'kabaret-accept' ) || ( $state == 'kabaret-reject' ) || ( $state == 'kabaret-cancel') || ( $state == 'kabaret-moyen') || ( $state == 'kabaret-bien') ) {
        		
        			// remove from pending
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-real-kabaret-pending'] );
        				
        			// mailpoet
        			if( $mailpoet_id = getMailpoetId( $id ) ) {				
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-real-kabaret-pending'] 
						);
					}
        		}
        	switch ( $state ) {
				case 'kabaret-session1' :
					// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-session-un'] );
        				
        			//remove from others groups
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-deux'] );
					kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-trois'] );
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-superhuit'] );
        			
        			// mailpoet
        			if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-1'] 
						);			
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-2'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-3'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-superhuit'] 
						);
					}
				break;
        		case 'kabaret-session2':
					// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-session-deux'] );
        			//remove from others groups
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-un'] );
					kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-trois'] );
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-superhuit'] );
        			// mailpoet
        			if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-2'] 
						);			
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-1'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-3'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-superhuit'] 
						);
					}
				break;
				case 'kabaret-session3':
					// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-session-trois'] );
        			//remove from others groups
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-un'] );
					kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-deux'] );
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-superhuit'] );
        			// mailpoet
        			if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-3'] 
						);			
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-1'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-2'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-superhuit'] 
						);
					}
				break;
				case 'kabaret-sessions8' :
					// add to group
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-session-superhuit'] );
        			//remove from others groups
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-un'] );
					kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-deux'] );
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-trois'] );
        			// mailpoet
        			if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-superhuit'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-1'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-2'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-3'] 
						);
					}
				break;
        		
        		case 'kabaret-accept' :
        			
        			// remove from groups

        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-candidats-vus-moyens'] );
        				
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-candidats-vus-biens'] );
        			
        			// add to groups
        			
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-kabaret'] );
        			
        			// mailpoet
        			
        			if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-real-kabaret'] 
						);
					}

        			// s'assurer que le champ Réalisateur Kabaret est coché
        			kino_check_real_kabaret_checkbox( $id, $kino_fields );
        		break;
	
        		case 'kabaret-cancel':
        		
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-kabaret-canceled'] );
        				
        			// décocher le champ Réalisateur Kabaret!
        			kino_remove_real_kabaret_checkbox( $id, $kino_fields );
        			
        			//remove from sessions groups
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-un'] );
					kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-deux'] );
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-trois'] );
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-session-superhuit'] );
        				
        			//remove from réal validés
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-real-kabaret'] );
        				
        			// mailpoet
        			if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-real-kabaret'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-1'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-2'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-3'] 
						);
						kino_remove_from_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-session-superhuit'] 
						);
						//pas de groupe mailpoet pour réal kabaret annulé
					}
        		break;		
        		 
        		case 'kabaret-reject':
        		
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-real-kabaret-rejected'] );
        			
        			// remove from groups

        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-candidats-vus-moyens'] );
        		
        			kino_remove_from_usergroup( $id, 
        				$kino_fields['group-candidats-vus-biens'] );
        			
        			// décocher le champ Réalisateur Kabaret!
        			kino_remove_real_kabaret_checkbox( $id, $kino_fields );
					
					// mailpoet
        			
        			if( $mailpoet_id = getMailpoetId( $id ) ) {
						kino_add_to_mailpoet_list( 
							$mailpoet_id, 
							$kino_fields['mailpoet-real-kabaret-rejected'] 
						);
					}

        		break;
        		
        		case 'kabaret-moyen' :
        		        			
        			kino_add_to_usergroup( $id, 
        				$kino_fields['group-candidats-vus-moyens'] );
        			// s'assurer que le champ Réalisateur Kabaret est coché
        			kino_check_real_kabaret_checkbox( $id, $kino_fields );
        		break;
        		
        		case 'kabaret-bien' :
        		        			
					kino_add_to_usergroup( $id, 
						$kino_fields['group-candidats-vus-biens'] );
						
					// s'assurer que le champ Réalisateur Kabaret est coché
					kino_check_real_kabaret_checkbox( $id, $kino_fields );
   		
        		break;
			}
        		
        		// ACTIONS Payment
        		
        		if ( $state == 'payment-25' ) {
					$current_term_id = $kino_fields['compta-paid-25'];
					
        			kino_add_to_compta( $id, $current_term_id);
        			
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de 25.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			//nombre vendu par jour Ticket #291
					if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		
        		if ( $state == 'payment-40' ) {
					$current_term_id = $kino_fields['compta-paid-40'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de 40.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		
        		if ( $state == 'payment-100' ) {
					$current_term_id = $kino_fields['compta-paid-100'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de 100.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		
        		if ( $state == 'payment-125' ) {
					$current_term_id = $kino_fields['compta-paid-125'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de 125.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		
        		if ( $state == 'payment-reset' ) {
					$meta_ids = array( $kino_fields['compta-paid-25'], $kino_fields['compta-paid-40'], $kino_fields['compta-paid-100'], $kino_fields['compta-paid-125'] );
					foreach($meta_ids as $meta_id){
						if( kino_remove_from_compta( $id, $meta_id ) ) {
							$old_value = get_term_meta( $meta_id, date("d.m.Y"), true );
							update_term_meta( $meta_id, date("d.m.Y"), ( $old_value - 1 ) );
						}
					}
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement annulé pour '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		if ( $state == 'repas-60' ) {
					$current_term_id = $kino_fields['compta-repas-60'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement pour Carte Repas de 60.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		
        		if ( $state == 'repas-100' ) {
					$current_term_id = $kino_fields['compta-repas-100'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement pour Carte Repas de 100.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		
        		if ( $state == 'repas-125' ) {
        			$current_term_id = $kino_fields['compta-repas-125'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement pour Carte Repas de 125.- CHF reçu de '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		
        		if ( $state == 'repas-reset' ) {
					$meta_ids = array( $kino_fields['compta-repas-60'], $kino_fields['compta-repas-100'], $kino_fields['compta-repas-125'] );
					foreach($meta_ids as $meta_id){
						if( kino_remove_from_compta( $id, $meta_id ) === true ) {
							$old_value = get_term_meta( $meta_id, date("d.m.Y"), true );
							update_term_meta( $meta_id, date("d.m.Y"), ( $old_value - 1 ) );
						}
					}
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Paiement de Carte Repas annulé pour '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		
        		//offert
        		if ( $state == 'offert-entree-25' ) {
					$current_term_id = $kino_fields['compta-paid-offert-25'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Offert entrée à 25.- CHF pour '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		if ( $state == 'offert-entree-125' ) {
        			$current_term_id = $kino_fields['compta-paid-offert-125'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Offert entrée à 125.- CHF pour '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		if ( $state == 'offert-repas-60' ) {
        			$current_term_id = $kino_fields['compta-repas-offert-60'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Offert carte repas à 60.- CHF pour '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		if ( $state == 'offert-repas-125' ) {
        			$current_term_id = $kino_fields['compta-repas-offert-125'];
					
        			kino_add_to_compta( $id, $current_term_id );
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Offert carte repas à 125.- CHF pour '.$userdata->user_login.' (id: '.$id.').</p>';
        			
        			if(!empty( $old_value = get_term_meta( $current_term_id, date("d.m.Y"), true ) ) ){
						update_term_meta( $current_term_id, date("d.m.Y"), ( $old_value + 1 ) );
					}
					else {
						add_term_meta( $current_term_id, date("d.m.Y"), 1, true );
					}
        		}
        		if ( $state == 'offert-entree-reset' ) {
					$meta_ids = array( $kino_fields['compta-paid-offert-25'], $kino_fields['compta-paid-offert-125'] );
					foreach($meta_ids as $meta_id){
						if( kino_remove_from_compta( $id, $meta_id ) === true ) {
							$old_value = get_term_meta( $meta_id, date("d.m.Y"), true );
							update_term_meta( $meta_id, date("d.m.Y"), ( $old_value - 1 ) );
						}
					}
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Entrée offerte annulée pour '.$userdata->user_login.' (id: '.$id.').</p>';
        		}
        		if ( $state == 'offert-repas-reset' ) {
					$meta_ids = array( $kino_fields['compta-repas-offert-60'], $kino_fields['compta-repas-offert-125'] );
					foreach($meta_ids as $meta_id){
						if( kino_remove_from_compta( $id, $meta_id ) === true ) {
							$old_value = get_term_meta( $meta_id, date("d.m.Y"), true );
							update_term_meta( $meta_id, date("d.m.Y"), ( $old_value - 1 ) );
						}
					}
        			$userdata = get_userdata( $id );
        			$message_compta .= '<p>Repas offert annulé pour '.$userdata->user_login.' (id: '.$id.').</p>';
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



function kino_table_header( $validation, $id = null ) {
	
		if (!empty($id)) {
			$tableid = 'id="'. $id .'"';
			$tbodyid = 'id="items_'. $id .'"';
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
				    <th>Session GE t’aime</th>
				    <th>Scénario d’un autre</th>
				    <th>Atelier écriture</th>
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
					<tbody '. $tbodyid .'>';
		
		return $kino_table_header;
		
}

