<?php
   	/* ===================================================================
	*   CS419 Project
	*	Fall 2013
	*	File Name: add_item.php
	*	Description: This will add a new item to the item table
	*  ================================================================= */

	ini_set('display_errors', 'On');
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
	if ($mysqli->connect_errno){ echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error; }
	
	$features = array_key_exists("features", $_POST) ? $_POST["features"] : '';
	$info = array_key_exists("info", $_POST) ? $_POST["info"] : '';
	$itemName = array_key_exists("itemName", $_POST) ? $_POST["itemName"] : '';
	$itemNumber = array_key_exists("itemNumber", $_POST) ? $_POST["itemNumber"] : '';
	$type = array_key_exists("type", $_POST) ? $_POST["type"] : '';
	$os = array_key_exists("os", $_POST) ? $_POST["os"] : '';
	$pages = array_key_exists("pages", $_POST) ? '' : '';
	
	if (!($stmt = $mysqli->prepare("INSERT INTO item(features, info, itemName, itemNumber, type, os, pages) values(?, ?, ?, ?, ?, ?, ?)"))) {
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}
	
	if (!($stmt->bind_param("sssssss", $features, $info, $itemName, $itemNumber, $type, $os, $pages))) {
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
	
	else {
		header('location:index.html');
		//echo "<p>Your item is added to Tech Library.</p>";
		/* Need to change these lines later */ 		
		//echo "<p><a href=\"main.php\">Go back to the previous page</a></p>"; 
		//echo "<p><a href=\"logout.php\">Log out</a></p>";
	}
?>