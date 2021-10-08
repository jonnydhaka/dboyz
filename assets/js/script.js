(function() {
   jQuery(document).ready(function ($) {
    
    // Upload images.
    $('body').on('click', '.mb_img_upload_btn', function(e){
        e.preventDefault();
        var cl_mb_img_id = $(this).attr("id");
        var product_images = $('#dboyzprofile_image_div' ) ;
        var button = $(this),
        aw_uploader = wp.media({
            title: 'Choose Media',
            library : {
                // uploadedTo : wp.media.view.settings.post.id, // - Uploaded to post id
                uploadedTo : wp.media, // - Uploaded to main media
                type : 'image'
            },
            button: {
                text: 'Use this image'
            },
            multiple: true
        }).on( 'select', function() {
            var selection = aw_uploader.state().get('selection');
            var attachment_ids = $('#' + cl_mb_img_id).val();
			selection.map( function( attachment ) {
                attachment = attachment.toJSON();
				if ( attachment.id ) {
					attachment_ids   = attachment.id;
					var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
					
                    if($('.attachment-thumbnail.size-thumbnail').length){
                        $('.attachment-thumbnail.size-thumbnail').attr('src',attachment_image);
                    }else{
                        product_images.prepend(
                        '<img id="' + attachment.id + '" src="' + attachment_image + '" width="150" height="150"/><a id="' + cl_mb_img_id + '" data-img_id="' + attachment.id + '" class="remove" href="javascript:void(0)"></a>'
                    );
                    }
                    
				}
			});
			$('#dboyzprofile_image' ).val(attachment_ids);
		})
        .open();
    });
    })
})(jQuery)