<?php

// The page we wish to display
$file = $_GET[ 'page' ];

// Only accept a bare filename in this directory: no path separators, no traversal, no stream wrappers
if( !is_string( $file ) || !preg_match( '/^[A-Za-z0-9_\-]+\.php$/', $file ) ) {
	echo "ERROR: File not found!";
	exit;
}

?>
