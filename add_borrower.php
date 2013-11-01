<?php
   	//=================================================================
	//  CS419 Project
	//	Fall 2013
	//	File Name: add_borrower.php
	//	Description: This will add a new borrower to the borrower table
	//=================================================================

	//Turn on error reporting
	ini_set('display_errors', 'On');
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
	if($mysqli->connect_errno){
		echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}

	if(!($stmt = $mysqli->prepare("INSERT INTO borrower(emailAddress, name, phoneNumber, streetAddress) VALUES (?, ?, ?, ?)"))){
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if(!($stmt->bind_param("ssss",$_POST['emailAddress'],$_POST['name'],$_POST['phoneNumber'],$_POST['streetAddress']))){
		echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}

	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} else {
		echo "<p>Borrower is added to Tech Library.</p>";
		/* Need to remove or change these lines later */ 		
		//echo "<p><a href=\"main.php\">Go back to the previous page</a></p>"; 
		//echo "<p><a href=\"logout.php\">Log out</a></p>";
	}
	

?>