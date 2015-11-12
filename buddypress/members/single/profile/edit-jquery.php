<?php 
	
	// some jQuery corrections for the BuddyPress Profile Edit Page

 ?>
 
 <script>
 jQuery(document).ready(function($){	
 	
 //  $("#profile-edit-form").change(function(){
 //    var formAction = $("#button-nav li.current").next("li").find( "a" ).attr("href");
 //    $("#profile-edit-form").attr("action", formAction);
 //  }); 
 
 		// le champ Presentez-vous = 500 signes = 100 mots
 		$("#profile-edit-form #field_31").attr("maxlength", "500"); 
   	// le champ Mes motivations à rejoindre KinoGeneva = 500 mots max. = 2500 signes
   	$("#profile-edit-form #field_545").attr("maxlength", "2500"); 
   	
   	// add target_blank to .kino-edit-profile links
   	$("#profile-edit-form p.description a[href^=http]").attr('target', '_blank');
   	
   	// make #check_acc_field_1070 read-only if checked
   	//$('#profile-edit-form #check_acc_field_1070').prop('checked').prop('disabled', true);
   	
   	var kino_accept_cond = '#profile-edit-form #check_acc_field_1070';
   	if ($(kino_accept_cond).is(":checked")) {
   	        $(kino_accept_cond).prop('disabled', true);
   	}
   	
   	// make .required-fields required:
   	
   	// textarea
   	$("div.required-field.field_type_textarea textarea").prop('required', true);
   	// textbox
   	$("div.required-field.field_type_textbox input").prop('required', true);
   	// datebox
   	$("div.required-field.field_type_datebox select").prop('required', true);
   	// selectbox
   	$("div.required-field.field_type_selectbox select").prop('required', true);
   	// color
   	$("div.required-field.field_type_color input").prop('required', true);
   	
   	
   	// image = must test by JS if empty
   	// $("div.required-field.field_type_image input").prop('required', true);
   	
   	$('div.required-field.field_type_image').each(function() {
   	    if ($(this).children('img').length) {
   	    	// has image = do nothing
   	    	// alert('has image');
   	    } else {
   	    	$(this).children('input[type=file]').prop('required', true);
   	    }
   	});
   	
   	// file = must test by JS if empty
   		// $("div.required-field.field_type_file input").prop('required', true);
   		
   	$('div.required-field.field_type_file').each(function() {
   		    if ($(this).children('a').length) {
   		    // has link = do nothing
   		    // alert('has link');
   		    } else {
   		    	$(this).children('input[type=file]').prop('required', true);
   		    }
   		});
   	
   	
   	
   	<?php 
   	
   	// add conditional part 
   	
   	$kino_user_role = kino_user_participation();
   	
   	if (in_array( "realisateur", $kino_user_role )) {
   	
   		// test if file exists
   		?>
				
				$('div.field_858.field_type_file').each(function() {
						    if ($(this).children('a').length) {
						    // has link = do nothing
						    } else {
						    	// $(this).children('input[type=file]').prop('required', true);
						    	$("div.field_858 input[type=file]").prop('required', true);
						    	$("div.field_858 label[for=field_858]").text("C.V. (obligatoire)");
						    }
						});
   		
   		<?php
   	}
   	
   	// conditional part for Kino Kabaret 2016
   	
   	if ( bp_get_current_profile_group_id() == 15 ) {
   		
   		if ( !in_array( "realisateur", $kino_user_role ) ) {
   			// hide fields
   			?>
   			$("div.field_1258 label[for=field_1268_2]").hide();
   			$("div.field_1258 p.description").hide();
   			<?php
   		}
   		if (!in_array( "comedien", $kino_user_role )) {
   			// hide fields
   			?>
   			$("div.field_1258 label[for=field_1266_0]").hide();
   			<?php
   		}
   		if (!in_array( "technicien", $kino_user_role )) {
   			?>
   			$("div.field_1258 label[for=field_1267_1]").hide();
   			<?php
   			
   		}
   		
   	}
   	
   	 ?>
   	
 });
 </script>
 <?php 
 
  ?>