<?php

if (array_key_exists ("redirect", $_GET) && $_GET['redirect'] != "") {
	$parts = parse_url($_GET['redirect']);
	if ($parts !== false && !isset($parts['scheme']) && !isset($parts['host']) && !isset($parts['user']) && isset($parts['path']) && $parts['path'] === "info.php") {
		header ("location: " . $_GET['redirect']);
		exit;
	} else {
		http_response_code (500);
		?>
		<p>You can only redirect to the info page.</p>
		<?php
		exit;
	}
}

http_response_code (500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>
