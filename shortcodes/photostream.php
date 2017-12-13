<?php 


// Create a stream of photos
// Usage : [kino_photos]
// ou [kino_photos cat="kabaret-2016"]

function kino_photos_shortcode( $att ) {
	
	$atts = shortcode_atts( array(
			'cat' => 'kabaret-2016' // default category if no attribute
	), $atts, 'kino_photos' );
	
	$img_ids = array();
	
  $output = '<h1>Kino Photo Stream for '.$atts["cat"].'</h1>';
  
  /*
   * Fonctionnement:
   
   * On fait une requête sur les films du Kino ...2017?
   
   * On récolte toutes les photos attachées
   Les photos sont dans une galerie ACF...
   Groupe de champs "Médias" - ID: medias
   
   * On traite les photos avec shortcode gallery
   
   * On sauve le résultat dans un Transient 
   
   * On affiche le résultat
  */
  
  /*
   * 1) Requête sur films Kino
   *
  */
  
  $args = array(
          'post_type' => 'any',
          'tax_query' => array(
          		'relation' => 'OR',
          		array(
          			'taxonomy' => 'portfolio-category',
          			'field'    => 'slug',
          			'terms'    => $atts["cat"],
          		),
          		array(
          			'taxonomy' => 'category',
          			'field'    => 'slug',
          			'terms'    => $atts["cat"],
          		),
          ),
      );
      $custom_query = new WP_Query($args);
      
  
      if ( $custom_query->have_posts() ) { 
      				    
          while ( $custom_query->have_posts() ) { 
              $custom_query->the_post();
  
              // $output .= '<h4>'. get_the_title() .'</h4>';
              
              // echo '<h4>'. get_the_title() .'</h4>';
              
              /*
               * 2) Récupérer les IDs des images
              */
              
              $images = get_field( 'medias' );
              
              if ( !empty($images) ) {
              		
              		foreach ($images as $key => $item){
              		
              			$img_ids[] = $item["id"];
              			
              		}
              
              }
              	
          } // while
          wp_reset_postdata();    
      } // if have_posts
  
//  		echo '<pre>';
//  		var_dump($img_ids);
//  		echo '</pre>';

			// On trie les images par numéro 
  		
  		$gallery_shortcode = '[gallery ids="' . implode(",", $img_ids) . '" size="medium" link="file"]';
  				
  		$output .= do_shortcode( $gallery_shortcode );
  		
  return $output;
}
add_shortcode( 'kino_photos', 'kino_photos_shortcode' );

