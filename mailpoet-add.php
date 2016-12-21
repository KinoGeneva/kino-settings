<?php

//get mailpoet ids
//WP codex: https://codex.wordpress.org/Class_Reference/wpdb
function getMailpoetId($userid) {
	$mailpoetIdrows = $GLOBALS['wpdb']->get_row( "SELECT user_id,wpuser_id FROM wp_wysija_user WHERE wpuser_id = ". $userid );
	if ( null !== $mailpoetIdrows ) {
		return $mailpoetIdrows->user_id;
	}
	else {
		return false;
	}
}

//ajout et suppressions d'utilisateurs WP aux listes mailpoet (déplacé de ajax.php)

function kino_add_to_mailpoet_list( $user, $list ) {
	
	/**
	 * addToList()
	 * in: helpers/user.php
	 * add many subscribers to one list
	 * @param int $list_id
	 * @param int $user_ids
	 * @return boolean
	 */
	 
	$helper_user = WYSIJA::get('user','helper');
	
	if ( !is_array($user) ) {
		$user = array($user);
	}
	
	$helper_user->addToList(
	    $list,
	    $user
	 );

}

function kino_add_to_mailpoet_list_array( $user, $list ) {
	 
	$helper_user = WYSIJA::get('user','helper');
	$helper_user->addToList(
	    $list,
	    $user
	 );

}

function kino_remove_from_mailpoet_list( $user, $list ) {
	
	$helper_user = WYSIJA::get('user','helper');
	$helper_user->removeFromLists(
	    array($list),
	    array($user)
	 );

}
