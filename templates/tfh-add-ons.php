<?php


//create page content and options

 function tfh_add_new_add_ons(){
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "tfh_pedigree_chart";
	
	$family_members = $wpdb->get_results( "SELECT id, first_name, last_name, sex, family_id, post_id, image FROM $table_name" );
	
	
	
	$siteUrl = site_url();
	
	?>
	
	<h1> TFH Plugin Add Ons </h1>
	
	<br />

	<table class='widefat tfh_family_list'>
        
		<thead>
            
			<tr>
                
				<th scope='col' class='manage-column column-name' style=''>Number</th>
                
				<th scope='col' class='manage-column column-name' style=''>Add On</th>

				<th scope='col' class='manage-column column-name' style=''>Activated</th>

				<th scope='col' class='manage-column column-name' style=''>Description</th>

				<th scope='col' class='manage-column column-name' style=''>More Information</th>

            </tr>

        </thead>

		<tbody>

			<tr> 

				<td> 1 </td>

				<td> TFH Genealogy CSS</td>

				<td>

				<?php 

				if ( is_plugin_active( 'tfh-genealogy-css/tfh_genealogy_css.php' ) ) {

					echo 'Installed and Activated';

      			} else {

      				echo 'Yet be Installed';

      			}

      			?>
    	

    			</td>

				<td>Style all facets of the TFH Genealogy Plugin to match your website.</td>

				<td>Coming Soon</td>

			</tr>

		</tbody>

	    <tfoot>

	        <tr>
	                
					<th scope='col' class='manage-column column-name' style=''>Number</th>
	                
					<th scope='col' class='manage-column column-name' style=''>Add On</th>

					<th scope='col' class='manage-column column-name' style=''>Activated</th>

					<th scope='col' class='manage-column column-name' style=''>Description</th>

					<th scope='col' class='manage-column column-name' style=''>More Information</th>

	            </tr>

	    </tfoot>

	</table>


	</div>

<?php

 }