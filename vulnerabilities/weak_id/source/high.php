<?php

$html = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!isset ($_SESSION['last_session_id_high'])) {
		$_SESSION['last_session_id_high'] = 0;
	}
	$_SESSION['last_session_id_high']++;
	$cookie_value = bin2hex(random_bytes(16));
	setcookie("dvwaSession", $cookie_value, time()+3600, "/vulnerabilities/weak_id/", $_SERVER['HTTP_HOST'], false, false);
}

?>
