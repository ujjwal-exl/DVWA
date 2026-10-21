<?php

if( isset( $_POST[ 'Upload' ] ) ) {
	// Where are we going to be writing to?
	$target_path  = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";
	$uploaded_name = $_FILES[ 'uploaded' ][ 'name' ];
	$uploaded_tmp  = $_FILES[ 'uploaded' ][ 'tmp_name' ];
	$uploaded_ext  = strtolower( pathinfo( $uploaded_name, PATHINFO_EXTENSION ) );
	$allowed_types = array( 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png' );
	// Server-chosen file name: never reuse the client-supplied name
	$target_path .= md5( uniqid( '', true ) . $uploaded_name ) . '.' . $uploaded_ext;

	// Only accept genuine JPEG/PNG images (extension allow-list + content check), then move the file
	$image_info = ( isset( $allowed_types[ $uploaded_ext ] ) && is_uploaded_file( $uploaded_tmp ) ) ? @getimagesize( $uploaded_tmp ) : false;
	if( $image_info === false || $image_info[ 'mime' ] !== $allowed_types[ $uploaded_ext ] || !move_uploaded_file( $uploaded_tmp, $target_path ) ) {
		// No
		$html .= '<pre>Your image was not uploaded.</pre>';
	}
	else {
		// Yes!
		$html .= "<pre>{$target_path} succesfully uploaded!</pre>";
	}
}

?>
