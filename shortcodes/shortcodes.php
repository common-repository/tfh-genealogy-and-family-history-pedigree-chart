<?php

// Create the Name Shortcode


function tfh_pedigree_page( $atts ) {
	
	extract( shortcode_atts( array(
		
		'id' => '',

		), $atts ) );

		ob_start();

		// Obtain Image name for the page id

       
		global $wpdb;

		$siteUrl = get_site_url();
		
		
		
		$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";

		$table_name2 = $wpdb->prefix . "tfh_pedigree_children";

		$table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";

		$living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$id'" );
		
		$firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$id'" );
		
		$lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$id'" );
		
		$image = $wpdb->get_var( "SELECT image FROM $table_name1 WHERE id = '$id'" );
		
		$birthDate = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$id'" );

        $sex = $wpdb->get_var( "SELECT sex FROM $table_name1 WHERE id = '$id'" );
		
		$deathDate = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$id'" );

		if ($living != 'Living') {

			/* HEADER SECTION */

            $out =      "<header class='tfh_header_section'>";

            $out .=         "<div id='tfh_image'> ";

            $out .=             "<img src='$image'>";

            $out .=         "</div>";

            $out .=         "<div id='tfh_title'>";

            $out .=             "<p><span class='tfh_firstname'>$firstName</span>"; 

            $out .=             "<br />";

            $out .=             "<span class='tfh_lastname'>$lastName</span> </p>"; 

            $out .=             "<p><span class='tfh_dates'>Date of Birth: </span><span class='tfh_dates_text'>$birthDate</span>";

            $out .=             "<br />";

            if ( $deathDate != 'Not Deceased') { 

            $out .=             "<span class='tfh_dates'>Date of Death: </span><span class='tfh_dates_text'>$deathDate</span></p>";

            }           

            $out .=         "</div>";

            $out .=     "</header>";

		    $out .= 	"<section id='tfh_pedigree_chart'>";

		    

		    /* PEDIGREE CHART SECTION */



            $firstPerson = $firstName . ' ' .  $lastName;


            $out .=   "<h3 class='table_list_heading'>Pedigree Chart</h3>";

            $out .=   "<table class='tfh_list_boxes'><thead><tr id='tfh_pedigree_row'><th>";

            $out .=   "</th></tr><thead></table>";

            $out .=     "<div class='tfh_chart_section'>";

            $out .=         "<div class='firstGen'>";

            if (isset($firstPerson)){
				
				if ($sex == 'Female') {

                $out .=         "<div id='first_box' class='first_box box female_box'>";

                } else {

                      $out .=         "<div id='first_box' class='first_box box male_box'>";   

                }

                $out .=             "<strong>$firstPerson</strong>";

                $out .=             "<br />";

                $out .=             "B: $birthDate";

                $out .=             "<br />";

                $out .=             "D: $deathDate";

                $out .=         "</div><!-- end div first_box -->";

        }

            $out .=         "</div><!-- end div firstGen -->";

                    /* Father */

        if (isset($id) ){

            $father_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Father'" );

        }

        $fpost_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$father_id'" );

        $ffirstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$father_id'" );
        
        $flastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$father_id'" );
        

        $father = $ffirstName . ' ' . $flastName;

        $fbirthDate = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$father_id'" );
        
        $fdeathDate = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$father_id'" );

            
            $out .=     "<div class='secondGen'>";

            if (isset($father_id)){
				
			$out .=         "<div id='second_box' class='second_box box male_box'>";

            $out .=             "<a href='$siteUrl/?p=$fpost_id'>$father</a>";

            $out .=             "<br />";

            $out .=             "B: $fbirthDate";

            $out .=             "<br />";

            $out .=             "D: $fdeathDate";

            $out .=         "</div><!-- end div second_box -->";
       
        }

         /* Mother */

        if (isset($id) ){

        $mother_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Mother'" );

        }

        $mpost_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$mother_id'" );

        $mfirstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$mother_id'" );
        
        $mlastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$mother_id'" );
        

        $mother = $mfirstName . ' ' . $mlastName;

        $mbirthDate = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$mother_id'" );
        
        $mdeathDate = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$mother_id'" );

        if (isset($mother_id)){

            $out .=         "<div id='third_box' class='third_box box female_box'>";

            $out .=             "<a href='$siteUrl/?p=$mpost_id'>$mother</a>";

            $out .=             "<br />";

            $out .=             "B: $mbirthDate";

            $out .=             "<br />";

            $out .=             "D: $mdeathDate";

            $out .=         "</div><!-- end div third_box -->";

        }

            $out .=     "</div><!-- end div second_gen -->";

            $out .=     "<div><!-- end div second_gen -->";

            $out .=     "</div><!-- end div second_gen -->";

    /* Fathers Father */

        if (isset($father_id) ){

        $ffather_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $father_id AND family_link_role = 'Father'" );


        $ffpost_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$ffather_id'" );

        $fffirstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$ffather_id'" );
        
        $fflastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$ffather_id'" );
        

        $ffather = $fffirstName . ' ' . $fflastName;

        $ffbirthDate = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$ffather_id'" );
        
        $ffdeathDate = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$ffather_id'" );

            $out .=     "<div class='thirdGen'>";
			
			$out .= 	  "<div class='thirdGen_first2'>";

            if (isset($ffather_id)){

            $out .=         "<div id='fourth_box' class='fourth_box box male_box'>";

            $out .=             "<a href='$siteUrl/?p=$ffpost_id'>$ffather</a>";

            $out .=             "<br />";

            $out .=             "B: $ffbirthDate";

            $out .=             "<br />";

            $out .=             "D: $ffdeathDate";

            $out .=         "</div><!-- end div fourth_box -->";
       
        } }


        /* Fathers Mother */

       if (isset($father_id) ){

        $fmother_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $father_id AND family_link_role = 'Mother'" );

        $fmpost_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$fmother_id'" );

        $fmfirstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$fmother_id'" );
        
        $fmlastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$fmother_id'" );
        

        $fmother = $fmfirstName . ' ' . $fmlastName;

        $fmbirthDate = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$fmother_id'" );
        
        $fmdeathDate = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$fmother_id'" );

        if (isset($fmother_id)){

            $out .=         "<div id='fifth_box' class='fifth_box box female_box'>";

            $out .=             "<a href='$siteUrl/?p=$fmpost_id'>$fmother</a>";

            $out .=             "<br />";

            $out .=             "B: $fmbirthDate";

            $out .=             "<br />";

            $out .=             "D: $fmdeathDate";

            $out .=         "</div><!-- end div fifth_box -->";
			
			$out .=         "</div><!-- end div thirdGen_first2 -->";

        } }


        /* Mothers Father */

        if (isset($mother_id) ){

        $mfather_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $mother_id  AND family_link_role = 'Father'" );

        $mfpost_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$mfather_id'" );

        $mffirstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$mfather_id'" );
        
        $mflastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$mfather_id'" );
        

        $mfather = $mffirstName . ' ' . $mflastName;

        $mfbirthDate = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$mfather_id'" );
        
        $mfdeathDate = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$mfather_id'" );

        if (isset($mfather_id)){
			
			$out .= 	  "<div class='thirdGen_second2'>";

            $out .=         "<div id='sixth_box' class='sixth_box box male_box'>";

            $out .=             "<a href='$siteUrl/?p=$mfpost_id'>$mfather</a>";

            $out .=             "<br />";

            $out .=             "B: $mfbirthDate";

            $out .=             "<br />";

            $out .=             "D: $mfdeathDate";

            $out .=         "</div><!-- end div sixth_box -->";
       
        } }

        /* Mothers Mother */

        if (isset($mother_id) ){

        $mmother_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$mother_id' AND family_link_role = 'Mother'" );

        $mmpost_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$mmother_id'" );

        $mmfirstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$mmother_id'" );
        
        $mmlastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$mmother_id'" );
        

        $mmother = $mmfirstName . ' ' . $mmlastName;

        $mmbirthDate = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$mmother_id'" );
        
        $mmdeathDate = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$mmother_id'" );

         if (isset($mmother_id)){

            $out .=         "<div id='seventh_box' class='seventh_box box female_box'>";

            $out .=             "<a href='$siteUrl/?p=$mmpost_id'>$mmother</a>";

            $out .=             "<br />";

            $out .=             "B: $mmbirthDate";

            $out .=             "<br />";

            $out .=             "D: $mmdeathDate";

            $out .=         "</div><!-- end div seventh_box -->";

            $out .=     "</div><!-- end div third_gen -->";
			
			$out .=     "</div><!-- end div third_gen -->";

        }  }
            $out .=     "</div><!-- end div thirdGen_second2 -->";

		    $out .= 	"</section> <!-- End tfh_pedigree_chart section  -->";



	/* MARRIAGE LIST SECTION */

		$marriage_status_id = $wpdb->get_results( "SELECT * FROM $table_name3 WHERE person_id = '$id'" );

		$current_marriage_status = $wpdb->get_var( "SELECT marriage_status FROM $table_name3 WHERE person_id = '$id'" );

        

		if (!empty($marriage_status_id)) {

			if ($current_marriage_status != 'never_married') {
	
			$out .=   "<h3 class='table_list_heading'>Marriage Status </h3>";

            $out .=     "<section id='tfh_list_boxes'>";

            $out .=         "<table class='tfh_list_boxes'>";

            $out .=         "<thead>";

            $out .=         	"<tr>";

            $out .=         		"<th>ID</th>";

            $out .=         		"<th>Name</th>";

            $out .=         		"<th>Status</th>";

            $out .=         		"<th>Event Date</th>";

            $out .=         	"</tr>";

            $out .=         "</thead>";

            $out .=         "<tbody>";

            				foreach ($marriage_status_id as $marriage_status_id) {
            
            					$ms_id = $marriage_status_id->partner_id;

            					$ms_status = $marriage_status_id->marriage_status;

            					$ms_event_date = $marriage_status_id->event_date;

            					$firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$ms_id'" );

            					$lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$ms_id'" );

            					$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$ms_id'" );

            					$name = $firstName . ' ' . $lastName;

            $out .=         		"<tr>";

            $out .=         			"<td>$ms_id</td>";

            $out .=         			"<td><a href='$siteUrl/?p=$post_id'>$name</a></td>";

            $out .=         			"<td>$ms_status</td>";

            $out .=         			"<td>$ms_event_date</td>";           

            $out .=         		"</tr>";

            				} 	;

            $out .=         "</tbody>";

            $out .=         "</table>";

            $out .= 	"</section> <!-- tfh_list_boxes  -->";
	    	
			} 
			
		}
		
		if (empty($marriage_status_id)) {
			
			$out .= 	"";
		}
		

        /* CHILD LIST SECTION */

		$marriage_child_id = $wpdb->get_results( "SELECT * FROM $table_name2 WHERE parent_id = '$id'" );
		

		if (!empty($marriage_child_id)) {
	
			$out .=   "<h3 class='table_list_heading'>Children </h3>";

            $out .=     "<section id='tfh_list_boxes'>";

            $out .=         "<table class='tfh_list_boxes'>";

            $out .=         "<thead>";

            $out .=         	"<tr>";

            $out .=         		"<th class='person_id'>ID</th>";

            $out .=         		"<th>Name</th>";

            $out .=         		"<th class='person_birth'>Birth Date</th>";

            $out .=         	"</tr>";

            $out .=         "</thead>";

            $out .=         "<tbody>";

            				foreach ($marriage_child_id as $marriage_child_id) {
            
            					$child_id = $marriage_child_id->child_id;
								
								$child_living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$child_id'" );
								
								if ($child_living != 'Living') {

									$birth_date = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$child_id'" );
	;

									$firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$child_id'" );

									$lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$child_id'" );

									$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$child_id' ");

									$name = $firstName . ' ' . $lastName;
								
								} else {
									
									$child_id = $marriage_child_id->child_id;
									
									$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$child_id' ");
									
									$birth_date = "";
									$name = "Living";
								}

            $out .=         		"<tr>";

            $out .=         			"<td>$child_id</td>";

            $out .=         			"<td><a href='$siteUrl/?p=$post_id'>$name</a></td>";

            $out .=         			"<td>$birth_date</td>";           

            $out .=         		"</tr>";

            				} 	;

            $out .=         "</tbody>";

            $out .=         "</table>";

            $out .= 	"</section> <!-- tfh_list_boxes  -->";
	    	
        }
		
		
		
		/* SIBLING LIST SECTION */

        $father_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Father'" );
		
		$mother_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Mother'" );
		
		/* $sibling_id = $wpdb->get_results( "SELECT child_id FROM $table_name2 WHERE parent_id = '$father_id' OR parent_id = '$mother_id' AND NOT child_id ='$id' AND (NOT parent_id ='Unknown') "); */
		
		$sibling_id = $wpdb->get_results( "SELECT DISTINCT child_id FROM $table_name2 WHERE ( parent_id = '$father_id' OR parent_id = '$mother_id' ) AND NOT child_id ='$id' AND (NOT parent_id ='Unknown')");
		
		$father_sibling_id = $wpdb->get_results( "SELECT child_id FROM $table_name2 WHERE parent_id = '$father_id' AND NOT child_id ='$id' AND (NOT parent_id ='Unknown') ");
		
		$m_sibling_id = $wpdb->get_results( "SELECT child_id FROM $table_name2 WHERE parent_id = '$mother_id' AND NOT child_id ='$id' AND (NOT parent_id ='Unknown') ");
		
		if (!empty($sibling_id )) {
			
			$out .=   "<h3 class='table_list_heading'>Siblings</h3>";

            $out .=     "<section id='tfh_list_boxes'>";

            $out .=         "<table class='tfh_list_boxes'>";

            $out .=         "<thead>";

            $out .=             "<tr>";

            $out .=                 "<th class='person_id'>ID</th>";

            $out .=                 "<th>Name</th>";

            $out .=                 "<th class='person_birth'>Birth Date</th>";

            $out .=             "</tr>";

            $out .=         "</thead>";

            $out .=         "<tbody>";

            foreach ($sibling_id as $sibling_id) {
                                
                $f_sibling_id = $sibling_id->child_id;
				
				$sib_mother_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$f_sibling_id' AND family_link_role = 'Mother'" );
				
				$sib_father_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$f_sibling_id' AND family_link_role = 'Father'" );
				
				$orig_mother_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Mother'" ); 
				
				$orig_father_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Father'" );
									
					$child_living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$f_sibling_id'" );
					
					if ($child_living != 'Living') {
										
						$birth_date = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$f_sibling_id'" );
		

						$firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$f_sibling_id'" );

						$lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$f_sibling_id'" );

						$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$f_sibling_id' ");

						$name = $firstName . ' ' . $lastName;

					} else {
										
																			
						$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$f_sibling_id' ");
										
						$birth_date = "";
										
						$name = "Living";
										
					}
					
							
					$out .=                 "<tr>";

					$out .=                     "<td>$f_sibling_id</td>";

					$out .=                     "<td><a href='$siteUrl/?p=$post_id'>$name</a></td>";

					$out .=                     "<td>$birth_date</td>";           

					$out .=                 "</tr>";
				
			} 

            $out .=         "</tbody>";

            $out .=         "</table>";

            $out .=     "</section> <!-- tfh_list_boxes  -->";
            
       
		}
		
		/* Sibings from Father Only
		
		$fthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Father'" );
		
		$mthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Mother'" );
		
		$fthr_sibling_id = $wpdb->get_results( "SELECT child_id FROM $table_name2 WHERE parent_id = '$fthr_id ' AND NOT child_id ='$id' AND (NOT parent_id ='Unknown') ");
		
		
		if (!empty($fthr_sibling_id )) {
    
            $out .=   "<h3 class='table_list_heading'>Siblings From Father Only</h3>";

            $out .=     "<section id='tfh_list_boxes'>";

            $out .=         "<table class='tfh_list_boxes'>";

            $out .=         "<thead>";

            $out .=             "<tr>";

            $out .=                 "<th class='person_id'>ID</th>";

            $out .=                 "<th>Name</th>";

            $out .=                 "<th class='person_birth'>Birth Date</th>";

            $out .=             "</tr>";

            $out .=         "</thead>";

            $out .=         "<tbody>";

            foreach ($fthr_sibling_id as $fthr_sibling_id) {
                                
                $fthr_sibling_id = $fthr_sibling_id->child_id; 
				
				$sib_mthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$fthr_sibling_id' AND family_link_role = 'Mother'" );
				
				$orig_fthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Father'" );
				
				$orig_mthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Mother'" );
									
				$child_living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$fthr_sibling_id'" );
				
				if ($sib_mthr_id != $orig_mthr_id) {
		
					if ($child_living != 'Living') {
											
							$birth_date = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$fthr_sibling_id'" );
			
							$firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$fthr_sibling_id'" );

							$lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$fthr_sibling_id'" );

							$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$fthr_sibling_id' ");

							$name = $firstName . ' ' . $lastName;

					} else {
											
																				
							$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$fthr_sibling_id' ");
											
							$birth_date = "";
											
							$name = "Living";
											
					}
							
			$out .=                 "<tr>";

            $out .=                     "<td>$fthr_sibling_id</td>";

            $out .=                     "<td><a href='$siteUrl/?p=$post_id'>$name</a></td>";

            $out .=                     "<td>$birth_date</td>";           

            $out .=                 "</tr>";

                            } }    ;

            $out .=         "</tbody>";

            $out .=         "</table>";

            $out .=     "</section> <!-- tfh_list_boxes  -->";
            
       
		}
		*/
		
		/* Sibings from Mother Only
		
		$fthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Father'" );
		
		$orig_fthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Father'" ); 
		
		$mthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Mother'" );
		
		$orig_mthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Mother'" ); 
		
		$mthr_sibling_id = $wpdb->get_results( "SELECT child_id FROM $table_name2 WHERE parent_id = '$mthr_id' AND NOT child_id ='$id' AND (NOT parent_id ='Unknown') ");
		
		
		if (!empty($mthr_sibling_id )) {
			
			if ( ($mthr_id == $orig_mthr_id) && ($fthr_id == $orig_fthr_id) ) {
    
            $out .=   "<h3 class='table_list_heading'>Siblings From Mother Only</h3>";

            $out .=     "<section id='tfh_list_boxes'>";

            $out .=         "<table class='tfh_list_boxes'>";

            $out .=         "<thead>";

            $out .=             "<tr>";

            $out .=                 "<th class='person_id'>ID</th>";

            $out .=                 "<th>Name</th>";

            $out .=                 "<th class='person_birth'>Birth Date</th>";

            $out .=             "</tr>";

            $out .=         "</thead>";

            $out .=         "<tbody>";

            foreach ($mthr_sibling_id as $mthr_sibling_id) {
                                
                $mthr_sibling_id = $mthr_sibling_id->child_id; 
				
				$sib_fthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$mthr_sibling_id' AND family_link_role = 'Father'" );
				
				$orig_fthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Father'" );
				
				$orig_mthr_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = '$id' AND family_link_role = 'Mother'" );
									
				$child_living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$mthr_sibling_id'" );
				
				if ($sib_fthr_id != $orig_fthr_id) {
					
					if ($child_living != 'Living') {
											
							$birth_date = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$mthr_sibling_id'" );
			
							$firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$mthr_sibling_id'" );

							$lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$mthr_sibling_id'" );

							$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$mthr_sibling_id' ");

							$name = $firstName . ' ' . $lastName;
							
					} else {
											
																				
							$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$mthr_sibling_id' ");
											
							$birth_date = "";
											
							$name = "Living";
							
					}
					
			
							
			$out .=                 "<tr>";

            $out .=                     "<td>$mthr_sibling_id</td>";

            $out .=                     "<td><a href='$siteUrl/?p=$post_id'>$name</a></td>";

            $out .=                     "<td>$birth_date</td>";           

            $out .=                 "</tr>";
			

                            } }    ;

            $out .=         "</tbody>";

            $out .=         "</table>";

            $out .=     "</section> <!-- tfh_list_boxes  -->";
            
			}
		}
		
		*/
		
		
		
		
		/* SIBLING FROM FATHER LIST SECTION 

        if (!empty($sibling_id )) {
    
            $out .=   "<h3 class='table_list_heading'>Siblings From Father </h3>";

            $out .=     "<section id='tfh_list_boxes'>";

            $out .=         "<table class='tfh_list_boxes'>";

            $out .=         "<thead>";

            $out .=             "<tr>";

            $out .=                 "<th class='person_id'>ID</th>";

            $out .=                 "<th>Name</th>";

            $out .=                 "<th class='person_birth'>Birth Date</th>";

            $out .=             "</tr>";

            $out .=         "</thead>";

            $out .=         "<tbody>";

             foreach ($sibling_id as $sibling_id) {
                                
                $sibling_id = $sibling_id->child_id;
									
				$child_living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$sibling_id'" );
									
				if ($child_living != 'Living') {
                                    
                    $birth_date = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$sibling_id'" );
    

                    $firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$sibling_id'" );

                    $lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$sibling_id'" );

                    $post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$sibling_id' ");

                    $name = $firstName . ' ' . $lastName;

				} else {
									
																		
					$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$sibling_id' ");
									
					$birth_date = "";
									
					$name = "Living";
									
			}
                               

            $out .=                 "<tr>";

            $out .=                     "<td>$sibling_id</td>";

            $out .=                     "<td><a href='$siteUrl/?p=$post_id'>$name</a></td>";

            $out .=                     "<td>$birth_date</td>";           

            $out .=                 "</tr>";

                            }    ;

            $out .=         "</tbody>";

            $out .=         "</table>";

            $out .=     "</section> <!-- tfh_list_boxes  -->";
            
       }

	   
       if (empty($sibling_id )) {
			
			$out .=  "";
	   }
*/

        /* SIBLING FROM MOTHER LIST SECTION 

        

        if (!empty($m_sibling_id )) {
    
            $out .=   "<h3 class='table_list_heading'>Siblings From Mother </h3>";

            $out .=     "<section id='tfh_list_boxes'>";

            $out .=         "<table class='tfh_list_boxes'>";

            $out .=         "<thead>";

            $out .=             "<tr>";

            $out .=                 "<th class='person_id'>ID</th>";

            $out .=                 "<th>Name</th>";

            $out .=                 "<th class='person_birth'>Birth Date</th>";

            $out .=             "</tr>";

            $out .=         "</thead>";

            $out .=         "<tbody>";

             foreach ($m_sibling_id as $m_sibling_id) {
                                
                                    $m_sibling_id = $m_sibling_id->child_id;

                                	$child_living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$m_sibling_id'" );
								
								if ($child_living != 'Living') {                                       

                                    $birth_date = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$m_sibling_id'" );
    

                                    $firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$m_sibling_id'" );

                                    $lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$m_sibling_id'" );

                                    $post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$m_sibling_id' ");

                                    $name = $firstName . ' ' . $lastName;

                               } else {
									
									$post_id = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = '$m_sibling_id' ");
									
									$birth_date = "";
									
									$name = "Living";
									
								}

            $out .=                 "<tr>";

            $out .=                     "<td>$m_sibling_id</td>";

            $out .=                     "<td><a href='$siteUrl/?p=$post_id'>$name</a></td>";

            $out .=                     "<td>$birth_date</td>";           

            $out .=                 "</tr>";

                            }    ;

            $out .=         "</tbody>";

            $out .=         "</table>";

            $out .=     "</section> <!-- tfh_list_boxes  -->";
            
       }

       if (empty($m_sibling_id )) {
    
            

            $out .=     "";
            
            
          }  
		 */
		 

	    	return $out;

		} else {

	    	$out =	 	"<header class='tfh_header_section'>";
			
			$out .=			"<div id='tfh_title'>";

		    $out .=				"<p>This Person is still Living so their details have been hidden</p>"; 

		    $out .=			"</div>";

		    $out .=	  	"</header>";

    	return $out;
    
		}


		/* PEDIGREE CHART SECTION */
		
		$output = ob_get_clean();
	
		return $output;
		
}

add_shortcode( 'tfh_pedigree', 'tfh_pedigree_page' );
