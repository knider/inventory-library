<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
if($mysqli->connect_errno){
	echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<?php

$itemNumber = $_POST["itemnum"];
//$name = $_POST["name"];
	if($stmt = $mysqli->prepare("update item set status=1 where itemNumber= ?")){
		$stmt->bind_param('s', $itemNumber);
		$stmt->execute();
	}
?>


