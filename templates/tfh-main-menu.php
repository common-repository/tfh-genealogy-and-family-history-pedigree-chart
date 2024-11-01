<?php

//create page content and options

function tfh_create_tfh_main_menu(){

	global $wpdb;
	
	$table_name = $wpdb->prefix . "tfh_pedigree_chart";
	
	$family_members = $wpdb->get_results( "SELECT id, first_name, last_name, sex, family_id, post_id, image FROM $table_name" );
	
	$siteUrl = site_url();

	?>
	
	<h1> TFH Family History Plugin</h1>
	<h2>Family List </h2>
	
	<?php

	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;

	$limit = 20;
	$offset = ( $pagenum - 1 ) * $limit;

	$entries = $wpdb->get_results( "SELECT id, first_name, last_name, sex, family_id, post_id, image FROM $table_name LIMIT $offset, $limit" );

	$total= $wpdb->get_var( "SELECT COUNT(`id`) FROM $table_name" );
	$num_of_pages = ceil( $total / $limit );

	$page_links = paginate_links( array(
    'base'      => add_query_arg( 'pagenum', '%#%' ),
    'format'    => '',
    'prev_text' => __( '&laquo;', 'aag' ),
    'next_text' => __( '&raquo;', 'aag' ),
    'total'     => $num_of_pages,
    'current'   => $pagenum
	) );

	if ( $page_links ) {
	    echo '<div class="tablenav tfh_tablenav"><div class="tablenav-pages" style="margin: 1em 0"><span class="displaying-num">There are ' . $total . ' People in Total in the Database</span>' . $page_links . '</div></div>';
	}

	$table_name = $wpdb->prefix . "tfh_pedigree_chart";

	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$offset  = ( $pagenum - 1 ) * $limit;
	$entries = $wpdb->get_results( "SELECT * FROM $table_name LIMIT $offset, $limit" );

	?>

	<table class='widefat tfh_family_list'>
        <thead>
            <tr>
                <th scope='col' class='manage-column column-name' style=''>ID</th>
                <th scope='col' class='manage-column column-name' style=''>First Name</th>
				<th scope='col' class='manage-column column-name' style=''>Last Name</th>

				<th scope='col' class='manage-column column-name' style=''>Image</th>

				<th scope='col' class='manage-column column-name' style=''>Shortcode</th>

				<th scope='col' class='manage-column column-name' style=''>Edit</th>

				<th scope='col' class='manage-column column-name' style=''>Delete</th>
            </tr>
        </thead>

		
 
    <tfoot>
        <tr>
            <th scope='col' class='manage-column column-name' style=''>ID</th>
                <th scope='col' class='manage-column column-name' style=''>First Name</th>
				<th scope='col' class='manage-column column-name' style=''>Last Name</th>

				<th scope='col' class='manage-column column-name' style=''>Image</th>

				<th scope='col' class='manage-column column-name' style=''>Shortcode</th>

				<th scope='col' class='manage-column column-name' style=''>Edit</th>

				<th scope='col' class='manage-column column-name' style=''>Delete</th>
        </tr>
    </tfoot>

	<tbody>

	<?php 

	if ($entries) {

		$count = 1;
		
		$class = '';

		foreach ( $entries as $entry) {

			$id = $entry->id;
			
			$firstname = $entry->first_name;
			
			$lastname = $entry->last_name;

			$class = ( $count % 2 == 0 ) ? "class='alternate" : '';

			$memberImage = $wpdb->get_var( "SELECT image FROM $table_name WHERE id = $id" );

			$siteUrl = site_url();
				
			?>

			

			<tr<?php echo $class; ?> >
               
				<td><?php echo $entry->id; ?> </td>
                
				<td class="tfh_first_name">

					<a href="<?php echo $siteUrl . '/?p=' . htmlspecialchars($entry->post_id); ?>" target="_blank" >

						<?php echo $firstname; ?>

					</a>

				</td>

				<td><?php echo $lastname; ?></td>
				
				<td class="tfh_menu_page_link" >

				<?php if (!isset( $memberImage )) {
						
						$out = "No Image Available";
							
						return $out;
						
					   } else { ?>
					
						<a href="#image<?php echo $id;?>" >View Image</a>
						
				<?php } ?>

				</td>

				<td>

				[tfh_pedigree id="<?php echo htmlspecialchars($entry->id);?>"] 

				</td>

				<td>
					
					<a href="<?php echo esc_url( add_query_arg( 'id', $id, site_url( '/wp-admin/admin.php?page=add-submenu-add-new-member' ) ) )?>">Edit</a>

						
				</td>

				<td>
					
					<a onclick="return confirm('Are you sure you wish to delete <?php echo $firstname . ' ' . $lastname; ?>');" href="<?php echo esc_url( add_query_arg( 'id_to_delete', $id ) )?>">Delete</a>

						
				</td>

            </tr>

			<?php

				$id_to_delete = filter_input( INPUT_GET, "id_to_delete", FILTER_SANITIZE_STRING );

				if (isset($id_to_delete)) {
					
					$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";
						
					$post_id_to_delete = $wpdb->get_var( "SELECT post_id FROM $table_name1 WHERE id = $id_to_delete " );
						
					// Delete the Family member from the table
						
					$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";
						
					$table_name2 = $wpdb->prefix . "tfh_pedigree_children";

					$table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";
						
					$wpdb->delete( $table_name1, array( 'id' => $id_to_delete ) );
						
					/*$wpdb->delete( $table_name2, array( 'parent_id' => $id_to_delete ) );*/
						
					/*$wpdb->delete( $table_name2, array( 'child_id' => $id_to_delete ) );*/
					
					$parent_role = $wpdb->get_results( "SELECT * FROM $table_name2 WHERE parent_id = $id_to_delete " );
					
					foreach ($parent_role as $parent_role) {
						
						$parent_id = $parent_role->parent_id;
						
						$family_link_role = $parent_role->family_link_role;
						
						$child_id = $parent_role->child_id;											
					
						$wpdb->update( 
					
						$table_name2, 
						
						array( 
						
						'parent_id' 		=> 'Unknown', 
						'family_link_role'	=> $family_link_role,
						'child_id' 			=> $child_id
					
						), 
				
						array( 'child_id' => $child_id, 'family_link_role' => $family_link_role)
					
						);
						
					}
					
					$wpdb->delete( $table_name2, array( 'child_id' => $id_to_delete ) );

					$wpdb->delete( $table_name2, array( 'partner_id' => $id_to_delete ) );

					$wpdb->delete( $table_name3, array( 'partner_id' => $id_to_delete ) );
						
					wp_delete_post($post_id_to_delete);
						
					$siteUrl = site_url();
					
					wp_redirect( $siteUrl.'/wp-admin/admin.php?page=add-submenu-family-listing' );
						
					exit;
									
				} 

			?>


			<!-- lightbox container hidden with CSS -->
	
			<a href="#_" class="tfh_pedigree_lightbox" id="image<?php echo $id;?>">
				
				<img src="<?php echo $memberImage ?>">
				  
			</a>

			<?php

			$count++;

			} 

	} else { ?>
        
			<tr>
                
				<td colspan="2">No posts yet</td>
            
			</tr>

	<?php

	}

	?>
            
        </tbody>

	</table>

<?php

if ( $page_links ) {
	    echo '<div class="tablenav tfh_tablenav"><div class="tablenav-pages" style="margin: 1em 0"><span class="displaying-num">There are ' . $total . ' People in Total in the Database</span>' . $page_links . '</div></div>';
	}

}