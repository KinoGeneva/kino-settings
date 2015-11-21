<?php 
	
	// some jQuery corrections for the BuddyPress Profile Edit Page
	
	
	// Load User Role testing
	
	$kino_user_role = kino_user_participation();
	

 ?>
 
 <script>
 jQuery(document).ready(function($){	
 		
 		
 		// le champ Presentez-vous = 500 signes = 100 mots
 		
 			$("#profile-edit-form #field_31").attr("maxlength", "500"); 
 			
 			// le champ Mes motivations à rejoindre KinoGeneva = 500 mots max. = 2500 signes
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
 			
 			// On désactive l'option Réalisateur: voir https://bitbucket.org/ms-studio/kinogeneva/issues/18/inscriptions-section-r-alisateur
 			
 			if ( in_array( "realisateur", $kino_user_role ) && current_user_can('subscriber') ) {
 					?>
 					
 					// $('#profile-edit-form #field_1297_2').prop('disabled', true);
 					// $('#profile-edit-form #field_1424_2').prop('disabled', true); // = Réalisateur-trice
 					
 					$('#profile-edit-form div.field_135 input[value="Réalisateur-trice"]').prop('disabled', true);
 					 					
 					<?php
 			}
 			
 			
 			if ( in_array( "realisateur-2016", $kino_user_role ) && current_user_can('subscriber') ) {
 						?>
 						
 					$('#profile-edit-form #field_1312_2').prop('disabled', true);
 					$('#profile-edit-form div.field_1258 input[value="Réalisateur-trice"]').prop('disabled', true);
 						
 						<?php
 				}
 		
 		// Montrer les checkbox si Realisateur est "Checked":
 		
 		?>
 		
 		$("input#field_1312_2").click(function() {
 		    // this function will get executed every time the #home element is clicked (or tab-spacebar changed)
 		    if($(this).is(":checked")) // "this" refers to the element that fired the event
 		    {
 		        // alert('home is checked');
 		        $('#profile-edit-form div.field_1101').show();
 		        $('#profile-edit-form div.field_1106').show();
 		        $('#profile-edit-form div.field_1116').show();
 		        
 		    } else {
 		    		$('#profile-edit-form div.field_1101').hide();
 		    		$('#profile-edit-form div.field_1106').hide();
 		    		$('#profile-edit-form div.field_1116').hide();
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
   					    // has link = fule exists = do nothing
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
   				'user_id' => bp_loggedin_user_id()
   		) );
   		
   		$kino_user_info = get_userdata( bp_loggedin_user_id() );
   		$kino_wp_login = $kino_user_info->user_login;
   		
   		// echo "// $kino_fullname = ". $kino_fullname . " -  $kino_wp_login = " . $kino_wp_login ;
   		
   		if ( $kino_fullname == $kino_wp_login ) {
   		
   				// clear the field with Jquery!
   				
   				?>
   				$("input#field_1").val('');
   				<?php
   				
   		}
   		
   		
   		 ?>
   	
 });
 </script>
 <?php 
 
 echo '<style type="text/css">';
 	
 	// Conditional part for Kino Kabaret 2016

 		// We use inline CSS to prevent delay...
 		
 		if ( bp_get_current_profile_group_id() == 15 ) {
 			
 			if ( !in_array( "realisateur", $kino_user_role ) ) {
 				// hide fields
 				// $("div.field_1258 label[for=field_1268_2]").hide();
 				// $("div.field_1258 p.description").hide();
 				?>
 				#buddypress div.field_1258 label[for=field_1312_2],
 				#buddypress div.field_1258 p.description
 				{
 					display:none;
 				}
 				<?php
 			}
 			if (!in_array( "comedien", $kino_user_role )) {
 				// hide fields
 				// $("div.field_1258 label[for=field_1266_0]").hide();
 				
 				?>
 				 #buddypress div.field_1258 label[for=field_1310_0] {
 				 	display:none;
 				 }
 				<?php
 			}
 			if (!in_array( "technicien", $kino_user_role )) {
 				// $("div.field_1258 label[for=field_1267_1]").hide();
 				?>
 				#buddypress div.field_1258 label[for=field_1311_1] {
 					display: none;
 				}
 				<?php
 				
 				// Also, test if none is in array:
 				if ( !in_array( "realisateur", $kino_user_role ) ) {
 					if (!in_array( "comedien", $kino_user_role )) {
 						// hide the whole box!
 						?>
 						
 				#buddypress #profile-edit-form div.field_1258 {
 						display: none;
 						}
 						
 						<?php
 					} // comedien
 				} // realisateur
 			} // technicien
 			
 			
 			if (!in_array( "realisateur-2016", $kino_user_role )) {
 					
 					// issue: https://bitbucket.org/ms-studio/kinogeneva/issues/51/kino-kabaret-2016-sessions
 					
 					?>
 					 #buddypress #profile-edit-form div.field_1101,
 					 #buddypress #profile-edit-form div.field_1106,
 					 #buddypress #profile-edit-form div.field_1116 {
 					 	display:none;
 					 }
 					<?php
 				}
 			
 		} // end profile group #15
 
 echo '</style>';
 
  ?>