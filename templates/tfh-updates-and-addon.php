<?php


//create page content and options

 function tfh_create_tfh_updates_and_addons(){
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "tfh_pedigree_chart";
	
	$family_members = $wpdb->get_results( "SELECT id, first_name, last_name, sex, family_id, post_id, image FROM $table_name" );
	
	
	
	$siteUrl = site_url();
	
	?>
	
	<h1> TFH Genalogy Plugin Help </h1>
	
	<br />

	<h2>Important Notes:</h2>

	<h3>COLORS</h3>
	<p>Use the Hexadecimal Format</p> 
	<p>For example: for Black use #000000 , for White use #ffffff etc</p>  

	<p>Use Leading #</p>  

	<h3> WIDTHS AND MARGINS </h3> 
	<p>Use a % for both. For example: Table Width 50% , Margin Left 10% ,Margin Right 40%</p>  


	<h3>FONT SIZE</h3>  
	<p>Use numbers. For example: 12px or 12.5px</p>  

	<p>Use px at the end.</p> 

	<h3>FONT WEIGHT</h3>  

	<p>bold, normal, inherit</p>  

	<h3>FONT STYLE</h3>  

	<p>normal, italic, oblique, inherit</p>  

	<h3>TEXT TRANSFORM</h3>  

	<p>none, capitalize, uppercase, lowercase, inherit </p> 

	<h3>TEXT DECORATION</h3> 

	<p>none, underline, overline, line-through, blink, inherit</p> 

	



<?php

 }