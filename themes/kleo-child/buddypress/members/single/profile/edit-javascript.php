<?php 
	
	// some jQuery corrections for the BuddyPress Profile Edit Page
	
	
	// Load Field Numbers:
	
	$kino_fields = kino_test_fields();
	
	$userid = bp_loggedin_user_id();
	
	// Load User Role testing
	
	$kino_user_role = kino_user_participation( $userid );
	

 ?>
 
 <script>
 jQuery(document).ready(function($){	
 		
 		
 		// le champ Presentez-vous = limiter à 500 signes = 100 mots
 		
 			$("#profile-edit-form #field_31").attr("maxlength", "500"); 
 			
 			// le champ Mes motivations à rejoindre KinoGeneva = limiter à  500 mots = 2500 signes
 			$("#profile-edit-form #field_545").attr("maxlength", "2500"); 
 			
 			// add target_blank to .kino-edit-profile links
 			$("#profile-edit-form p.description a[href^=http]").attr('target', '_blank');
 			
 			<?php
 			
 			// Une fois les conditions générales acceptées, on ne peut plus les modifier!
 			// make #check_acc_field_1070 read-only if checked
 			//$('#profile-edit-form #check_acc_field_1070').prop('checked').prop('disabled', true);
 			
 			?>
 				
 				var kino_accept_cond = '#profile-edit-form #check_acc_field_1070';
 				if ($(kino_accept_cond).is(":checked")) {
 				        $(kino_accept_cond).prop('disabled', true);
 				}
 				
 			
 			<?php
 			
 			// for Profile Group 1 (= Profil Kinoïte)
 			
 			// Une fois coché, on désactive l'option Réalisateur: 
 				// voir https://bitbucket.org/ms-studio/kinogeneva/issues/18/inscriptions-section-r-alisateur
 			
 			if ( bp_get_current_profile_group_id() == 1 ) {
 				if ( current_user_can('subscriber') ) {
				 			
				 			$kino_disable_real_checkbox = false;
				 			
				 			if ( in_array( "realisateur", $kino_user_role ) ) {
				 					
				 					$kino_disable_real_checkbox = true;
				 					
				 			} else {
				 			
				 				/* test for Groups: 
				 				 * group-real-platform-pending? 
				 				 * group-real-platform?
				 				 * group-real-platform-rejected
				 				*/
				 				
				 				if ( has_term( 
				 					$kino_fields['group-real-platform'], 
				 					'user-group', 
				 					$userid ) ) {
				 							$kino_disable_real_checkbox = true;
				 				} else if ( has_term( 
			 						$kino_fields['group-real-platform-pending'], 
			 						'user-group', 
			 						$userid ) ) {
				 							$kino_disable_real_checkbox = true;
				 				} else if ( has_term( 
			 						$kino_fields['group-real-platform-rejected'], 
			 						'user-group', 
			 						$userid ) ){
				 							$kino_disable_real_checkbox = true;
				 				}
				 			
				 			}
				 			
				 			if ( $kino_disable_real_checkbox == true ) {
				 				
				 				?>
				 					// Dans "Profil Kinoïte", option Réalisateur-trice:
				 					
				 					$('#profile-edit-form div.field_<?php echo $kino_fields['profile-role']; ?> input[value="Réalisateur-trice"]').prop('disabled', true);
				 					
				 					// on pourrait ajouter une notification...
				 					
				 					<?php
				 			} 
		 			} // if subscriber
		 	} // if edit group id = 1
 			
 			
 			// for Profile Group 15 (= Kino Kabaret 2016)
 			
 			if ( bp_get_current_profile_group_id() == 15 ) {
 				
 				if ( current_user_can('subscriber') ) {
 							
 							
 							// Désactiver l'option "Réalisateur", une fois la demande soumise
 							
 							$kabaret_disable_real_checkbox = false;
 							
				 			if ( in_array( "realisateur-2016", $kino_user_role ) ) {
				 			
				 					$kabaret_disable_real_checkbox = true;
				 			
				 			} else {
				 				
				 					/* test for Groups: 
				 					 * group-real-platform-pending? 
				 					 * group-real-platform?
				 					 * group-real-platform-rejected
				 					*/
				 					
				 					if ( has_term( 
				 						$kino_fields['group-real-kabaret'], 
				 						'user-group', 
				 						$userid ) ) {
				 								$kabaret_disable_real_checkbox = true;
				 					} else if ( has_term( 
				 						$kino_fields['group-real-kabaret-pending'], 
				 						'user-group', 
				 						$userid ) ) {
				 								$kabaret_disable_real_checkbox = true;
				 					} else if ( has_term( 
				 						$kino_fields['group-real-kabaret-rejected'], 
				 						'user-group', 
				 						$userid ) ){
				 								$kabaret_disable_real_checkbox = true;
				 					}
				 				
				 				}
				 				
				 			if ( $kabaret_disable_real_checkbox == true ) {
				 			
				 				?>
				 						
				 					$('#profile-edit-form #field_<?php echo $kino_fields['role-kabaret-real']; ?>').prop('disabled', true);
				 					$('#profile-edit-form div.field_<?php echo $kino_fields['role-kabaret']; ?> input[value="Réalisateur-trice"]').prop('disabled', true);
				 						
				 				<?php
				 						
				 			}	
				 				
				} // if user = subscriber
				
 		} // if edit group id = 15
 		
 		// Montrer les Checkbox si Realisateur est "Checked":
 		
 		?>
 		
 		$("input#field_<?php echo $kino_fields['role-kabaret-real']; ?>").click(function() {
 		    if($(this).is(":checked")) // "this" refers to the element that fired the event
 		    {
 		        // alert('home is checked');
 		        $('#profile-edit-form div.field_<?php echo $kino_fields['session-un']; ?>').show();
 		        $('#profile-edit-form div.field_<?php echo $kino_fields['session-deux']; ?>').show();
 		        $('#profile-edit-form div.field_<?php echo $kino_fields['session-trois']; ?>').show();
 		        // require validation
 		        $("#profile-edit-form div.field_<?php echo $kino_fields['session-un']; ?> select").attr('data-validation', 'required');
 		        $("#profile-edit-form div.field_<?php echo $kino_fields['session-deux']; ?> select").attr('data-validation', 'required');
 		        $("#profile-edit-form div.field_<?php echo $kino_fields['session-trois']; ?> select").attr('data-validation', 'required');
 		        
 		    } else {
 		    		$('#profile-edit-form div.field_<?php echo $kino_fields['session-un']; ?>').hide();
 		    		$('#profile-edit-form div.field_<?php echo $kino_fields['session-deux']; ?>').hide();
 		    		$('#profile-edit-form div.field_<?php echo $kino_fields['session-trois']; ?>').hide();
 		    		// remove validation
 		    		$("#profile-edit-form div.field_<?php echo $kino_fields['session-un']; ?> select").removeAttr('data-validation');
 		    		$("#profile-edit-form div.field_<?php echo $kino_fields['session-deux']; ?> select").removeAttr('data-validation');
 		    		$("#profile-edit-form div.field_<?php echo $kino_fields['session-trois']; ?> select").removeAttr('data-validation');
 		    }
 		});
 		
 		<?php
 		
		// For Safari: remove aria-required attribute
		
//   	$("div.required-field input[aria-required=true]").attr("aria-required","false");
//   	$("div.required-field select[aria-required=true]").attr("aria-required","false");
//   	$("div.required-field textarea[aria-required=true]").attr("aria-required","false");

		// add data-validation="required"
		
		// $("div.required-field select").prop('required', true); // works for chrome + FF
		
		?>
		
		$("div.required-field.field_type_textarea textarea").attr('data-validation', 'required');
		
		$("div.required-field.field_type_textbox input").attr('data-validation', 'required');
		
			// datebox
			$("div.required-field.field_type_datebox select").attr('data-validation', 'required');
			// selectbox
			$("div.required-field.field_type_selectbox select").attr('data-validation', 'required');
			// color
			$("div.required-field.field_type_color input").attr('data-validation', 'required');
			// number
			$("div.required-field.field_type_number input").attr('data-validation', 'required');
 			
 			<?php
 			
 			// checkbox group
// 			$("div.required-field.field_type_checkbox input").attr({
// 				    'data-validation':'checkbox_group', 
// 				    'data-validation-qty':'min 1'
// 				});;
 		
 			// image = must test by JS if empty
 				// $("div.required-field.field_type_image input").prop('required', true);
 				
 				?>
 				
 				$('div.required-field.field_type_image').each(function() {
 				    if ($(this).children('img').length) {
 				    	// has image = do nothing
 				    	// alert('has image');
 				    } else {
 				    	$(this).children('input[type=file]').attr('data-validation', 'required');
 				    }
 				});
 				
 				// file = must test by JS if empty
 					// $("div.required-field.field_type_file input").prop('required', true);
 					
 				$('div.required-field.field_type_file').each(function() {
 					    if ($(this).children('a').length) {
 					    // has link = do nothing
 					    // alert('has link');
 					    } else {
 					    	$(this).children('input[type=file]').attr({
 					    	    'data-validation':'mime',  // required - cf http://formvalidator.net/#file-validators
 					    	    'data-validation-allowing':'jpg'
 					    	});
 					    }
 					});
 				
 			
 		
   	<?php 
   		
   		// add conditional part 
   		
   		
   		
   		if (in_array( "realisateur", $kino_user_role )) {
   		
   			// test if file exists
   			?>
   			
   			$('div.field_858.field_type_file').each(function() {
   					    if ($(this).children('a').length) {
   					    // has link = file exists = do nothing
   					    } else {
   					    	// $(this).children('input[type=file]').prop('required', true);
   					    	$("div.field_858 input[type=file]").attr('data-validation', 'required');
   					    	$("div.field_858 label[for=field_858]").text("C.V. (obligatoire)");
   					    }
   					});
   			
   			<?php
   		}
   		
   		
   		// add conditional part to solve issue #45 https://bitbucket.org/ms-studio/kinogeneva/issues/45/ 
   		// On teste si le champ "Prénom Nom" contient le nom d'utilsateur  		
   		
   		$kino_fullname = bp_get_profile_field_data( array(
   				'field'   => '1',
   				'user_id' => $userid
   		) );
   		
   		$kino_user_info = get_userdata( $userid );
   		$kino_wp_login = $kino_user_info->user_login;
   		
   		// echo "// $kino_fullname = ". $kino_fullname . " -  $kino_wp_login = " . $kino_wp_login ;
   		
   		if ( $kino_fullname == $kino_wp_login ) {
   		
   				// clear the field with Jquery!
   				
   				?>
   				$("input#field_1").val('');
   				<?php
   				
   		}
   		
   		
   		// Some Mixpanel Tracking Code:
   		
   		// https://mixpanel.com/help/reference/javascript
   		
   		// https://mixpanel.com/help/reference/javascript-full-api-reference#mixpanel.track_forms
   		
   		
   		 ?>
   		 
   		 // mixpanel.track_links("#button-nav", "Clicked Edit Profile");
   		 // doit cibler le <a>, sinon, BUG= ajoute "undefined" après l'URL!
   		 
   		 mixpanel.track_links('#button-nav li a', 'Clicked Edit Profile');
   		 
   		 // mixpanel.track_forms("#profile-edit-form", "Submitted Profile Form");
   		 // = fait bugger la validation!
   	
 });
 </script>
 <?php 
 
 // echo '<style type="text/css">';
 	
 	// Conditional part for Kino Kabaret 2016
 	// Explications: 

 		// We use inline CSS to prevent delay...
 		
 		if ( bp_get_current_profile_group_id() == 15 ) {
 			
 			if ( !in_array( "realisateur", $kino_user_role ) ) {
 				// hide fields
 				// $("div.field_1258 label[for=field_1268_2]").hide();
 				// $("div.field_1258 p.description").hide();
 				?>
 				<style type="text/css">
 				#buddypress div.field_<?php echo $kino_fields['role-kabaret']; ?> label[for=field_<?php echo $kino_fields['role-kabaret-real']; ?>],
 				#buddypress div.field_<?php echo $kino_fields['role-kabaret']; ?> p.description
 				{
 					display:none;
 				}
 				</style>
 				<?php
 			}
 			if (!in_array( "comedien", $kino_user_role )) {
 				// hide fields
 				// $("div.field_1258 label[for=field_1266_0]").hide();
 				
 				?>
 				<style type="text/css">
 				 #buddypress div.field_<?php echo $kino_fields['role-kabaret']; ?> label[for=field_<?php echo $kino_fields['role-kabaret-comed']; ?>] {
 				 	display:none;
 				 }
 				</style>
 				<?php
 			}
 			if (!in_array( "technicien", $kino_user_role )) {
 				// $("div.field_1258 label[for=field_1267_1]").hide();
 				?>
 				<style type="text/css">
 				#buddypress div.field_<?php echo $kino_fields['role-kabaret']; ?> label[for=field_<?php echo $kino_fields['role-kabaret-tech']; ?>] {
 					display: none;
 				}
 				</style>
 				<?php
 				
 				// Also, test if none is in array:
 				if ( !in_array( "realisateur", $kino_user_role ) ) {
 					if (!in_array( "comedien", $kino_user_role )) {
 						// hide the whole box!
 						// = le champ "je m'inscris au Kabaret en tant que"!
 						// NOTE: encore mieux: bloquer en PHP!
 						// NOTE: il faut enlever le statut obligatoire!
 						?>
 						<style type="text/css">
 				#buddypress #profile-edit-form div.field_<?php echo $kino_fields['role-kabaret']; ?> {
 						display: none;
 						}
 						</style>
 						<?php
 					} // comedien
 				} // realisateur
 			} // technicien
 			
 			
 			if (!in_array( "realisateur-2016", $kino_user_role )) {
 					
 					// issue: https://bitbucket.org/ms-studio/kinogeneva/issues/51/kino-kabaret-2016-sessions
 					
 					?>
 					<style type="text/css">
 					 #buddypress #profile-edit-form div.field_<?php echo $kino_fields['session-un']; ?>,
 					 #buddypress #profile-edit-form div.field_<?php echo $kino_fields['session-deux']; ?>,
 					 #buddypress #profile-edit-form div.field_<?php echo $kino_fields['session-trois']; ?> {
 					 	display:none;
 					 }
 					</style>
 					<?php
 				}
 			
 		} // end profile group #15
 
 echo '</style>';
 
  ?>