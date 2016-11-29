<?php 


// add snippet for Mixpanel user tracking


function kino_mixpanel_id() {

			// test if user is logged in:
//			global $bp;
//			//is there a user to check?
//			global $user;
//			
//			echo '<div class="hidden">';
//			var_dump($user);
//			echo 'id = '.bp_loggedin_user_id();
//			echo '</div>';
			
			if ( is_user_logged_in() ) {
				
				// get WP user data
				// info: https://codex.wordpress.org/Database_Description#Table:_wp_users
				//  
//				echo '<div class="hidden">';
//				echo 'id = '.bp_loggedin_user_id();
				
				$kino_usr_id = bp_loggedin_user_id();
				$kino_user_info = get_userdata( bp_loggedin_user_id() );
				
//				var_dump($kino_user_info);
//				
//				echo '</div>';
				
//				$kino_usr_id = $user->ID;
//				$kino_usr_firstname = $user->first_name;
//				$kino_usr_lastname = $user->last_name;
//				$kino_usr_email = $user->user_email;
//				$kino_usr_created = $user->datetime;
				
				?>
				<script type="text/javascript">
				mixpanel.identify("<?php echo $kino_usr_id; ?>");
				mixpanel.people.set({
				    "$first_name": "<?php echo $kino_user_info->first_name; ?>",
				    "$last_name": "<?php echo $kino_user_info->last_name; ?>",
				    "$created": "<?php echo $kino_user_info->user_registered; ?>",
				    "$email": "<?php echo $kino_user_info->user_email; ?>",
				    "login": "<?php echo $kino_user_info->user_login; ?>",
				    "display-name": "<?php echo $kino_user_info->display_name; ?>"
				});
				</script>
				<?php
			}

}
add_action('wp_footer', 'kino_mixpanel_id', 99);



 ?>