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
        if( empty ($_POST['action']) || $_POST['action'] !== 'set_pending_item_state') {
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

        		if ( ( $state == 'platform-accept' ) || ( $state == 'platform-reject') ) {
        		
        			// remove from : platform pending
        			
        			wp_remove_object_terms( 
        				$id, 
        				$kino_fields['group-real-platform-pending'], 
        				'user-group'
        			);
        			
        			// remove from mailpoet list:
        			
        			kino_remove_from_mailpoet_list(
        				$id,
        				$kino_fields['mailpoet-real-platform-only']
        			);
        		
        		}
        		
        		if ( $state == 'platform-accept' ) {
        		
        			// add to group
        			kino_add_to_usergroup( $id, $kino_fields['group-real-platform'] );
        				
        			// Add to Mailpoet List
        			kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-real-platform'] );
        		
        		}
        		
        		if ( $state == 'platform-reject' ) {
        			
        			// add to group
        			kino_add_to_usergroup( $id, $kino_fields['group-real-platform-rejected'] );
        			
        			// Add to Mailpoet List
        			kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-real-platform-rejected'] );
        			
        			// remove checkbox!
        			kino_remove_real_platform_checkbox( $id, $kino_fields );
        			
        		}
        		
        		// ******************
        		
        		if ( ( $state == 'kabaret-accept' ) || ( $state == 'kabaret-reject' ) ) {
        		
        			// remove from pending
        			wp_remove_object_terms( 
        				$id, 
        				$kino_fields['group-real-kabaret-pending'], 
        				'user-group'
        			);
        			
        			kino_remove_from_mailpoet_list(
        				$id,
        				$kino_fields['mailpoet-real-platform-only']
        			);
        		
        		}
        		
        		if ( $state == 'kabaret-accept' ) {
        			
        			// Add to Group
        			kino_add_to_usergroup( $id, $kino_fields['group-real-kabaret'] );
        				
        			// Add to Mailpoet List
        			kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-real-kabaret'] );

        		
        		} else if ( $state == 'kabaret-reject') {
        		
        			kino_add_to_usergroup( $id, $kino_fields['group-real-kabaret-rejected'] );
        				
        				// Add to Mailpoet List
        				kino_add_to_mailpoet_list( $id, $kino_fields['mailpoet-real-kabaret-rejected'] );
        				
        			// décocher le champ Réalisateur Kabaret!
        			
        			kino_remove_real_kabaret_checkbox( $id, $kino_fields );
        			
        		} // end else/if
        		
        } // end !empty($state)

        wp_send_json_success(array(
            'action' => $_POST['action'],
            'message' => 'State Was Set To ' . $state,
            'state' => $state,
            'ID' => $id
        )); // die
    } // end function set_real_kabaret_state()
    
});

function kino_add_to_mailpoet_list( $user, $list ) {
	
	/**
	 * addToList()
	 * in: helpers/user.php
	 * add many subscribers to one list
	 * @param int $list_id
	 * @param int $user_ids
	 * @return boolean
	 */
	 
	$helper_user = WYSIJA::get('user','helper');
	
	if ( !is_array($user) ) {
		$user = array($user);
	}
	
	$helper_user->addToList(
	    $list,
	    $user
	 );

}

function kino_add_to_mailpoet_list_array( $user, $list ) {
	 
	$helper_user = WYSIJA::get('user','helper');
	$helper_user->addToList(
	    $list,
	    $user
	 );

}

function kino_remove_from_mailpoet_list( $user, $list ) {
	
	$helper_user = WYSIJA::get('user','helper');
	$helper_user->removeFromLists(
	    array($list),
	    array($user)
	 );

}

function kino_remove_real_platform_checkbox( $id, $kino_fields ) {

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

function kino_remove_real_kabaret_checkbox( $id, $kino_fields ) {

		// A: get the field
		$kino_participation_xfield = bp_get_profile_field_data( array(
			'field'   => $kino_fields['profile-role'],
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
					$kino_fields['profile-role'],  
					$id,  
					$kino_participation_xfield
					);
		
		} // test if !empty $kino_participation_xfield
	
}



function kino_table_header( $validation ) {
	
		$kino_table_header = '<table class="table table-hover table-bordered table-condensed pending-form">
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
		
		} else if ( $validation == 'kabaret' ) {
		
			$kino_table_header .= '<th class="validation">Validation Kabaret</th>';
		
		}
				
		$kino_table_header .= '</tr>
					</thead>
					<tbody>';
		
		return $kino_table_header;
		
	}

