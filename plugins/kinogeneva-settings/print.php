<?php 

/* Things we need for the print functionality
 *
*/


function kino_query_vars_filter( $vars ){
  $vars[] = "kinorole";
  $vars[] = "kinodate";
  $vars[] = "kinodebug";
  return $vars;
}
add_filter( 'query_vars', 'kino_query_vars_filter' );