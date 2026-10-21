<?php

if( isset( $_POST[ 'Upload' ] ) ) {
	// Where are we going to be writing to?
	// File information
	$uploaded_name = $_FILES[ 'uploaded' ][ 'name' ];
	$uploaded_ext  = strtolower( pathinfo( $uploaded_name, PATHINFO_EXTENSION ) );
	$uploaded_size = $_FILES[ 'uploaded' ][ 'size' ];
	$uploaded_tmp  = $_FILES[ 'uploaded' ][ 'tmp_name' ];

	// Where are we going to be writing to? (server-chosen file name, never the client-supplied one)
	$target_path  = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";
	$target_path .= md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;

	// Is it an image? (extension allow-list + actual file content; the client MIME type is not trusted)
	$uploaded_img = is_uploaded_file( $uploaded_tmp ) ? @getimagesize( $uploaded_tmp ) : false;
	if( ( $uploaded_ext == "jpg" || $uploaded_ext == "jpeg" || $uploaded_ext == "png" ) &&
		( $uploaded_size < 100000 ) &&
		( $uploaded_img !== false ) &&
		( $uploaded_img[ 2 ] == IMAGETYPE_JPEG || $uploaded_img[ 2 ] == IMAGETYPE_PNG ) ) {

		// Can we move the file to the upload folder?
		if( !move_uploaded_file( $uploaded_tmp, $target_path ) ) {
			// No
			$html .= '<pre>Your image was not uploaded.</pre>';
		}
		else {
			// Yes!
			$html .= "<pre>{$target_path} succesfully uploaded!</pre>";
		}
	}
	else {
		// Invalid file
		$html .= '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
	}
}

?>
