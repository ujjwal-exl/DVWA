<?php

if (array_key_exists ("redirect", $_GET) && $_GET['redirect'] != "") {
	if (!preg_match ("#^/(?![/\\\\])[^\\\\\\x00-\\x1F\\x7F]*$#D", $_GET['redirect'])) {
		http_response_code (500);
		?>
		<p>Only local paths are allowed.</p>
		<?php
		exit;
	} else {
		header ("location: " . $_GET['redirect']);
		exit;
	}
}

http_response_code (500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>
