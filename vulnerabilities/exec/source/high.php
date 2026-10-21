<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
	// Get input
	$target = trim($_REQUEST[ 'ip' ]);

	// Only accept a syntactically valid IP address, then quote it as a single shell argument.
	if( filter_var( $target, FILTER_VALIDATE_IP ) === false ) {
		$cmd = 'ERROR: You have entered an invalid IP.';
	}
	else {
		$target = escapeshellarg( $target );

		// Determine OS and execute the ping command.
		if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
			// Windows
			$cmd = shell_exec( 'ping  ' . $target );
		}
		else {
			// *nix
			$cmd = shell_exec( 'ping  -c 4 ' . $target );
		}
	}

	// Feedback for the end user
	$html .= "<pre>{$cmd}</pre>";
}

?>
	$html .= "<pre>" . htmlspecialchars( $cmd, ENT_QUOTES, 'UTF-8' ) . "</pre>";
