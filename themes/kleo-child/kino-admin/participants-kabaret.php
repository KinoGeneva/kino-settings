<?php
/**
 * Un template pour valider les inscriptions
 */
?>

<?php
$extra_classes = 'clearfix';
if ( get_cfield( 'centered_text' ) == 1 )  {
    $extra_classes .= ' text-center';
}
?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class($extra_classes); ?>>

    <div class="article-content">
        <?php the_content(); ?>
        
        <?php 
        
        /*
         * Une page pour faciliter la gestion des inscriptions kino
        ***************
        
        - Total of users
        
        - in group: Kinogeneva 2016 (pending)
        
        - in group: real.plateforme (pending)
        
        - in group: real.kino (pending)
        
        ****/
        	
        $kino_debug_mode = 'off';
        
        $user_fields = array( 
        	'user_login', 
        	'user_nicename', 
        	'display_name',
        	'user_email', 
        	'ID' 
        );
        
        $user_query = new WP_User_Query( array( 
        	'fields' => $user_fields 
        ) );
        
        // Réalisateur-trice en attente : Kabaret 2016
        $kino_pending_real_kab = array();
        
        // Réalisateur-trice en attente : Plateforme
        $kino_pending_real_platform = array();
        
        // Réalisateur-trice validé : Kabaret 2016
        $kino_valid_real_kab = array();
        
        // Réalisateur-trice validé : Plateforme
        $kino_valid_real_platform = array();
                
        $kino_fields = kino_test_fields();
        
        
        //***************************************
        
        // Quel est le total d'utilisateurs?
        
        echo '<p>Total des utilisateurs sur la plateforme: '.count( $user_query ) .'</p>';
        
        
        // Combien dans le groupe : Kinogeneva 2016 (pending) : non automatique !!
        
        // Combien dans le groupe : Participants Kino 2016 : profil complet
                
        $ids_of_kino_complete = get_objects_in_term( 
        	$kino_fields['group-kino-complete'] , 
        	'user-group' 
        );
        
        // Combien dans le groupe : real.plateforme (pending)
        
        $ids_of_real_platform_pending = get_objects_in_term( 
        	$kino_fields['group-real-platform-pending'] , 
        	'user-group' 
        );
        
        // Combien dans le groupe : real.kino (pending)
        
        $ids_of_real_kabaret_pending = get_objects_in_term( 
        	$kino_fields['group-real-kabaret-pending'] , 
        	'user-group' 
        );
        
        
         ?>
        
    </div><!--end article-content-->

    <?php  ?>
</article>
<!-- End  Article -->

