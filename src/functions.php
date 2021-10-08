<?php

if ( ! function_exists( 'dboyztemplate_path' ) ) {
	function dboyztemplate_path() {
		return apply_filters( 'dboyztemplate_path', 'dboyz' );
	}
}

if ( ! function_exists( 'dboyzlocate_template' ) ) {

	function dboyzlocate_template( $template_name, $template_path = '', $default_path = '' ) {

		if ( ! $template_path ) {
			$template_path = dboyztemplate_path();
		}

		if ( ! $default_path ) {
			$default_path = dboyz_PS_PATH . '/templates/';
		}

		$template = null;
		// Look within passed path within the theme - this is priority
		// if( hb_enable_overwrite_template() ) {
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name
			)
		);
		// }
		// Get default template
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		// Return what we found
		return apply_filters( 'dboyzlocate_template', $template, $template_name, $template_path );
	}
}

if ( ! function_exists( 'dboyzget_template' ) ) {

	function dboyzget_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) ) {
			extract( $args );
		}
		$located = dboyzlocate_template( $template_name, $template_path, $default_path );

		if ( ! file_exists( $located ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );

			return;
		}
		// Allow 3rd party plugin filter template file from their plugin
		$located = apply_filters( 'dboyzget_template', $located, $template_name, $args, $template_path, $default_path );

		do_action( 'dboyzbefore_template_part', $template_name, $template_path, $located, $args );

		if ( $located && file_exists( $located ) ) {
			include( $located );
		}

		do_action( 'dboyzafter_template_part', $template_name, $template_path, $located, $args );
	}
}


function imageupload($imagename){  
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/media.php');
    $uploadedfile = $imagename;
    $upload_overrides = array( 'test_form' => false );
    $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
   if ( $movefile && !isset( $movefile['error'] ) ) 
   {
       $wp_filetype = $movefile['type'];
       $filename = $movefile['file'];
       $wp_upload_dir = wp_upload_dir();
       $attachment = array(
         'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),
         'post_mime_type' => $wp_filetype,
         'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
         'post_content' => '',
         'post_status' => 'inherit'
           );
      $attach_id = wp_insert_attachment( $attachment, $filename);
      $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
      wp_update_attachment_metadata( $attach_id,  $attach_data );
	  return  $attach_id;
    } 
    else
    {
       echo $movefile['error'];
    }       
} 