<?php

/* Allow Automatic Updates
 ******************************
 * http://codex.wordpress.org/Configuring_Automatic_Background_Updates
 */

// add_filter( 'auto_update_plugin', '__return_true' );
// add_filter( 'auto_update_theme', '__return_true' );
// add_filter( 'allow_major_auto_core_updates', '__return_true' );





/* Allowed FileTypes
 ********************
 * method based on 
 * http://howto.blbosti.com/?p=329
 * List of defaults: https://core.trac.wordpress.org/browser/tags/3.8.1/src/wp-includes/functions.php#L1948
*/

add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {

		// add your extension to the array
		$existing_mimes['svg'] = 'image/svg+xml';
		$existing_mimes['epub'] = 'application/epub+zip';

		// removing existing file types
		unset( $existing_mimes['bmp'] );
		unset( $existing_mimes['tif|tiff'] );

		// and return the new full result
		return $existing_mimes;
}


/*
 * File Upload Security
 
 * Sources: 
 * http://www.geekpress.fr/wordpress/astuce/suppression-accents-media-1903/
 * https://gist.github.com/herewithme/7704370
 
 * See also Ticket #22363
 * https://core.trac.wordpress.org/ticket/22363
 * and #24661 - remove_accents is not removing combining accents
 * https://core.trac.wordpress.org/ticket/24661
*/ 

add_filter( 'sanitize_file_name', 'remove_accents', 10, 1 );
add_filter( 'sanitize_file_name_chars', 'sanitize_file_name_chars', 10, 1 );
 
function sanitize_file_name_chars( $special_chars = array() ) {
	$special_chars = array_merge( array( '’', '‘', '“', '”', '«', '»', '‹', '›', '—', 'æ', 'œ', '€','é','à','ç','ä','ö','ü','ï','û','ô','è' ), $special_chars );
	return $special_chars;
}


/* Dashboard improvement
******************************/

// http://wp.tutsplus.com/tutorials/customizing-wordpress-for-your-clients/
// http://www.wpbeginner.com/wp-tutorials/how-to-remove-wordpress-dashboard-widgets/

function lgm_remove_dashboard_widgets() {
	// Globalize the metaboxes array, this holds all the widgets for wp-admin
	global $wp_meta_boxes;
	
//	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
//	
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	
	// find a way to remove: pmpro_db_widget
	
//
//	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );

	// RSS feeds:
	// unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );

}
add_action( 'wp_dashboard_setup', 'lgm_remove_dashboard_widgets' );

/*

Remove "Edit with Visual Composer" from WordPress Admin Bar

https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=2031624

*/


function vc_remove_wp_admin_bar_button() {
    remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'vc_remove_wp_admin_bar_button' );

/**
 * Show recent posts : 
 * https://gist.github.com/ms-studio/6069116
 */

function wps_recent_posts_dw() {
?>
   <ul class="dash-recent-posts">
   	<style>
   			.dash-recent-posts {
   				list-style-type: none;
   				padding-left: 0;
   			}
   			.dash-recent-posts .separator {
   				padding: 0 0.4em;
   			}
   		</style>
     <?php
          global $post;
          $args = array( 
          	'numberposts' => 7,
          	'post_type' => array( 'post', 'page', 'feature', 'object' ),
          	 );
          $myposts = get_posts( $args );
                foreach( $myposts as $post ) :  setup_postdata($post); 
                      
                          $post_edit_link = admin_url().'post.php?post='.get_the_ID().'&action=edit' ;
                          $sprtr = '<span class="separator">–</span>';
                      	
                      ?>
                          <li>
                          <?php the_date('j F','',''); echo $sprtr; ?>
                          <b><a href="<?php echo $post_edit_link; ?>"><?php the_title(); ?></a></b> 
                          <?php echo $sprtr; ?><span class=""><a href="<?php echo $post_edit_link; ?>">modifier</a> • 
                          <a href="<?php the_permalink(); ?>">voir</a></span></li>
                <?php endforeach; ?>
   </ul>
<?php
}
function add_wps_recent_posts_dw() {
       wp_add_dashboard_widget( 'wps_recent_posts_dw', __( 'Recent Posts' ), 'wps_recent_posts_dw' );
}
add_action('wp_dashboard_setup', 'add_wps_recent_posts_dw' );


/*
* End of file
*/
