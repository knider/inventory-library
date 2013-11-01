<?php
   	//=================================================================
	//  CS419 Project
	//	Fall 2013
	//	File Name: add_item.php
	//	Description: This will add a new item to the item table
	//=================================================================

	//Turn on error reporting
	ini_set('display_errors', 'On');
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
	if($mysqli->connect_errno){
		echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

	if(!($stmt = $mysqli->prepare("INSERT INTO item(features, info, itemName, itemNumber, os, status, 
		type) VALUES (?, ?, ?, ?, ?, ?, ?)"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if(!($stmt->bind_param("sssisis",$_POST['feature'],$_POST['info'],$_POST['itemName'],$_POST['itemNumber'], $_POST['os'],
		$_POST['status'],$_POST['type']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} else {
		echo "<p>Your item is added to Tech Library.</p>";
		/* Need to change these lines later */ 		
		//echo "<p><a href=\"main.php\">Go back to the previous page</a></p>"; 
		//echo "<p><a href=\"logout.php\">Log out</a></p>";
	}
	

?>