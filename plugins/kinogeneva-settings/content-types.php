<?php 

/* Register Post Types
 ********************
*/

add_action( 'init', 'kino_register_post_types' );

function kino_register_post_types() {

		// Un post-type pour les vues Admin spéciales

		register_post_type(
				'kino-admin', array(	
					'label' => __( 'Pages Admin' ),
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					 'menu_icon' => 'dashicons-analytics', // src: https://developer.wordpress.org/resource/dashicons/
					// dashicons-admin-post
					'capability_type' => 'post',
					'map_meta_cap' => true,
					'hierarchical' => false,
					'has_archive'		 => false,
					'rewrite' => array('slug' => ''),
					'query_var' => true,
					'menu_position' => 20, // 20 = below Pages
					'supports' => array(
						'title',
						'editor',
						'author',
						),
					'taxonomies' => array(),
					'labels' => array (
				  	  'name' => 'Pages Admin',
				  	  'singular_name' => 'Page Admin',
				  	  'menu_name' => 'Pages Admin',
				  	  'add_new' => 'Ajouter',
				  	  'add_new_item' => 'Ajouter une page admin',
				  	  'edit' => 'Modifier',
				  	  'edit_item' => 'Modifier la page admin',
				  	  'new_item' => 'Nouvelle page admin',
				  	  'view' => 'Afficher',
				  	  'view_item' => 'Afficher la page',
				  	  'search_items' => 'Recherche',
				  	  'not_found' => 'Aucun résultat',
				  	  'not_found_in_trash' => 'Aucun résultat',
				  	  'parent' => 'Elément parent',
				),
			) 
		);
		
}



 ?>