<?php 

add_action('wp_head', 'kino_wp_head');
function kino_wp_head(){
    
    echo '<style>';
    
    /*
    
    Membres
    #menu-item-1795
    
    My account: 
    #menu-item-633
    
    Login:
    #menu-item-615
    
    Logout:
    #menu-item-632
    
    */
    
    if ( !is_user_logged_in() ) {
    	
    	// Hide Membres & My account
    	?>
    	#menu-item-1795,
    	 #menu-item-633{
    		display: none;
    	}
    	<?php 
    } 
    
    /*
    	Code for Editors and Admin
    */
    
    if ( !current_user_can( 'publish_pages' ) ) {
    	// Hide Admin
    	?>
    	#menu-item-2045 {
    		display: none;
    	}
    	<?php 
    }
    
    echo '</style>';

}

