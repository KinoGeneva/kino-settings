<?php  


// ORGINAL FUNCTION, modified // not used anymore.

function kino_bp_profile_group_tabs() {
	echo kino_bp_get_profile_group_tabs();

	/**
	 * Fires at the end of the tab output for switching between profile field
	 * groups. This action is in a strange place for legacy reasons.
	 *
	 * @since BuddyPress (1.0.0)
	 */
	do_action( 'xprofile_profile_group_tabs' );
}

function kino_bp_get_profile_group_tabs() {

	// Get field group data
	$groups     = bp_profile_get_field_groups();
	$group_name = bp_get_profile_group_name();
	$tabs       = array();
	
	$kino_role = bp_get_profile_field_data( array(
		'field'   => '1121',
		'user_id' => bp_loggedin_user_id()
	) );
	
	// Loop through field groups and put a tab-lst together
	for ( $i = 0, $count = count( $groups ); $i < $count; ++$i ) {

		// Setup the selected class
		$selected = '';
		if ( $group_name === $groups[ $i ]->name ) {
			$selected = 'current'; // = Skip rest of loop.
		}

		// Skip if group has no fields
		if ( empty( $groups[ $i ]->fields ) ) {
			continue;
		}
		
		// Example: Skip group Nr 5:
//		if ( 5 == $groups[ $i ]->id ) {
//			continue;
//		}

		// Build the profile field group link
		$link   = trailingslashit( bp_displayed_user_domain() . buddypress()->profile->slug . '/edit/group/' . $groups[ $i ]->id );
		
		// add group name to CSS class:
		$selected .= ' groupnr'. $groups[ $i ]->id;

		// Add tab to end of tabs array
		$tabs[] = sprintf(
			'<li class="%1$s"><a href="%2$s">%3$s</a></li>',
			$selected,
			esc_url( $link ),
			esc_html( apply_filters( 'bp_get_the_profile_group_name', $groups[ $i ]->name ) )
		);
	} // end for loop.

	/**
	 * Filters the tabs to display for profile field groups.
	 *
	 * @since BuddyPress (1.5.0)
	 *
	 * @param array  $tabs       Array of tabs to display.
	 * @param array  $groups     Array of profile groups.
	 * @param string $group_name Name of the current group displayed.
	 */
	$tabs = apply_filters( 'xprofile_filter_profile_group_tabs', $tabs, $groups, $group_name );

	return join( '', $tabs );
}

//** ********************** */

function kino_the_profile_group_edit_form_action() {
	echo kino_get_the_profile_group_edit_form_action();
}

function kino_get_the_profile_group_edit_form_action() {
		global $group;

		$bp = buddypress();
		
		$groups = bp_profile_get_field_groups();
		
		// figure out ID of current group
		$current_group_id = $group->id;
		// give a fallback value
		$next_group_id = $current_group_id;
		
		$count = count( $groups );
		
		for ( $i = 0, $count; $i < $count; ++$i ) {
			if ( $current_group_id == $groups[ $i ]->id ) {
			
					$j = $i+1;
					if ( $j < $count) { 
						$next_group_id = $groups[ $j ]->id;
					}
				
			} // end if.
		} // end for.
		
		/**
		 * Filters the action for the profile group edit form.
		 *
		 * @since BuddyPress (1.1.0)
		 *
		 * @param string $value URL for the action attribute on the
		 *                      profile group edit form.
		 */
				 
		return apply_filters( 'bp_get_the_profile_group_edit_form_action', trailingslashit( bp_displayed_user_domain() . $bp->profile->slug . '/edit/group/' . $next_group_id ) );
}


function kino_hide_some_profile_fields( $retval ) {	
	
	// WORKS!
	
	if(  bp_is_profile_edit() ) {	
		
		// $retval['exclude_fields'] = '1,2';	//field ID's separated by comma
		// YES = works for hiding fields
		
		// $retval['exclude_groups'] = '1,2,3,4,5,6,7,8,9,10,15';
		// does not work for hiding groups
	
	}	
	
	return $retval;
}
// add_filter( 'bp_after_has_profile_parse_args', 'kino_hide_some_profile_fields' );


/* Creating a custom filter */

add_filter( 'bp_profile_get_field_groups', 'kino_get_field_group_conditions', 10 );

function kino_get_field_group_conditions( $groups ){

  // $groups = array();
  // $number_of_groups = count( $groups );
  
  	$kino_role = bp_get_profile_field_data( array(
  		'field'   => '1',
  		'user_id' => bp_loggedin_user_id()
  	) );
  	
  	$forbidden_groups = array(
  		"5.a Inscription Kabaret",
  		"5.b Kabaret suite",
  	);
  	
  	$forbidden_group_ids = array(
  		// 7, // Technicien = 7
  		// 9, // Kabaret = 9
  		// 12, // Kabaret = 12
  	);
  	
  	if ( $kino_role === "Schmalstieg") {
  	 	 $forbidden_groups[] = "2. Compétence Réal";
//  	 	 $forbidden_groups[] = "4. Compétence Technicien";
  	}
  	
  	$groups_updated = array();
  
  	for ( $i = 0, $count = count( $groups ); $i < $count; ++$i ) {
			
			$group_name = $groups[ $i ]->name;
			$group_id= $groups[ $i ]->id;
			
			// hide forbidden groups
			if (in_array( $group_name, $forbidden_groups)) {
				// Do Nothing = group is hidden
			} else {
				// Add to array
				$groups_updated[] = $groups[ $i ];
			}
			
  	} // end for loop.
  	
  return $groups_updated;
}