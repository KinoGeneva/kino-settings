<?php

/* Custom translation strings
 */


// remove_action( 'bp_core_loaded', 'bp_core_load_buddypress_textdomain' );
// = completely disables the buddypress translation

add_action( 'plugins_loaded', 'kino_load_textdomain', 1 ); // must be earlier than 10!

function kino_load_textdomain() {
			
			load_plugin_textdomain( 
				'buddypress',
				false, 
				'kinogeneva-settings/languages/' // relative to WP_PLUGIN_DIR
			);
			
			load_plugin_textdomain( 
				'wp-user-groups',
				false, 
				'kinogeneva-settings/languages/'
			);
			
			// BP group announcements
			load_plugin_textdomain( 
				'bpga',
				false, 
				'kinogeneva-settings/languages/'
			);
			
			// BP group calendar
			load_plugin_textdomain( 
				'groupcalendar',
				false, 
				'kinogeneva-settings/languages/'
			);
			
			// BuddyPress Group Email Subscription
			load_plugin_textdomain( 
				'bp-ass',
				false, 
				'kinogeneva-settings/languages/'
			);
			
			// BuddyPress Group Taxo
			load_plugin_textdomain( 
				'bp-groups-taxo',
				false, 
				'kinogeneva-settings/languages/'
			);
			
			// ( 'Announcements', 'bpga' );
			// __('Calendar', 'groupcalendar');
}



/*
* End of file
*/