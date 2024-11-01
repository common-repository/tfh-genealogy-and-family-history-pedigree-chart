<?php

//create page content and options
function tfh_add_new_family_member(){
	
	$id = filter_input( INPUT_GET, "id", FILTER_SANITIZE_STRING );
	
	if (!empty($id)){
	
	global $wpdb;
	
	$url = site_url();
	
	$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";

	$table_name2 = $wpdb->prefix . "tfh_pedigree_children";

	$table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";
	
	$results = $wpdb->get_results( "SELECT * FROM $table_name1 WHERE id = '$id'" );
	
	$firstName = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = '$id'" );
	
	$lastName = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = '$id'" );
	
	$sex = $wpdb->get_var( "SELECT sex FROM $table_name1 WHERE id = '$id'" );
	
	$dob = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = '$id'" );
	
	$dod = $wpdb->get_var( "SELECT dod FROM $table_name1 WHERE id = '$id'" );
	
	$living = $wpdb->get_var( "SELECT living FROM $table_name1 WHERE id = '$id'" );
	
	$family_id = $wpdb->get_var( "SELECT family_id FROM $table_name1 WHERE id = '$id'" );

	$event_date = $wpdb->get_var( "SELECT event_date FROM $table_name3 WHERE person_id = '$id'" );

	$marriage_status = $wpdb->get_var( "SELECT marriage_status FROM $table_name3 WHERE person_id = '$id'" );

	$partner_id = $wpdb->get_var( "SELECT partner_id FROM $table_name3 WHERE person_id = '$id'" );

	$marriage_status = $wpdb->get_results( "SELECT marriage_status FROM $table_name3 WHERE person_id = '$id'" );

	$family_marriage_status = end($marriage_status);
	
		if ($living == 'Deceased' ) { ?>
								
			<style>
								
				#d-o-d	{

					display:				block;

				}
								
			</style>
								
		<?php 
							
		}
	
	}
	
	if (!empty($id)){ ?>
		
		<h1> Edit Family Member </h1>
		
	<?php } else {  ?>
		
		<h1> Start New Family </h1>
		
	<?php } ?>
		
	<br />
	
	<form method="post" action="">
	
		<table class="form-table">
		
			<tbody>
			
				<tr>
				
					<th scope="row">
						
						<label for="family-member-image">
								
							Family ID

						</label>
						
					</th>
					
					<td>
					
					<span id="family-id-number">
					
						<?php if (!isset($family_id)) { 
						
							echo 'To be Created';
						
						} else {
							
							_e( $family_id, 'tfh-pedigree-chart' );
							
						} ?>
						
					</span>
					
					<input type="hidden" id="family-id-hidden" name="family_id_value" value="<?php _e( $family_id, 'tfh-pedigree-chart' ); ?>">
					
					</td>
				
				</tr>
			
			
				<tr>
			
					<th scope="row">
							
						<label for="family-member-image">
								
							Family Member Image
								
						</label>
							
					</th>
			
				<td>
			
				<!-- FAMILY MEMBER IMAGE UPLOAD -->
						
						<?php 
						
						$plugin_url = plugins_url();
						
						if (!empty($id)) {
							
							$image = $wpdb->get_var( "SELECT image FROM $table_name1 WHERE id = '$id'" );
							
							?>
							
							<img id="family-member-image" class="pedigree-image-admin" src="<?php echo  $image;
						 ?>" >
						 
						 <?php
							
						} else {
							
						$image = '/tfh-genealogy/images/no-images-available.jpg' ; 
						
						$image = $plugin_url . $image;
						
						?>
						
						<img id="family-member-image" class="pedigree-image-admin" src="<?php echo $image;
						 ?>" >
						 
						 <?php } ?>
						
							<input type="hidden" class="button button-secondary" id="family-member-image-hidden" name="family_member_image_url" value="<?php echo $image;
						 ?>">

							<input type="button" class="button button-secondary" id="family-member-image-upload"  value="Add Image"> 
							
							<input type="button" class="button button-secondary" onclick="reset_image();" id="family-member-image-delete"  value="Reset">
												
				</td>
				
				</tr>
					
				<tr>
				
					<th scope="row">
					
						<label for="first-name">
						
							First Name
						
						</label>
					
					</th>
					
					<td>
					
						<input name="first_name" type="text" id="first-name" class="regular-text" value = "<?php if (isset($id)) { echo $firstName; }else {} ?>" >
									
					</td>
				
				</tr>
				
				<tr>
				
					<th scope="row">
					
						<label for="last-name">
						
							Last Name
						
						</label>
					
					</th>
					
					<td>
					
						<input name="last_name" type="text" id="last-name" class="regular-text" value = "<?php if (isset($id)) { echo $lastName; }else {} ?>" >
									
					</td>
					
				<tr>
				
				<tr>
				
					<th scope="row">
					
						<label for="sex">
						
							Sex
						
						</label>
					
					</th>
					
					<td>
					
						<select name="sex" id="sex">
						
							<option value="" >Please Select</option>	
							<option value="Male" <?php if (!empty($id)){ if ($sex == 'Male') {echo 'selected';} }?>>Male</option>	
							<option value="Female"<?php  if (!empty($id)){ if ($sex == 'Female') {echo 'selected';} }?>>Female</option>	
							<option value="Unknown"<?php  if (!empty($id)){ if ($sex == 'Unknown') {echo 'selected';} }?>>Unknown</option>
							
						</select>
									
					</td>
					
				<tr>
				
					<th scope="row">
					
						<label for="date-of-birth">
						
							Date of Birth
						
						</label>
					
					</th>
					
					<td>
					
						<input name="date_of_birth" type="text" id="date-of-birth" class="regular-text datepicker" value="<?php if (!empty($id)){ echo $dob; }?>">
									
					</td>
				
				</tr>
				
				<tr>
				
					<th scope="row">
					
						<label for="living">
						
							Living
						
						</label>
					
					</th>
					
					<td>
					
						<fieldset>
						
							<legend class="screen-reader-text"><span>Living</span></legend>
		
							<label>
								
								<input type='radio' name='living' onclick="tfh_status_living();" value='Living' <?php if (!empty($id)){ if ($living == 'Living') {echo 'checked';} }?> /> 
								
								<span class="regular-text">Living</span>
								
							</label>
							
							<br />
							
							<label>
								
								<input type='radio' name='living' onclick="tfh_status_deceased();" value='Deceased' 
								
								<?php if (!empty($id)){ 
								
										if ($living == 'Deceased') {
											
											echo 'checked';
										
										} 

										} 
										
								?> 
										
								/> 
								
								<span class="regular-text">Deceased</span>
								
							</label>
							
							<br />
							
							<label>
								
								<input type='radio' name='living' onclick="tfh_status_unknown();" value='Unknown' <?php if (!empty($id)){ if ($living == 'Unknown') {echo 'checked';} }?>/> 
								
								<span class="regular-text">Unknown</span>
								
							</label>
												
						</fieldset>
						
					</td>	
					
				</tr>
				
			</tbody>
			
		</table>
		
		<table class="form-table">
		
			<tbody>
						
				<tr id="d-o-d">
						
					<th scope="row">
					
						<label for="date-of-death">
						
							Date of Death
						
						</label>
						
					</th>
					
					<td>
					
						<input name="date_of_death" type="text" id="date-of-death" class="regular-text datepicker"  value="<?php if (!empty($id)){ echo $dod; }?>">
									
					</td>
						
				</tr>
									
			</tbody>
			
		</table>
		
		<table class="form-table">
		
			<tbody>
				
				<tr>
				
					<th scope="row">
					
						<label for="family-role">
						
							Family Role
						
						</label>
					
					</th>
					
					<td>
					
						<fieldset>
						
							<legend class="screen-reader-text"><span>Living</span></legend>
		
							<?php if (!isset($family_id)) { ?>

							<label>
					
						<input type="radio" onclick="tfh_new_family();" id="family-relationship-new" name="family_link_role" value="New" ><?php _e( ' New Family', 'tfh-pedigree-chart' )?>
						
							</label>

							<?php  } ?>
							
							
											
						<br />
						
						<?php if (!isset($sex)) { ?>
						
						<label>

							<input type="radio" onclick="tfh_show_dropdown()" id="family-relationship-father"  name="family_link_role" value="Father" ><?php _e( ' Father of', 'tfh-pedigree-chart' )?>
						
						</label>
						
						<br />
						
						<?php } elseif ($sex == 'Male') { ?>
						
						<label>

							<input type="radio" onclick="tfh_show_dropdown()" id="family-relationship-father"  name="family_link_role" value="Father" ><?php _e( ' Father of', 'tfh-pedigree-chart' )?>
						
						</label>
						
						<br />
						
						<?php } 
						
						if (!isset($sex)) {
						
						?>
						<label>

							<input type="radio" onclick="tfh_show_dropdown()" id="family-relationship-mother"  name="family_link_role" value="Mother" > <?php _e( 'Mother of', 'tfh-pedigree-chart' )?>
						
						</label>
						
						<br />
						
						<?php } elseif ($sex == 'Female') { ?>
						
						<label>

							<input type="radio" onclick="tfh_show_dropdown()" id="family-relationship-mother"  name="family_link_role" value="Mother" > <?php _e( 'Mother of', 'tfh-pedigree-chart' )?>
						
						</label>
						
						<br />
						
						<?php } ?>
					
						
						<label>

							<input type="radio" onclick="tfh_show_dropdown_child()" id="family-relationship-child"  name="family_link_role" value="Child" ><?php _e( ' Child of', 'tfh-pedigree-chart' )?>
						
						</label>
						
						
					</td>
				
				</tr>
				
			</tbody>
			
		</table>
		
		<table class="form-table" id="family-link-person">
		
			<tbody>
				
				<tr>
				
					<th scope="row">
					
						<label for="family-role">
						
							Parent Of
						
						</label>
					
					</th>
					
					<?php 
					
					global $wpdb;
					
					$table_name = $wpdb->prefix . "tfh_pedigree_chart";
	
					$parent_of = $wpdb->get_results( "SELECT * FROM $table_name" );
					
					?>
					
					<td>
					
						<select name="parent_of" id="parent_of">
						 
						 <?php
						 
							foreach ($parent_of as $parent_of) {
								
								$child_id = $parent_of->id;
								$firstName = $parent_of->first_name;
								$lastName = $parent_of->last_name;
								$post_id = $parent_of->post_id;
								
							?>
								 
								  <option value='<?php echo $child_id ?>'><?php echo 'id: ' . $child_id .' - ' . $firstName . ' ' . $lastName?></option>';
								 
							<?php				 
							
							}
							
							?>		
							  
						</select>
						
					</td>
				
				</tr>
				
			</tbody>
			
		</table>
		
		<table class="form-table" id="family-link-father">
		
			<tbody>
				
				<tr>
				
					<th scope="row">
					
						<label for="family-role">
						
							Father
						
						</label>
					
					</th>
					
					<?php 
					
					include('tables.php');
	
					$child_of = $wpdb->get_results( "SELECT * FROM $table_name WHERE sex = 'Male'" );

					
					if (!empty($id) ){
					$fatherID = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Father' " );

					}

					

					
					?>
					
					<td>
					
						<select name="father_of" id="father_of">
						
							<option value="Unknown">Unknown</option>
						 
						 <?php
						 
							foreach ($child_of as $child_of) {
								
								$father_id = $child_of->id;
								$firstName = $child_of->first_name;
								$lastName = $child_of->last_name;
								$post_id = $child_of->post_id;
								
							?>
								 
								  <option value='<?php echo $father_id ?>' <?php if (!empty($id) ){ if ($fatherID == $father_id){ echo 'selected';} } ?>><?php echo 'id: ' . $father_id .' - ' . $firstName . ' ' . $lastName?></option>';
								 
							<?php				 
							
							}
							
							?>		
							  
						</select>
						
					</td>
				
				</tr>
				
				<tr>
				
					<th scope="row">
					
						<label for="family-role">
						
							Mother
						
						</label>
					
					</th>
					
					<?php 
					
					global $wpdb;
					
					$table_name = $wpdb->prefix . "tfh_pedigree_chart";
	
					$child_of = $wpdb->get_results( "SELECT * FROM $table_name WHERE sex = 'Female'" );

					if (!empty($id) ){

					$motherID = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Mother'" );

					}
					
					?>
					
					<td>
					
						<select name="mother_of" id="mother_of">
						
							<option value="Unknown">Unknown</option>
						 
						 <?php
						 
							foreach ($child_of as $child_of) {
								
								$mother_id = $child_of->id;
								$firstName = $child_of->first_name;
								$lastName = $child_of->last_name;
								$post_id = $child_of->post_id;
								
							?>
								 
								  <option value='<?php echo $mother_id ?>' <?php if (!empty($id) ){ if ($motherID == $mother_id){ echo 'selected';} } ?>><?php echo 'id: ' . $mother_id .' - ' . $firstName . ' ' . $lastName?></option>';
								 
							<?php				 
							
							}
							
							?>		
							  
						</select>
						
					</td>
				
				</tr>
				
			</tbody>
			
		</table>

		<?php if (isset($id)) { 

			$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
	
			$parent_id = $wpdb->get_results( "SELECT parent_id FROM $table_name2 WHERE child_id = $id" );

			$m_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Mother' "  );

			$f_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Father' "  );
		
		if (($m_id == 'Unknown') && ($f_id == 'Unknown') ) {
			
		} elseif ( (!isset($f_id)) ||  (!isset($m_id))){
			
		} else {

			?>

			<div class="admin-table">

			<h3 class="list_heading">Parents</h3>

			<br />

			<table class="tfh_family_list person_list">

				<thead>

					<tr>

						<th class="admin_table_id"> ID </th>

						<th class="admin_table_fn"> First Name </th>

						<th class="admin_table_ln"> Last Name </th>

						<th class="admin_table_fn"> Birth Date </th>

						<th class="admin_table_fn"> Delete Link </th>

					</tr>

				</thead>

				<tbody>

					<?php

					foreach ($parent_id as $parent_id) {

						$parent_id = $parent_id->parent_id;
						
						

						$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";
						
						$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
						
						$fn = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = $parent_id" );

						$ln = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = $parent_id" );

						$dob = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = $parent_id" );
						
						$role = $wpdb->get_var( "SELECT family_link_role FROM $table_name2 WHERE child_id = $id AND parent_id = $parent_id " );
						
						$url=plugins_url();
						
						
						
						if ($parent_id != 'Unknown'){
					?>

					<tr>

						<td> <?php echo $parent_id; ?> </td>

						<td> <?php echo $fn; ?> </td>

						<td> <?php echo $ln; ?> </td>

						<td> <?php echo $dob; ?> </td>

						<td> <p ><a href="<?php echo esc_url( add_query_arg( 'family_link_role', $role ) )?>" onclick = "return confirm('Are you sure you wish to delete this link')">Delete</a></p></td>

					</tr> 

					<?php
					
					} else { 
							
					}

						$parent_id_to_delete = filter_input( INPUT_GET, "family_link_role", FILTER_SANITIZE_STRING );

						if (isset($parent_id_to_delete)) {

						$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
						
						/*$wpdb->delete( $table_name2, array( 'child_id' => $id, 'parent_id' => $parent_id_to_delete ) ); */
						
						$wpdb->update( 
					
						$table_name2, 
						
						array( 
						
						'parent_id' 		=> 'Unknown', 
						'family_link_role'	=> $parent_id_to_delete,
						'child_id' 			=> $id
					
						), 
				
						array( 'child_id' => $id, 'family_link_role' => $parent_id_to_delete)
					
						);
							
						
						$siteUrl = site_url();
									wp_redirect( $siteUrl.'/wp-admin/admin.php?page=add-submenu-family-listing' );
									exit;
			



					} } ?>

				</tbody>

			</table>

			<p class="info">Please Note: Using the delete in the Parent List above only deletes the link not the Person themselves</p>

			

			</div>

			<?php 

			} }

		if (isset($id)) { 

			$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
	
			$child_id = $wpdb->get_results( "SELECT child_id FROM $table_name2 WHERE parent_id = $id" );
		if (!empty($child_id)) {

		?>

		<div class="admin-table">

		<h3 class="list_heading">Children</h3>

		<br />

		<table class="tfh_family_list person_list">

			<thead>

				<tr>

					<th class="admin_table_id"> ID </th>

					<th class="admin_table_fn"> First Name </th>

					<th class="admin_table_ln"> Last Name </th>

					<th class="admin_table_fn"> Birth Date </th>

					<th class="admin_table_fn"> Delete Link </th>

				</tr>

			</thead>

			<tbody>

				<?php

				foreach ($child_id as $child_id) {

					$child_id = $child_id->child_id;

					$children_id = $child_id;

					$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";

					$fn = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = $child_id" );

					$ln = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = $child_id" );

					$dob = $wpdb->get_var( "SELECT dob FROM $table_name1 WHERE id = $child_id" );

					$url=plugins_url();
				?>

				<tr>

					<td> <?php echo $children_id; ?> </td>

					<td> <?php echo $fn; ?> </td>

					<td> <?php echo $ln; ?> </td>

					<td> <?php echo $dob; ?> </td>

					<td> <p ><a href="<?php echo esc_url( add_query_arg( 'children_id', $children_id  ) )?>" onclick = "return confirm('Are you sure you wish to delete this link')"">Delete</a></p></td>

				</tr> 

				<?php

					$children_id_to_delete = filter_input( INPUT_GET, "children_id", FILTER_SANITIZE_STRING );

					if (isset($children_id_to_delete)) {

					$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
					
					$wpdb->delete( $table_name2, array( 'parent_id' => $id, 'child_id' => $children_id_to_delete ) );
					
					$siteUrl = site_url();
								wp_redirect( $siteUrl.'/wp-admin/admin.php?page=add-submenu-family-listing' );
								exit;
		



				} } ?>

			</tbody>

		</table>

		<p class="info">Please Note: Using the delete in the Children List above only deletes the link not the Person themselves</p>

		

		</div>

		<?php 

		} }

		?>

		<?php if (isset($id)) { 

		?>

		<style>

			#marriage_status_radio {

				display:  	none;
			}

		</style>
		
		<?php	} else {

			?>

		<style>

			#add-new-marriage-status-add{

				display:  	none;
			}

		</style>

		<?php	} ?>

		<div id="marriage_status_table">

		<label id="add-new-marriage-status-add">

			<input type="checkbox" onclick="tfh_show_marriage_status_radio(this)" id="add-new-marriage-status"  name="new_marriage_status" value="" > <?php _e( 'Add New Marriage Status', 'tfh-pedigree-chart' )?>
						
		</label>


		<table class="form-table" id="marriage_status_radio">
		
			<tbody>
				
				<tr>
				
					<th scope="row">
					
						<label for="marriage-status">
						
							Marriage Status
						
						</label>

						<p>Please Note: Except for Never Married, use when partner has already been added to the database.</p>

					</th>
					
					<td>
					
						<legend class="screen-reader-text"><span>Marriage Status</span></legend>
		
							<label>
					
						<input type="radio" onclick="tfh_new_marriage_partner();" name="family_marriage_status" value="married" <?php if (!empty($id)){ if ($family_marriage_status == 'married') {echo 'checked';} }?> ><?php _e( ' Married', 'tfh-pedigree-chart' )?>
						
							</label>

						<br />
						
						<label>
					
						<input type="radio" onclick="tfh_new_divorced_partner();" name="family_marriage_status" value="divorced" ><?php _e( ' Divorced', 'tfh-pedigree-chart' )?>
						
							</label>

						<br />
						
						<label>
					
						<input type="radio" onclick="tfh_new_widowed_partner();" name="family_marriage_status" value="widowed" ><?php _e( ' Widowed', 'tfh-pedigree-chart' )?>
						
						</label>
						
						<br />
						
						<label>
					
						<input type="radio" onclick="tfh_new_separated_partner();" name="family_marriage_status" value="separated" ><?php _e( ' Separated', 'tfh-pedigree-chart' )?>
						
							</label>
						
						<br />
						
						<label>
					
						<input type="radio" onclick="tfh_new_marriage_partner_nm();" name="family_marriage_status" value="never_married" ><?php _e( ' Never Married', 'tfh-pedigree-chart' )?>
						
						</label>
						
					</td>
				
				</tr>
				
			</tbody>
			
		</table>

		

		<div id="marriage_partner_table">

			<table class="form-table" >
			
				<tbody>
					
					<tr>
					
						<th scope="row">
						
							<label id="marriage-status-label">
							
								Married To
							
							</label>
						
						</th>
						
						<?php 
						
						include ('tables.php');
		
						$marriage_partner = $wpdb->get_results( "SELECT * FROM $table_name" );

						
						
						?>
						
						<td>
						
							<select name="marriage_partner" id="marriage_partner">
							
								<option value="Unknown">Unknown</option>
							 
							 <?php
							 
								foreach ($marriage_partner as $marriage_partner) {
									
									$marriage_partner_id = $marriage_partner->id;
									$firstName = $marriage_partner->first_name;
									$lastName = $marriage_partner->last_name;
									$post_id = $marriage_partner->post_id;								
								?>
									 
									  <option value='<?php echo $marriage_partner_id ?>'><?php echo 'id: ' . $marriage_partner_id .' - ' . $firstName . ' ' . $lastName?></option>';
									 
								<?php				 
								
								}
								
								?>		
								  
							</select>
							
						</td>
					
					</tr>

				</tbody>
				
			</table>

			<table class="form-table">
			
				<tbody>
							
					<tr id="event-date">
							
						<th scope="row">
						
							<label for="event_date">
							
								Event Date
							
							</label>
							
						</th>
						
						<td>

							<input type="hidden" id="event_type_hi" value="">
						
							<input name="event_date" type="text" class="regular-text datepicker"  value="">
										
						</td>
							
					</tr>
										
				</tbody>
				
			</table>

		</div>

		<?php if (isset($id)) { 

			$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";

			$table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";
	
			$partner = $wpdb->get_results( "SELECT * FROM $table_name3 WHERE person_id = $id" );

			$ms = $wpdb->get_var( "SELECT marriage_status FROM $table_name3 WHERE person_id = $id" );
			
			if ((!empty($partner))  && (!empty($ms)) && ($ms != 'never_married')) {

			?>

			 <div class="admin-table">

				<h3 class="list_heading">Marriage Status</h3>

				<br />

				<table class="tfh_family_list person_list">

					<thead>

						<tr>

							<th class="admin_table_id"> ID </th>

							<th class="admin_table_fn"> First Name </th>

							<th class="admin_table_ln"> Last Name </th>

							<th class="admin_table_fn"> Status </th>

							<th class="admin_table_fn"> Event Date </th>

							<th class="admin_table_fn"> Delete Link </th>

						</tr>

					</thead>

					<tbody>

						<?php

						foreach ($partner  as $partner ) {

								
								$partners_id  = $partner ->partner_id;

								$marriage_status = $partner ->marriage_status;

								$event_date = $partner ->event_date;

								$person_id = $wpdb->get_var( "SELECT person_id FROM $table_name3 WHERE partner_id = $partners_id " );

								$person = $wpdb->get_var( "SELECT person_id FROM $table_name3 WHERE partner_id = $id" );


								$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";

								$first_name = $wpdb->get_var( "SELECT first_name FROM $table_name1 WHERE id = $partners_id" );

								$last_name = $wpdb->get_var( "SELECT last_name FROM $table_name1 WHERE id = $partners_id" );
								
							?>

							<tr>

							<td> <?php echo $partner_id; ?> </td>

							<td> <?php echo $first_name; ?> </td>

							<td> <?php echo $last_name; ?> </td>

							<td> <?php echo $marriage_status; ?> </td>

							<td> <?php echo $event_date; ?> </td>

							<td> <p ><a onclick="return confirm('Are you sure you wish to delete this link')" href="<?php echo esc_url( add_query_arg( 'partner_id', $partner_id ) ); ?>" >Delete</a></p></td>

							</tr> 

						<?php

						$partner_id_to_delete = filter_input( INPUT_GET, "partner_id", FILTER_SANITIZE_STRING );

							if (isset($partner_id_to_delete)) {

								$table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";
								
								$wpdb->delete( $table_name3, array( 'partner_id' => $partner_id_to_delete, 'person_id' => $id, 'marriage_status' => $marriage_status) );

								$wpdb->delete( $table_name3, array( 'partner_id' => $id,  'person_id' => $partner_id_to_delete, 'marriage_status' => $marriage_status ) );

								$siteUrl = site_url();
								wp_redirect( $siteUrl.'/wp-admin/admin.php?page=add-submenu-family-listing' );
								exit;
							
							}
						} 

						?>


					</tbody>

				</table>

				<p class="info">Please Note: Using the delete in the Marriage Status List above only deletes the link not the Person themselves</p>

			 </div>

			<?php } } ?>

				
		<p class="submit">
		
			<input type="submit" name="submit" class="button button-primary" value="Submit">
		
		</p>
		
	</form>
		
	<?php
	
	if(isset($_POST['submit'])) {
		
		
		
			
		// Collect the info from the form
		
		
		if (!empty($_POST['first_name'])){
		
		$firstName = sanitize_text_field( $_POST['first_name']);
		
		} else { $firstName = ""; }
		
		
		if (!empty($_POST['last_name'])){
		
		$lastName = sanitize_text_field( $_POST['last_name']);
		
		} else { $lastName =  ""; }
		
		
		if (!empty($_POST['sex'])){
		
		$sex = sanitize_text_field( $_POST['sex']);
		
		} else { $sex = ""; }
		
		
		if (!empty($_POST['date_of_birth'])){
		
		$date_of_birth = sanitize_text_field( $_POST['date_of_birth']);
		
		} else { $date_of_birth = "Not Mentioned"; }
		
		
		if (!empty($_POST['family_link_role'])){
			
			$family_link_role = sanitize_text_field( $_POST['family_link_role']);
			
		}
		
		if ( $family_link_role == 'New'){
				
			$family_id = sanitize_text_field( $_POST['family_id_value']);
			
			$role = 'New';
		
		} else {
			
			$table_name1 = $wpdb->prefix . "tfh_pedigree_chart";
			
			$childid = sanitize_text_field( $_POST['parent_of']);
			
			$family_id = $wpdb->get_var( "SELECT family_id FROM $table_name1 WHERE id = '$childid'" );	

			$role = 'Other';
		
		}
		
		if (!empty($_POST['father_of'])){
		
		$father_id = sanitize_text_field( $_POST['father_of']);
		
		} else { $father_id  = "Not Added Yet"; }
		
		
		if (!empty($_POST['mother_of'])){
		
		$mother_id = sanitize_text_field( $_POST['mother_of']);
		
		} else { $mother_id  = "Not Added Yet"; }
						
		
		if (!empty($_POST['parent_of'])){
		
		$child_id = sanitize_text_field( $_POST['parent_of']);
		
		} else { $child_id = "No Children"; }
		
		
		if (!empty($_POST['family_marriage_status'])){
		
		$family_marriage_status = sanitize_text_field( $_POST['family_marriage_status']);
		
		} else {

			$family_marriage_status = 'not_selected';
		}



		if (!empty($_POST['marriage_partner'])){
		
		$marriage_partner = sanitize_text_field( $_POST['marriage_partner']);
		
		}

		if (!empty($_POST['event_date'])){
		
		$event_date = sanitize_text_field( $_POST['event_date']);
		
		} else { $event_date = 'Not Mentioned'; }
	
		$date_of_death = sanitize_text_field($_POST['date_of_death']);
		
		if (empty($date_of_death)) {
			
			$date_of_death = 'Not Mentioned';
		
		} else {
			
			$date_of_death = $date_of_death;
		
		}
		
		$living = sanitize_text_field( $_POST['living']);
					
		$family_member_image_url = sanitize_text_field( $_POST['family_member_image_url']);
		
		// Insert the collected info into Table
		
		include('tables.php');

		// Add New Person to Database
		
		if (empty($id)){ 

			if ($family_link_role != 'Child') {

				include('tables.php');
				
				$wpdb->insert( 
				
				$table_name1, 
				
				array( 
				
					'first_name' 		=> $firstName, 
					'last_name' 		=> $lastName,
					'sex'				=> $sex,
					'dob'				=> $date_of_birth,
					'dod'				=> $date_of_death,
					'living'			=> $living,
					'image'				=> $family_member_image_url,
					'role'				=> $role,
					'family_id'			=> $family_id
			
					) 
				
				);

				

			}

		if ($family_link_role == 'Child') {

			if ($father_id != 'Unknown') {

			$family_id = $wpdb->get_var( "SELECT family_id FROM $table_name1 WHERE id = $father_id" );

			} elseif ($father_id == 'Unknown') {

				$family_id = $wpdb->get_var( "SELECT family_id FROM $table_name1 WHERE id = $mother_id" );
			}
			
			$wpdb->insert( 
			
			$table_name1, 
			
			array( 
			
				'first_name' 		=> $firstName, 
				'last_name' 		=> $lastName,
				'sex'				=> $sex,
				'dob'				=> $date_of_birth,
				'dod'				=> $date_of_death,
				'living'			=> $living,
				'image'				=> $family_member_image_url,
				'role'				=> $role,
				'family_id'			=> $family_id
		
				) 
			
			);

		}
			
			$lastid = $wpdb->insert_id;
			
			$user_id = get_current_user_id();
			
			$new_post = array(

			//Create the new post with titel of first_name family_name and add the shortcode to the page.

			'post_title' => $firstName . " " . $lastName,

			'post_content' => '[tfh_pedigree id = "' . $lastid . '"]',

			'comment_status' => 'closed',

			'post_status' => 'publish',

			'post_author' => $user_id,

			'post_type' => 'post',

			'post_name' =>$firstName . " " . $lastName,

			);

			

			$post_id = wp_insert_post($new_post, $wp_error = false );
			
			$table_name = $wpdb->prefix . "tfh_pedigree_chart";
			
			$wpdb->update( 
		
			$table_name, 
		
			array( 
				'post_id' 	=> $post_id
				
			), 
			array( 'id' => $lastid )
			);

			include('tables.php');


			$wpdb->insert( 
					
					$table_name2, 
					
					array( 
					
						'parent_id' 		=> $father_id, 
						'family_link_role'	=> 'Father',
						'child_id' 			=> $lastid
				
						) 
					
					);

			

			

			
				$wpdb->insert( 
				
				$table_name2, 
				
				array( 
				
					'parent_id' 		=> $mother_id, 
					'family_link_role'	=> 'Mother',
					'child_id' 			=> $lastid
			
					) 
				
				);

			

				
			
			if (($family_link_role == 'Father') || ($family_link_role == 'Mother')) {

				
				
				$wpdb->update( 
				
				$table_name2, 
				
				array( 
				
					'parent_id' 		=> $lastid, 
					'family_link_role'	=> $family_link_role,
					'child_id' 			=> $child_id
			
					), 
						
						array( 'child_id' => $child_id, 'family_link_role' => $family_link_role )
			
					
				
				);

				
			
			}
			
			

			if ($family_marriage_status != 'not_selected') {

			$wpdb->insert( 
					
					$table_name3, 
					
					array( 
					
					'person_id' 		=> $lastid, 
					'marriage_status'	=> $family_marriage_status,
					'event_date'		=> $event_date,
					'partner_id' 		=> $marriage_partner
				
						) 
					
					);

			}

			 if (($family_marriage_status == 'married') || ($family_marriage_status == 'separated') || ($family_marriage_status == 'divorced')) {

				$wpdb->insert( 
					
					$table_name3, 
					
					array( 
					
					'person_id' 		=> $marriage_partner, 
					'marriage_status'	=> $family_marriage_status,
					'event_date'		=> $event_date,
					'partner_id' 		=> $lastid
				
						) 
					
				);

			}
				
		} elseif (!empty($id)) { 
			
			$table_name = $wpdb->prefix . "tfh_pedigree_chart";
				
			$wpdb->update( 
		
			$table_name, 
		
			array( 
				'first_name' 	=> $firstName, 
				'image'			=> $family_member_image_url,
				'last_name' 	=> $lastName,
				'sex'			=> $sex,
				'dob'			=> $date_of_birth,
				'dod'			=> $date_of_death,
				'living'		=> $living
				
			), 
			array( 'id' => $id )
			);

			$table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";

			if ($family_marriage_status != 'not_selected') {

				$wpdb->insert( 
						
						$table_name3, 
						
						array( 
						
						'person_id' 		=> $id, 
						'marriage_status'	=> $family_marriage_status,
						'event_date'		=> $event_date,
						'partner_id' 		=> $marriage_partner
					
							) 
						
						);

			}	

			if (($family_marriage_status == 'married') || ($family_marriage_status == 'separated') || ($family_marriage_status == 'divorced') ){

				$wpdb->insert( 
					
					$table_name3, 
					
					array( 
					
					'person_id' 		=> $marriage_partner, 
					'marriage_status'	=> $family_marriage_status,
					'event_date'		=> $event_date,
					'partner_id' 		=> $id
				
						)
					
				);	

			}	
			
			if (($family_link_role == 'Father') || ($family_link_role == 'Mother')) {

				$f_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $child_id AND family_link_role = 'Father' ");

				$m_id = $wpdb->get_var( "SELECT parent_id FROM $table_name2 WHERE child_id = $child_id AND family_link_role = 'Mother' ");

				$table_name2 = $wpdb->prefix . "tfh_pedigree_children";

				if ((!isset($f_id)) || (!isset($m_id))){

					$wpdb->insert( 
				
					$table_name2, 
				
					array( 
				
					'parent_id' 		=> $id, 
					'family_link_role'	=> $family_link_role,
					'child_id' 			=> $child_id
			
					 
						
					)
					);


				}



				
				$wpdb->update( 
				
				$table_name2, 
				
				array( 
				
					'parent_id' 		=> $id, 
					'family_link_role'	=> $family_link_role,
					'child_id' 			=> $child_id
			
					), 
						
						array( 'child_id' => $child_id, 'family_link_role' => $family_link_role )
			
					);
			
			}


			
			if ($family_link_role == 'Child') {

				$table_name2 = $wpdb->prefix . "tfh_pedigree_children";

				$child_details_exist = $wpdb->get_var( "SELECT child_id FROM $table_name2 WHERE child_id = $id" );

				if (isset($child_details_exist)) {
				
					$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
			
					$wpdb->update( 
					
						$table_name2, 
						
						array( 
						
						'parent_id' 		=> $father_id, 
						'family_link_role'	=> 'Father',
						'child_id' 			=> $id
					
						), 
				
						array( 'child_id' => $id, 'family_link_role' => 'Father')
					
					);
							
					$wpdb->update( 
					
						$table_name2, 
						
						array( 
						
						'parent_id' 		=> $mother_id, 
						'family_link_role'	=> 'Mother',
						'child_id' 			=> $id
					
						), 
						
						array( 'child_id' => $id, 'family_link_role' => 'Mother' )
			
					);

				} 

				$child_details_exist_mother = $wpdb->get_var( "SELECT child_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Mother'" );

				$child_details_exist_father = $wpdb->get_var( "SELECT child_id FROM $table_name2 WHERE child_id = $id AND family_link_role = 'Father'" );


				if ((isset($child_details_exist_mother)) && (!isset($child_details_exist_father))) { 

					$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
				
					$wpdb->insert( 
					
					$table_name2, 
					
					array( 
					
						'parent_id' 		=> $father_id, 
						'family_link_role'	=> 'Father',
						'child_id' 			=> $id
				
						) 
					
					);

				}

				if ( (isset($child_details_exist_father)) && (!isset($child_details_exist_mother) ) ) { 

					$table_name2 = $wpdb->prefix . "tfh_pedigree_children";
				
					$wpdb->insert( 
					
					$table_name2, 
					
					array( 
					
						'parent_id' 		=> $mother_id, 
						'family_link_role'	=> 'Mother',
						'child_id' 			=> $id
				
						) 
					
					);

				}


			
						
			}	

			
			
		}
		
		$siteUrl = site_url();
		wp_redirect( $siteUrl.'/wp-admin/admin.php?page=add-submenu-family-listing' );
		exit;
			
	}

	
}