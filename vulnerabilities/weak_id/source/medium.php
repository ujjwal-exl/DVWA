<?php

$html = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$cookie_value = bin2hex(random_bytes(32));
	setcookie("dvwaSession", $cookie_value, 0, "", "", isset($_SERVER['HTTPS']), true);
}
?>
