<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( 'authenticated' ) );

$page = dvwaPageNewGrab();
$page[ 'title' ]   = 'Vulnerability: File Inclusion' . $page[ 'title_separator' ].$page[ 'title' ];
$page[ 'page_id' ] = 'fi';
$page[ 'help_button' ]   = 'fi';
$page[ 'source_button' ] = 'fi';

dvwaDatabaseConnect();

$vulnerabilityFile = '';
switch( dvwaSecurityLevelGet() ) {
	case 'low':
		$vulnerabilityFile = 'low.php';
		break;
	case 'medium':
		$vulnerabilityFile = 'medium.php';
		break;
	case 'high':
		$vulnerabilityFile = 'high.php';
		break;
	default:
		$vulnerabilityFile = 'impossible.php';
		break;
}

require_once DVWA_WEB_PAGE_TO_ROOT . "vulnerabilities/fi/source/{$vulnerabilityFile}";

// if( count( $_GET ) )
if( isset( $file ) ) {
	// Only the fixed set of pages that live in this directory may ever be included,
	// regardless of which security-level source file assigned $file.
	$allowedFiles = array( 'include.php', 'file1.php', 'file2.php', 'file3.php' );
	if( !is_string( $file ) || !in_array( $file, $allowedFiles, true ) ) {
		echo "ERROR: File not found!";
		exit;
	}
	include( __DIR__ . '/' . $file );
}
else {
	header( 'Location:?page=include.php' );
	exit;
}

dvwaHtmlEcho( $page );

?>
