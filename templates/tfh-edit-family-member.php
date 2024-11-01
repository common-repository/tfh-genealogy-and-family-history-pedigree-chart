<?php

//create page content and options
function tfh_edit_family_member(){
	
	?>
	
	<h1> Edit Family Member </h1>
	
	<br />
	
	<form method="post" action="">
	
		<table class="form-table">
		
			<tbody>
			
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
						
						$image = '/tfh-genealogy/images/no-images-available.jpg' ; ?>
						
						<img id="family-member-image" class="pedigree-image-admin" src="<?php echo $plugin_url . $image;
						 ?>" >

						

							<input type="hidden" class="button button-secondary" id="family-member-image-hidden" name="family_member_image_url" value="<?php echo $plugin_url . $image;
						 ?>">

							<input type="button" class="button button-secondary" id="family-member-image-upload"  value="Add Image"> 
							
							<input type="button" class="button button-secondary" onclick="reset_image();"id="family-member-image-delete"  value="Reset">
												
				</td>
				
				</tr>
					
				<tr>
				
					<th scope="row">
					
						<label for="first-name">
						
							First Name
						
						</label>
					
					</th>
					
					<td>
					
						<input name="first_name" type="text" id="first-name" class="regular-text">
									
					</td>
				
				</tr>
				
				<tr>
				
					<th scope="row">
					
						<label for="last-name">
						
							Last Name
						
						</label>
					
					</th>
					
					<td>
					
						<input name="last_name" type="text" id="last-name" class="regular-text">
									
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
						
							<option value="">Please Select</option>	
							<option value="Male">Male</option>	
							<option value="Female">Female</option>	
							<option value="Unknown">Unknown</option>
							
						</select>
									
					</td>
					
				<tr>
				
					<th scope="row">
					
						<label for="date-of-birth">
						
							Date of Birth
						
						</label>
					
					</th>
					
					<td>
					
						<input name="date_of_birth" type="text" id="date-of-birth" class="regular-text datepicker">
									
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
								
								<input type='radio' name='living' onclick="status_living();" value='Living' /> 
								
								<span class="regular-text">Living</span>
								
							</label>
							
							<br />
							
							<label>
								
								<input type='radio' name='living' onclick="status_deceased();" value='Deceased' /> 
								
								<span class="regular-text">Deceased</span>
								
							</label>
							
							<br />
							
							<label>
								
								<input type='radio' name='living' onclick="status_unknown();" value='Nnknown' /> 
								
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
					
						<label for="date-of-birth">
						
							Date of Death
						
						</label>
					
					</th>
					
					<td>
					
						<input name="date_of_death" type="text" id="date-of-death" class="regular-text datepicker">
									
					</td>
						
						</tr>
									
					
					</td>
					
				</tr>
				
			</tbody>
			
		</table>
		
		
		
		<p class="submit">
		
			<input type="submit" name="submit" class="button button-primary" value="Submit">
		
		</p>
		
	</form>
		
	<?php
	
	if(isset($_POST['submit'])) {
		
		// Collect the info from the form
		
		$firstName = $_POST['first_name'];
		
		$lastName = $_POST['last_name'];
		
		$sex = $_POST['sex'];
		
		$date_of_birth = $_POST['date_of_birth'];
		
		$date_of_death = $_POST['date_of_death'];
		
		if (empty($date_of_death)) {
			
			$date_of_death = 'Not Deceased';
		
		} else {
			
			$date_of_death = $date_of_death;
		
		}
		
		$living = $_POST['living'];
		
			
		$family_member_image_url = $_POST['family_member_image_url'];
		
		// Insert the collected info into Table
		
		global $wpdb;

		$table_name = $wpdb->prefix . "tfh_pedigree_chart";
		
		$wpdb->insert( 
		
		$table_name, 
		
		array( 
		
			'first_name' 	=> $firstName, 
			'last_name' 	=> $lastName,
		    'sex'			=> $sex,
			'dob'			=> $date_of_birth,
			'dod'			=> $date_of_death,
			'living'		=> $living,
			'image'			=> $family_member_image_url
	
			) 
		
		);
		
		$lastid = $wpdb->insert_id;
		
		$user_id = get_current_user_id();
		
		// Generate New Family ID
		
		$family_id = rand(10,999);
		
		$family_id = ($family_id * rand(1,10));
		
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
			'post_id' 	=> $post_id,
			'family_id'	=> $family_id
		), 
		array( 'id' => $lastid )
		);
			
	}

	
}