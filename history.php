<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
if($mysqli->connect_errno){
	echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<?php
	echo "
	<style>
		table {margin: 1em; border-collapse: collapse} 
		th, td {padding:.3em;border:1px #ccc solid;text-align:left}
		thead{background:#fc9}
	</style>

	";



	if($stmt = $mysqli->prepare("select date,i.itemName,borrower_email from item_borrower ib left join item i on ib.item_id = i.id order by date")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($date,$itemName,$email);
		echo "<table><tr><td>Item Name</td><td>Borrower's Email</td><td>Date</td></tr>";
		while($stmt->fetch()){
			echo "<tr><td>".$itemName."</td><td>".$email."</td><td>".$date."</td><tr>";
		}
		echo "</table>";
	}
?>
