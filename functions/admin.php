<?php
/**
 * @package WordPress
 */


// CUSTOM ADMIN DASHBOARD HEADER LOGO
 
//function custom_admin_logo() {
//    echo '<style type="text/css">#wp-admin-bar-wp-logo { display:none;  }</style>';
//}
//add_action('admin_head', 'custom_admin_logo');

function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
}
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );


/**
 * remove WordPress Howdy : http://www.redbridgenet.com/?p=653
 */
function goodbye_howdy ( $wp_admin_bar ) {
    $avatar = get_avatar( get_current_user_id(), 16 );
    if ( ! $wp_admin_bar->get_node( 'my-account' ) )
        return;
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => sprintf( '%s', wp_get_current_user()->display_name ) . $avatar,
    ) );
}
add_action( 'admin_bar_menu', 'goodbye_howdy' );


function modify_footer_admin ()
{
    echo '<span id="footer-thankyou">&nbsp;</span>';
}
add_filter('admin_footer_text', 'modify_footer_admin');


/**
 * Remove Menu Pages
 ****************
 * http://codex.wordpress.org/Function_Reference/remove_menu_page
 */


function kgva_remove_menus() {
  remove_menu_page( 'edit.php?post_type=kleo-testimonials' );
  remove_menu_page( 'edit.php?post_type=kleo_clients' );
  // remove user types from WP User Groups plugin
  $page = remove_submenu_page( 'users.php', 'edit-tags.php?taxonomy=user-type' );
}
add_action( 'admin_menu', 'kgva_remove_menus', 999);

/// http://kinogeneva.4o4.ch/wp-admin/edit.php?post_type=kleo-testimonials
/// http://kinogeneva.4o4.ch/wp-admin/edit.php?post_type=kleo_clients

add_action('manage_users_columns','kgva_remove_users_columns');
function kgva_remove_users_columns($column_headers) {
    unset($column_headers['posts']);
    unset($column_headers['backwpup_role']);
    return $column_headers;
}
