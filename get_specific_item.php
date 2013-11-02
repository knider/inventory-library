<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
if($mysqli->connect_errno){
	echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<?php
	$itemNumber = $_GET["itemnumber"];
	if($itemNumber === ""){
		echo "Item number not in database";
	}
	if($stmt = $mysqli->prepare("select features, info,itemName,os,type,status from item where itemNumber = ?")){
		$stmt->bind_param('s', $itemNumber);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($features, $info,$itemName,$os,$type,$status);
		if($status == 1){
			$statusString = "Checked Out";
		}else $statusString = "Available";
		echo '<ul>';
		while($stmt->fetch()){
			echo '<p> Item Name: '.$itemName.'</p>';
			echo '<p> Item Number: '.$itemNumber.'</p>';
			echo '<p> Information: '.$info.'</p>';
			echo '<p> Operating System: '.$os.'</p>';
			echo '<p> Special Features: '.$features.'</p>';
			echo '<p> Current Status: '.$statusString.'</p>';
		}
		echo '</ul>';
	}
?>
