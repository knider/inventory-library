<?php
	include(dirname(__FILE__).'/loader.php');
	
	if (!($stmt = $mysqli->prepare("SELECT name FROM borrower"))) { echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error; }
	if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
	if (!$stmt->bind_result($name)) { echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error; }
	else {
		$stmt->store_result();
		$borrower_list = "<select name=\"borrower_name\">\n";
		while($stmt->fetch()){
			$borrower_list .= "<option value=\"" .$name. "\">" .$name. "</option>\n";
		}
		$borrower_list .= "</select>\n";
	}
?>
