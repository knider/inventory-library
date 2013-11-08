<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
if($mysqli->connect_errno){
		echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

$name = $_POST["name"];
$email = $_POST["email"];
$address = $_POST["address"];
$phone = $_POST["phone"];


	if($stmt = $mysqli->prepare("insert into borrower(name,emailAddress,phoneNumber,streetAddress) values(?,?,?,?)")){
		$stmt->bind_param('ssss', $name, $email, $phone, $address);
		$stmt->execute();
	}
header('location:post-login.php');
?>