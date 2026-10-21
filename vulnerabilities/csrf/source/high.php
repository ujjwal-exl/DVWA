<?php

$change = false;
$request_type = "html";
$return_message = "Request Failed";

if ($_SERVER['REQUEST_METHOD'] == "POST" && array_key_exists ("CONTENT_TYPE", $_SERVER) && $_SERVER['CONTENT_TYPE'] == "application/json") {
	$data = json_decode(file_get_contents('php://input'), true);
	$request_type = "json";
	if (array_key_exists("HTTP_USER_TOKEN", $_SERVER) &&
		array_key_exists("password_current", $data) &&
		array_key_exists("password_new", $data) &&
		array_key_exists("password_conf", $data) &&
		array_key_exists("Change", $data)) {
		$token = $_SERVER['HTTP_USER_TOKEN'];
		$pass_curr = $data["password_current"];
		$pass_new = $data["password_new"];
		$pass_conf = $data["password_conf"];
		$change = true;
	}
} else {
	if (array_key_exists("user_token", $_REQUEST) &&
		array_key_exists("password_current", $_REQUEST) &&
		array_key_exists("password_new", $_REQUEST) &&
		array_key_exists("password_conf", $_REQUEST) &&
		array_key_exists("Change", $_REQUEST)) {
		$token = $_REQUEST["user_token"];
		$pass_curr = $_REQUEST["password_current"];
		$pass_new = $_REQUEST["password_new"];
		$pass_conf = $_REQUEST["password_conf"];
		$change = true;
	}
}

if ($change) {
	// Check Anti-CSRF token
	checkToken( $token, $_SESSION[ 'session_token' ], 'index.php' );

	// Verify the current password before allowing any change
	$current_user = dvwaCurrentUser();
	$pass_curr = mysqli_real_escape_string ($GLOBALS["___mysqli_ston"], $pass_curr);
	$pass_curr = md5( $pass_curr );
	$valid_current = false;
	$stmt = $GLOBALS["___mysqli_ston"]->prepare("SELECT password FROM `users` WHERE user = ? LIMIT 1");
	$stmt->bind_param('s', $current_user);
	$stmt->execute();
	$stmt->bind_result($stored_hash);
	if ($stmt->fetch() && hash_equals((string)$stored_hash, $pass_curr)) {
		$valid_current = true;
	}
	$stmt->close();

	// Is the current password correct and do the new passwords match?
	if( $valid_current && $pass_new == $pass_conf ) {
		// They do!
		$pass_new = mysqli_real_escape_string ($GLOBALS["___mysqli_ston"], $pass_new);
		$pass_new = md5( $pass_new );

		// Update the database
		$update = $GLOBALS["___mysqli_ston"]->prepare("UPDATE `users` SET password = ? WHERE user = ?");
		$update->bind_param('ss', $pass_new, $current_user);
		$result = $update->execute();
		$update->close();

		// Feedback for the user
		$return_message = "Password Changed.";
	}
	else {
		// Issue with passwords matching or current password incorrect
		$return_message = "Passwords did not match or current password was incorrect.";
	}

	mysqli_close($GLOBALS["___mysqli_ston"]);

	if ($request_type == "json") {
		generateSessionToken();
		header ("Content-Type: application/json");
		print json_encode (array("Message" =>$return_message));
		exit;
	} else {
		$html .= "<pre>" . $return_message . "</pre>";
	}
}

// Generate Anti-CSRF token
generateSessionToken();

?>
