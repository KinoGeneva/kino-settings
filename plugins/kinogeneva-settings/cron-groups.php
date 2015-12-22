<?php 

// On ajoute des inscrits à la Newsletter Kino, selon les User-Groups


//if ( ! wp_next_scheduled( 'kino_task_hook' ) ) {
//  wp_schedule_event( time(), 'hourly', 'kino_task_hook' );
//}
//
//add_action( 'kino_task_hook', 'kino_task_function' );



// add_action( 'init', 'kino_task_function' );



function kino_task_function() {
  
  // check for users in group "Kino 2016":
  // $userIDs = get_objects_in_term( 65, 'user-group');
  
  $userIDs = array();
  
  $userIDs[] = '203'; // Manuel
  
  // Add them to the newsletters
  foreach ($userIDs as $k => $id) {
  
    $user_info = get_user_by( 'id', $id );
    
    $user_data = array(
            'email' => $user_info->user_email,
            'firstname' => $user_info->first_name,
            'lastname' => $user_info->last_name);
    
    $data_subscriber = array(
          'user' => $user_data,
          'listid' => array('list_ids' => array(4,5))
        );
     
    $helper_user = WYSIJA::get('user','helper');
    // $helper_user->addSubscriber($data_subscriber);
    $helper_user->addToList(
        $data_subscriber['listid'],
        $userIDs, 
        true);
    
   }
  
}



 ?>