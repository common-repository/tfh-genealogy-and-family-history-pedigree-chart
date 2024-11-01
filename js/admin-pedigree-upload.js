jQuery(document).ready( function($){

	var mediaUploader;

	var hidden = document.getElementById('family-member-image-hidden');
	
	var img = document.getElementById('family-member-image');
	
	var deleteButton = document.getElementById('family-member-image');
	
	$('#family-member-image-upload').on('click', function(e){

		e.preventDefault();

		if ( mediaUploader ){

			mediaUploader.open();

			return;

		}

		mediaUploader = wp.media.frames.file_frame = wp.media({

			title: 'Choose an Image for your Family Member',
			
			button: {

				text: 'Choose Your Picture'
			},

			multiple: false

		});

		mediaUploader.on('select', function (){

			var attachment = mediaUploader.state().get('selection').first().toJSON();
			
			img.setAttribute ('src', attachment.url );
			
			hidden.setAttribute('value', attachment.url ) ;
		
		});

		mediaUploader.open();

	});


});

function reset_image(){
	
		var $image_link = adminPedigreeUpload.pluginsUrl + '/tfh-genealogy/images/no-images-available.jpg';
		
		document.getElementById("family-member-image").src = $image_link;
		
		document.getElementById("family-member-image-hidden").value = $image_link;

	}