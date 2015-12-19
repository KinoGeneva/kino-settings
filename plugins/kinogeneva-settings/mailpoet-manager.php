<?php 

// function to add users to mailpoet mailing lists...

// Bénévoles

// Add To Mailing_list!
        			    $user_data = array(
        			        'email' => $user->user_email,
        			        'firstname' => $user->user_firstname,
        			        'lastname' => $user->user_lastname);
        			 
        			    $data_subscriber = array(
        			      'user' => $user_data,
        			      'user_list' => array('list_ids' => array($kino_fields["mailpoet-benevoles"]))
        			    );
        			 
//        				    $helper_user = WYSIJA::get('user','helper');
//        				    $helper_user->addSubscriber($data_subscriber);


// Réalisateurs plateforme ONLY

				        		    $user_data = array(
				        		        'email' => $user->user_email,
				        		        'firstname' => $user->user_firstname,
				        		        'lastname' => $user->user_lastname);
				        		 
				        		    $data_subscriber = array(
				        		      'user' => $user_data,
				        		      'user_list' => array('list_ids' => array($kino_fields["mailpoet-real-platform-only"]))
				        		    );
				        		 
//				        		    $helper_user = WYSIJA::get('user','helper');
//				        		    $helper_user->addSubscriber($data_subscriber);


