<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
if($mysqli->connect_errno){
	echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<?php

	if($stmt = $mysqli->prepare("select info,itemName,os,type,status,itemNumber from item")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($info,$itemName,$os,$type,$status,$itemNumber);
   		$string = "<ul id='ulist' data-role='listview' data-inset='true' data-filter='true' >";
		while($stmt->fetch()){
			$string .= "<li><a href=item.html?itemname=".$itemName.">".$itemName."</a></li>";
		}
		$string .= "</ul>";
		echo $string;
	}
?>
