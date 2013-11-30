<?php
header("Location: index.php");
include(dirname(__FILE__).'/loader.php');
ini_set('display_errors', 'On');
session_start();

/*
Performing db lookup on email and password.
If finds a valid row, then session is set.
*/


if(isset($_POST['email'], $_POST['password']))

{
	$email = $_POST['email'];
	$password = $_POST['password'];

	if(!($stmt = $mysqli->prepare("select email,password from user where email = ? "))){
	echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	if(!($stmt->bind_param('s', $email))){
	echo "Bind failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	if(!($stmt->execute())){
	echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error;
	}
	$stmt->store_result();
	$stmt->bind_result($dbemail, $dbpassword);
	$stmt->fetch();
	if($stmt->num_rows == 1){
		if($dbpassword == $password){
			//success
			$user_browser = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['email'] = $dbemail;
			$_SESSION['string'] = sessionString($dbemail);
		}
		else{
			//incorrect password
			header('Location: login.php?login=1');
		}
	}
	else{
		//incorrect user
		header('Location: login.php?login=2');
	}
	
}

?>