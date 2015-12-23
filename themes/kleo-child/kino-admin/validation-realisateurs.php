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
        
        $ids_real_platform_accepted = get_objects_in_term( 
        	$kino_fields['group-real-platform'] , 
        	'user-group' 
        );
        
        $ids_real_platform_rejected = get_objects_in_term( 
        	$kino_fields['group-real-platform-rejected'] , 
        	'user-group' 
        );
        
        // *********
        
        $ids_real_kabaret_pending = get_objects_in_term( 
        	$kino_fields['group-real-kabaret-pending'] , 
        	'user-group' 
        );
        
        $ids_real_kabaret_accepted = get_objects_in_term( 
        	$kino_fields['group-real-kabaret'] , 
        	'user-group' 
        );
        
        $ids_real_kabaret_rejected = get_objects_in_term( 
        	$kino_fields['group-real-kabaret-rejected'] , 
        	'user-group' 
        );
        
        // enlever les champs zéro: 
        $ids_real_platform_pending = array_filter($ids_real_platform_pending);
        $ids_real_kabaret_pending = array_filter($ids_real_kabaret_pending);
        
        $ids_real_platform_accepted = array_filter($ids_real_platform_accepted);
        $ids_real_kabaret_accepted = array_filter($ids_real_kabaret_accepted);
        
        $ids_real_platform_rejected = array_filter($ids_real_platform_rejected);
        $ids_real_kabaret_rejected = array_filter($ids_real_kabaret_rejected);
        
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
 				
 				// http://kinogeneva.ch/kino-admin/validation-realisateurs-plateforme/
 				
 				echo '<p><b>Voir aussi: <a href="'.$url.'/kino-admin/validation-realisateurs-plateforme/">Validation Réalisateurs Plateforme</a>.</b></p>';
 				
 				// **************
 				
 				// “En attente: Réalisateurs Kabaret only”
 				
 				if (!empty($ids_kabaret_only)) {
 				  $user_query = new WP_User_Query( array( 
 				  	'include' => $ids_kabaret_only, 
 				  	'orderby' => 'registered',
 				  	'order' => 'DESC'
 				  ) );
 					if ( ! empty( $user_query->results ) ) {
 				    	$metronom = 1;
 				    	$kino_show_validation = 'kabaret';
 				    	echo '<h2>En attente: Réalisateurs Kino Kabaret ONLY ('.count($user_query->results).')</h2>';
 				    	echo kino_table_header($kino_show_validation);
 				      	foreach ( $user_query->results as $user ) {
 				      		include('validation-real-loop.php');
 				      	}
 				    	echo '</tbody></table>';
 					  }
 				}
 				
 				//***************************************
 				
 				// “En attente: Réalisateurs Kino Kabaret 2016”
 				if (!empty($ids_real_kabaret_pending)) {
	 				$user_query = new WP_User_Query( array( 
	 					'include' => $ids_real_kabaret_pending, 
	 					'orderby' => 'registered',
	 					'order' => 'DESC'
	 				) );
	 				if ( ! empty( $user_query->results ) ) {
	 					$metronom = 1;
	 					$kino_show_validation = 'kabaret';
	 					echo '<h2>En attente: Réalisateurs Kino Kabaret 2016 ('.count($user_query->results).')</h2>';
	 					echo kino_table_header($kino_show_validation);
	 					foreach ( $user_query->results as $user ) {
	 						include('validation-real-loop.php');
	 					}
	 					echo '</tbody></table>';
	 				}
 				}
        
        //***************************************
        
        // “En attente: Réalisateurs Plateforme”
//        if (!empty($ids_real_platform_pending)) {
//	        $user_query = new WP_User_Query( array( 
//	        	'include' => $ids_real_platform_pending, 
//	        	'orderby' => 'registered',
//	        	'order' => 'DESC'
//	        ) );
//					if ( ! empty( $user_query->results ) ) {
//	        	$metronom = 1;
//	        	echo '<h2>En attente: Réalisateurs Plateforme ('.count($user_query->results).')</h2>';
//	        	echo $kino_table_header;
//	        	foreach ( $user_query->results as $user ) {
//	        		include('validation-real-loop.php');
//	        		}
//	        	echo '</tbody></table>';
//					}
//				}
				        
				//***************************************
				// “En attente: Réalisateurs Plateforme ONLY”
				
				if (!empty($ids_platform_only)) {
					$user_query = new WP_User_Query( array( 
						'include' => $ids_platform_only, 
						'orderby' => 'registered',
						'order' => 'DESC'
					) );
					if ( ! empty( $user_query->results ) ) {
	        	$metronom = 1;
	        	$kino_show_validation = 'false';
	        	echo '<h2>En attente: Réalisateurs Plateforme ONLY ('.count($user_query->results).')</h2>';
	        	echo kino_table_header($kino_show_validation);
	        	foreach ( $user_query->results as $user ) {
	        		include('validation-real-loop.php');
	        		// add users to mailpoet list:
	        		kino_add_to_mailpoet_list( $user->ID, 
	        				$kino_fields['mailpoet-real-platform-only'] 
	        			);
	        	}
					  echo '</tbody></table>';
					}
				}
				  
				 //***************************************
				 // “Acceptés: Réalisateurs Kabaret ”
				 
				 if (!empty($ids_real_kabaret_accepted)) {
				 	$user_query = new WP_User_Query( array( 
				 		'include' => $ids_real_kabaret_accepted, 
				 		'orderby' => 'registered',
				 		'order' => 'DESC'
				 	) );
				 	if ( ! empty( $user_query->results ) ) {
				   	$metronom = 1;
				   	$kino_show_validation = 'false';
				   	echo '<h2>Réalisateurs Kino Kabaret 2016: Acceptés ('.count($user_query->results).')</h2>';
				   	echo '<div id="real-kabaret-accepted">';
				   	echo kino_table_header($kino_show_validation);
				   	foreach ( $user_query->results as $user ) {
				   		include('validation-real-loop.php');
				   	}
				 	  echo '</tbody></table></div>';
				 	}
				 }
				 
				 //***************************************
				 // “Refusés: Réalisateurs Kabaret ”
				 
				 if (!empty($ids_real_kabaret_rejected)) {
				 	$user_query = new WP_User_Query( array( 
				 		'include' => $ids_real_kabaret_rejected, 
				 		'orderby' => 'registered',
				 		'order' => 'DESC'
				 	) );
				 	if ( ! empty( $user_query->results ) ) {
				   	$metronom = 1;
				   	$kino_show_validation = 'false';
				   	echo '<h2>Réalisateurs Kino Kabaret 2016: Refusés ('.count($user_query->results).')</h2>';
				   	echo '<div id="real-kabaret-rejected">';
				   	echo kino_table_header($kino_show_validation);
				   	foreach ( $user_query->results as $user ) {
				   		include('validation-real-loop.php');
				   		// add users to mailpoet list:
				   		kino_add_to_mailpoet_list( $user->ID, 
				   				$kino_fields['mailpoet-real-kabaret-rejected'] 
				   			);
				   	}
				 	  echo '</tbody></table></div>';
				 	}
				 	
				 	// add users to mailpoet list:
//				 	 	kino_add_to_mailpoet_list_array( $ids_real_kabaret_rejected, 
//				 	 		$kino_fields['mailpoet-real-kabaret-rejected'] 
//				 	 	);
				 	
				 } // test !empty

				
     ?>
        
    </div><!--end article-content-->
    
    <script>
    jQuery(document).ready(function($){	
    				
            (function ($) {
    						
    						var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    						
                var $form = $('.pending-form'),
                    $item = $form.find( '.pending-candidate');
    
                // Trigger to make AJAX call to set state for ID
                // ( 1:accept, -1:reject )
                function setState(id, state) {
    
                    // item clicked
                    var $item = $('.pending-candidate[data-id="' + id + '"]'),
    
                    // gather data
                        data = {
                            action: 'set_kino_state',
                            id:      id,
                            state:   state
                        };
    
                    // make AJAX POST call    
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: data,
                        success: function (response) {
    
                            // look at the response
    
                            if (response.success) {
    
                              // update the UI to reflect the response
                              $item.attr ('data-state', state);
                              
                              if ( state == 'kabaret-accept' ) {  
                              
                              	$item.detach();
                              
                              } else if ( state == 'kabaret-reject' ) {
                              
                              	$item.detach();
                              
                              }
    
                                // succcess data
                                console.log(response.data);
    
                            } else {
    
                                // no good
                                console.log(response);
                            }
                        }
                    });
                }
    
                // setup the items
                $item.each (function (inx, item){
                   
                   var $item = jQuery(item),
                       $actionBtn = $item.find ('.admin-action');

                   // setup the button click handlers
                   
                   $actionBtn.on ('click', function(){
                       var id = $item.attr ('data-id');
                       var kinoaction = $(this).attr ('data-action');
                       // alert ('id='+id+' action='+kinoaction);
                       setState( id, kinoaction);
                   });
   
               });
    
            })(jQuery);
            
     });
     </script>

    <?php  ?>
</article>
<!-- End  Article -->