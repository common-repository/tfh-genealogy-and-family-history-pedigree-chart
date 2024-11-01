<?php

	global $wpdb;
	
	$url = site_url();
	
	$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";

	$table_name2 = $wpdb->prefix . "tfh_pedigree_children";

	$table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";