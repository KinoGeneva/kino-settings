<?php 

// Disable XML-RPC

add_filter('xmlrpc_enabled', '__return_false');

remove_action ('wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');


function kino_process_niveau( $kino_niveau ) {
		
		$kino_niveau_output = '';
		
		if ( $kino_niveau == 'Professionnel-le') {
			$kino_niveau_output = 'pro';
		}
		
		if ( $kino_niveau == 'Professionnel-le en devenir') {
			$kino_niveau_output = 'en devenir';
		}
		
		if ( $kino_niveau == 'Amateur-e passionné-e') {
			$kino_niveau_output = 'amateur';
		}
		
		return $kino_niveau_output;
		
}

function kino_add_to_comp( $id, $group ) {
	
	wp_set_object_terms( 
			$id, // $object_id, 
			$group, // $terms, 
			'user-competences', // $taxonomy, 
			true // $append 
	);

}

function kino_add_to_compta( $id, $group ) {
	wp_set_object_terms( 
			$id, // $object_id, 
			$group, // $terms, 
			'user-compta', // $taxonomy, 
			true // $append 
	);
}

function kino_remove_from_compta( $id, $group ) {
	return wp_remove_object_terms( 
			$id, // $object_id, 
			$group, // $terms, 
			'user-compta' // $taxonomy, 
	);
}
