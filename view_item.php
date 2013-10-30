<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("engr-db.engr.oregonstate.edu","cs419group4","woBAGT5X","cs419group4");
if($mysqli->connect_errno){
	echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<?php

echo "hello world";

?>