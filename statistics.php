<?php 

/*
 * Ajout du code Google Analytics
*/

function kino_google_analytics() { 

		$host = $_SERVER['HTTP_HOST'];
		
		if ( $host == 'kinogeneva.ch' ) {
		
			// <!-- Global site tag (gtag.js) - Google Analytics -->
		
			?>
			<script async src="https://www.googletagmanager.com/gtag/js?id=UA-57694141-1"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());
			
			  gtag('config', 'UA-57694141-1');
			</script>
			<?php
		
		}
		
}
add_action( 'wp_head', 'kino_google_analytics', 10 );


/*
 * add snippet for Mixpanel user tracking
*/

function kino_mixpanel_id() {

			// test if user is logged in:
			
			if ( is_user_logged_in() ) {
				
				$host = $_SERVER['HTTP_HOST'];
				 if ( $host == 'kinogeneva.ch' ) {
				
						$kino_usr_id = bp_loggedin_user_id();
						$kino_user_info = get_userdata( bp_loggedin_user_id() );
						
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

}
add_action('wp_footer', 'kino_mixpanel_id', 99);


 ?>