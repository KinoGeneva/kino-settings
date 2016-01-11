<?php

// source: http://wordpress.stackexchange.com/questions/211703/need-a-simple-but-complete-example-of-adding-metabox-to-taxonomy
// code authored by jgraup - http://wordpress.stackexchange.com/users/84219/jgraup


// REGISTER TERM META

add_action( 'init', 'kino_register_term_meta' );

function kino_register_term_meta() {

    register_meta( 'term', 'kino_nombre_couchages', '___sanitize_term_meta_text' );
    register_meta( 'term', 'kino_adresse_logement', '___sanitize_term_meta_text' );
}

// SANITIZE DATA

function ___sanitize_term_meta_text ( $value ) {
    return sanitize_text_field ($value);
}

// GETTER (will be sanitized)

function ___get_term_meta_text( $term_id, $term_key ) {
  $value = get_term_meta( $term_id, $term_key, true );
  $value = ___sanitize_term_meta_text( $value );
  return $value;
}

// ADD FIELD TO CATEGORY TERM PAGE

add_action( 'user-logement_add_form_fields', '___add_form_field_term_meta_text' );

function ___add_form_field_term_meta_text() { ?>

    <?php wp_nonce_field( basename( __FILE__ ), 'term_meta_text_nonce' ); ?>
    <div class="form-field term-meta-couchage-wrap">
        <label for="term-meta-couchage">Nombre de couchages</label>
        <input type="number" name="term_meta_couchage" id="term-meta-couchage" value="" class="term-meta-couchage-field" />
    </div>
    <div class="form-field term-meta-adresse-wrap">
        <label for="term-meta-adresse">Adresse du logement</label>
        <input type="text" name="term_meta_adresse" id="term-meta-adresse" value="" class="term-meta-adresse-field" />
    </div>

<?php }


// ADD FIELD TO CATEGORY EDIT PAGE

add_action( 'user-logement_edit_form_fields', '___edit_form_field_term_meta_text' );

function ___edit_form_field_term_meta_text( $term ) {

    $value_couchage  = ___get_term_meta_text( $term->term_id, 'kino_nombre_couchages' );
    
    $value_logement  = ___get_term_meta_text( $term->term_id, 'kino_adresse_logement' );

    if ( ! $value_couchage )
        $value_couchage = ""; 
    
    if ( ! $value_logement )
        $value_logement = "";     
    
    wp_nonce_field( basename( __FILE__ ), 'term_meta_text_nonce' );
    
    ?>
		
    <tr class="form-field term-meta-couchage-wrap">
        <th scope="row"><label for="term-meta-couchage">Nombre de couchages</label></th>
        <td>
            <input type="number" name="term_meta_couchage" id="term-meta-couchage" value="<?php echo esc_attr( $value_couchage ); ?>" class="term-meta-couchage-field"  />
        </td>
    </tr>
    
    <tr class="form-field term-meta-adresse-wrap">
        <th scope="row"><label for="term-meta-adresse">Adresse du logement</label></th>
        <td>
            <input type="text" name="term_meta_adresse" id="term-meta-adresse" value="<?php echo esc_attr( $value_logement ); ?>" class="term-meta-adresse-field"  />
        </td>
    </tr>
<?php }


// SAVE TERM META (on term edit & create)

add_action( 'edit_user-logement',   'kino_save_term_meta' );
add_action( 'create_user-logement', 'kino_save_term_meta' );

function kino_save_term_meta( $term_id ) {

    // verify the nonce --- remove if you don't care
    if ( ! isset( $_POST['term_meta_text_nonce'] ) || ! wp_verify_nonce( $_POST['term_meta_text_nonce'], basename( __FILE__ ) ) )
        return;
        
		// get the values
    $old_value_couchages  = ___get_term_meta_text( $term_id, 'kino_nombre_couchages' );
    $new_value_couchages = isset( $_POST['term_meta_couchage'] ) ? ___sanitize_term_meta_text ( $_POST['term_meta_couchage'] ) : '';
    
    $old_value_adresse  = ___get_term_meta_text( $term_id, 'kino_adresse_logement' );
    $new_value_adresse = isset( $_POST['term_meta_adresse'] ) ? ___sanitize_term_meta_text ( $_POST['term_meta_adresse'] ) : '';

		// save the values
    if ( $old_value_couchages && '' === $new_value_couchages ) {
    	delete_term_meta( $term_id, 'kino_nombre_couchages' );
    } else if ( $old_value_couchages !== $new_value_couchages ) {
	    update_term_meta( $term_id, 'kino_nombre_couchages', $new_value_couchages );
    }
        
   	if ( $old_value_adresse && '' === $new_value_adresse ) {
   		delete_term_meta( $term_id, 'kino_adresse_logement' );
   	} else if ( $old_value_adresse !== $new_value_adresse ) {
	   	update_term_meta( $term_id, 'kino_adresse_logement', $new_value_adresse );
	  }
	  
} // end function


