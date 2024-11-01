<?php


//create page content and options

 function tfh_add_help(){
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "tfh_pedigree_chart";
	
	$family_members = $wpdb->get_results( "SELECT id, first_name, last_name, sex, family_id, post_id, image FROM $table_name" );
	
	
	
	$siteUrl = site_url();
	
	?>
	
	<h1> TFH Family History and Genealogy Plugin </h1>
	



<?php

 }