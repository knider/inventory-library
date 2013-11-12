<?php
	ini_set('display_errors', 'On');
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
	if($mysqli->connect_errno){ echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error; }

	$name = array_key_exists("name", $_POST) ? $_POST["name"] : '';
	$email = array_key_exists("email", $_POST) ? $_POST["email"] : '';
	$address = array_key_exists("address", $_POST) ? $_POST["address"] : '';
	$phone = array_key_exists("phone", $_POST) ? $_POST["phone"] : '';

	if ( !($stmt = $mysqli->prepare("INSERT INTO borrower(name,emailAddress,phoneNumber,streetAddress) values(?,?,?,?)") ) ) {
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	if ( !$stmt->bind_param('ssss', $name, $email, $phone, $address) ) { 
		echo "Bind paramaters failed: (" . $mysqli->errno . ")" . $mysqli->error; 
	}
	if ( !$stmt->execute() ) { echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error; }
	
	header('location:add_borrower.html');
?>