<?php
include(dirname(__FILE__).'/loader.php');
ini_set('display_errors', 'On');
session_start();


$email = array_key_exists("email", $_POST) ? $_POST["email"] : '';
$password = array_key_exists("password", $_POST) ? $_POST["password"] : '';
	
if($email && $password) {
	//check login, see if name already in use
	if(!($stmt = $mysqli->prepare("select COUNT(*) from user where email = ? "))){
		echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	if(!($stmt->bind_param('s', $email))){
		echo "Bind failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	if(!($stmt->execute())){
		echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	$stmt->store_result();
	$stmt->fetch();
	if($stmt->num_rows == 0){
		if(!($stmt = $mysqli->prepare("INSERT INTO user (email,password) VALUES (?,?)"))){
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		if(!($stmt->bind_param('ss', $email,$password))){
			echo "Bind failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		if(!($stmt->execute())){
			echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
	} else {
		echo "Email " . $email . " already created. Please <a href=\"login.php\">login</a>.";
	}
} else { //username or password missing
	echo "You must enter an email and password";
}

?>