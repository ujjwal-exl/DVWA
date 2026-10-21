<?php
header("Content-Type: application/json; charset=UTF-8");

header("X-Content-Type-Options: nosniff");

if (array_key_exists ("callback", $_GET) && preg_match('/^[A-Za-z_$][A-Za-z0-9_$.]*$/', $_GET['callback'])) {
	$callback = $_GET['callback'];
} else {
	return "";
}

$outp = array ("answer" => "15");

echo $callback . "(".json_encode($outp).")";
?>
