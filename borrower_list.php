<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
if($mysqli->connect_errno){
	echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<?php
	//$itemNumber = $_GET["itemnumber"];
	if($stmt = $mysqli->prepare("select name from borrower")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($name);
		echo "<select>";
		while($stmt->fetch()){
			echo "<option value='name'>".$name."</option>";
		}
		echo "</select>";
		//echo "<input type='text' value='".$itemNumber."' name='itemnumber'>";
		echo "<input type='submit' value='check out' />";
	}
?>
