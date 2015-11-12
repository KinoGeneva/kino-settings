<?php do_action( 'bp_before_profile_edit_content' );

if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) :
	while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
	<div id="checkout-widget-area">
   		<?php dynamic_sidebar( 'Tab Widget Area' ); ?>
	</div>

<form action="<?php kino_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form" class="standard-form <?php bp_the_profile_group_slug(); ?>">

	<?php do_action( 'bp_before_profile_field_content' ); ?>

		<div class="hr-title hr-full hr-double"><abbr><?php printf( __( "Modification de votre profil", "buddypress" ), bp_get_the_profile_group_name() ); ?></abbr></div>
		<div class="gap-10"></div>

		<ul id="button-nav" class="button-nav clearfix">
			
			<?php 
			
//			
//						$kino_role = bp_get_profile_field_data( array(
//								'field'   => '100',
//								'user_id' => bp_loggedin_user_id()
//							) );
//						echo '<pre>';
//						var_dump($kino_role);
//						echo '</pre>';

			// echo '<p>group id: '.bp_get_current_profile_group_id().'</p>';
	
			
			bp_profile_group_tabs(); 
			
			?>

		</ul>

		<div class="clear"></div>
		
		<div class="kino-edit-profile clearfix">

		<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

			<div<?php bp_field_css_class( 'editfield' ); ?>>

				<?php
				$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
				$field_type->edit_field_html();

				do_action( 'bp_custom_profile_edit_fields_pre_visibility' );
				?>

				<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
					<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
						<?php printf( __( 'This field can be seen by: <span class="current-visibility-level">%s</span>', 'buddypress' ), bp_get_the_profile_field_visibility_level_label() ) ?> <a href="#" class="visibility-toggle-link"><?php _e( 'Change', 'buddypress' ); ?></a>
					</p>

					<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
						<fieldset>
							<legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

							<?php bp_profile_visibility_radio_buttons() ?>

						</fieldset>
						<a class="field-visibility-settings-close" href="#"><?php _e( 'Close', 'buddypress' ) ?></a>
					</div>
				<?php else : ?>
					<div class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
						<?php printf( __( 'This field can be seen by: <span class="current-visibility-level">%s</span>', 'buddypress' ), bp_get_the_profile_field_visibility_level_label() ) ?>
					</div>
				<?php endif ?>

				<?php do_action( 'bp_custom_profile_edit_fields' ); ?>

				<p class="description"><?php bp_the_profile_field_description(); ?></p>
			</div>

		<?php endwhile; ?>
		
		</div>

	<?php do_action( 'bp_after_profile_field_content' ); ?>
	
 	<?php 
 	$currenttab = bp_get_current_profile_group_id();
 		
 		if($currenttab === '1') {
 				 dynamic_sidebar( 'Tab Bottom Profil Kinoite' );
 			}
 		if($currenttab === '5') {
 			 dynamic_sidebar( 'Tab Bottom Director Widget Area' );
 		}
 		elseif($currenttab === '6') {
 			 dynamic_sidebar( 'Tab Bottom Comedian Widget Area' );
 		}
 		elseif($currenttab === '10') {
 			 dynamic_sidebar( 'Tab Bottom Identity Widget Area' );
 		}
 		elseif($currenttab === '7') {
 			 dynamic_sidebar( 'Tab Bottom Technician Widget Area' );
 		}
 		elseif($currenttab === '12') {
 			 dynamic_sidebar( 'Tab Bottom Kabaret 1 Widget Area' );
 		}
 		elseif($currenttab === '9') {
 			 dynamic_sidebar( 'Tab Bottom Kabaret 2 Widget Area' );
 		}
 		else {  dynamic_sidebar( 'Tab Bottom Widget Area' ); 
 		} 

 	?>
	

	<div class="submit clearfix">
		<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php esc_attr_e( 'Save Changes', 'buddypress' ); ?> " />
	</div>

	<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_group_field_ids(); ?>" />

	<?php wp_nonce_field( 'bp_xprofile_edit' ); ?>

</form>

<?php bp_get_template_part( 'members/single/profile/edit-jquery' ); ?>

<?php endwhile; endif; ?>

<?php do_action( 'bp_after_profile_edit_content' ); ?>
