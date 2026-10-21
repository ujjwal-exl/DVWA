<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
	// Get input
	$target = $_REQUEST[ 'ip' ];

	// Only a syntactically valid IP address may reach the shell
	if( filter_var( $target, FILTER_VALIDATE_IP ) === false ) {
		$cmd = 'ERROR: You have entered an invalid IP.';
	}
	// Determine OS and execute the ping command.
	elseif( stristr( php_uname( 's' ), 'Windows NT' ) ) {
		// Windows
		$cmd = shell_exec( 'ping  ' . escapeshellarg( $target ) );
	}
	else {
		// *nix
		$cmd = shell_exec( 'ping  -c 4 ' . escapeshellarg( $target ) );
	}

	// Feedback for the end user
	$html .= "<pre>{$cmd}</pre>";
}

?>
