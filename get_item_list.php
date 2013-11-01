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
		
   		$string = "<ul id='ulist'  data-role='listview' data-inset='true' data-filter='true' data-filter-theme='a' data-filter-placeholder='Search for an Item'>";
		while($stmt->fetch()){
		
		if($status == 1){
			$statusString = "Checked Out";
			$statusColor = "#990000";
		}else {
			$statusString = "Available";
			$statusColor = "#009900";
		}

			$string .= "<li><a style='color:".$statusColor."' href=item.html?itemnumber=".$itemNumber.">".$itemName."</a>";
			$string .= "<p>".$info."</p>";
			$string .= "<p>".$os."</p>";
			$string .= "<p>".$type."</p>";
			$string .= "<p>".$itemNumber."</p>";
			$string .= "<p>".$statusString."</p>";
			$string .= "</li>";
		}
		$string .= "</ul>";
		echo $string;
	}
?>
