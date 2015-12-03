<?php do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : 

	// Test what groups we need to show!
	// liste des groupes existants
	$groups = wp_cache_get( 'all', 'bp_xprofile_groups' );
	if ( false === $groups ) {
		$groups = bp_xprofile_get_groups( array( 'fetch_fields' => true ) );
		wp_cache_set( 'all', $groups, 'bp_xprofile' );
	}
	
	$kino_allowed_groups = kino_get_field_group_conditions( $groups );
	$kino_allowed_group_ids = array();
	
	foreach( $kino_allowed_groups as $item ){ 
	  $kino_allowed_group_ids[] = $item->id;
	   			//echo $item->name;
	}
	
//	echo '<pre>Allowed ids:';
//	var_dump($kino_allowed_group_ids);
//	echo '</pre>';

?>

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); 
	
			// test if group ID... bp_the_profile_group_id() 
			
			// echo '<p>group id:'.bp_get_the_profile_group_id() .'</p>';
			
			if ( in_array( bp_get_the_profile_group_id(), $kino_allowed_group_ids ) ) :
			
			 // echo '<p>(showing group:'.bp_get_the_profile_group_id() .': '.bp_get_the_profile_group_name().')</p>';
	?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php do_action( 'bp_before_profile_field_content' ); ?>

			<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">
		
				<div class="hr-title hr-full hr-double"><abbr><?php bp_the_profile_group_name(); ?></abbr></div>
				<div class="gap-10"></div>
					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<?php if ( bp_field_has_data() ) : ?>
              
              <dl<?php bp_field_css_class('dl-horizontal'); ?>>
                <dt><?php bp_the_profile_field_name(); ?></dt>
                <dd><?php bp_the_profile_field_value(); ?></dd>
              </dl>

						<?php endif;  // bp_field_has_data()  ?>

						<?php do_action( 'bp_profile_field_item' ); ?>

					<?php endwhile; ?>

			</div><!-- end bp-widget -->

			<?php do_action( 'bp_after_profile_field_content' ); ?>
		
		<?php else : // no fields
		
		// echo '<p>group:'.bp_get_the_profile_group_id() .' has no fields</p>';
		
		  endif; // bp_profile_group_has_fields() ?>
		
		<?php else : // in_array() 
		
			// echo '<p>exluded group id:'. echo bp_get_the_profile_group_id(); .'</p>';
		
		endif; // in_array() ?>

	<?php endwhile; ?>

	<?php do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php do_action( 'bp_after_profile_loop_content' ); ?>
