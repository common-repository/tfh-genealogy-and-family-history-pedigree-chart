<?php

function add_custom_query_var1( $vars ){
  $vars[] = "id";
  return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var1' );


function add_custom_query_var2( $vars ){
  $vars[] = "children_id";
  return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var2' );

function add_custom_query_var3( $vars ){
  $vars[] = "partner_id";
  return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var3' );

function add_custom_query_var4( $vars ){
  $vars[] = "id_to_delete";
  return $vars;
}
add_filter( 'query_vars', 'add_custom_query_var4' );