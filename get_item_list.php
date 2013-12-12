<?php
	include(dirname(__FILE__).'/loader.php');
	session_start();
	$user = $_SESSION['email'];
	
	if($stmt = $mysqli->prepare("SELECT id, info, itemName, type, status, itemNumber, pages, os, features FROM item WHERE user=? ORDER BY id DESC")){
		if (!($stmt->bind_param('s', $user))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($item_id, $info,$itemName,$type,$status,$itemNumber, $pages, $os, $features);
		
   		$string = "<ul id='ulist' data-role='listview' data-inset='true' data-filter='true' data-filter-theme='a' data-filter-placeholder='Search for an Item'>";
		while($stmt->fetch()){
		
		if($status == 1){
			$statusString = "Checked Out";
			$statusClass = "checked_out";
		}else {
			$statusString = "Available";
			$statusClass = "available";
		}
			$string .= "<li><a class='". $statusClass ."'  href=item.php?itemnumber=".$itemNumber.">".$itemName."";
			$string .= "<p>Item #: ".$itemNumber."</p>";
			$string .= (!$type) ? "" : "<p>Type: ".$type."</p>";
			$string .= (!$pages) ? "" : "<p>Pages: ".$pages."</p>";
			$string .= (!$os) ? "" : "<p>OS: ".$os."</p>";
			$string .= (!$features) ? "" :  "<p>Features:".$features."</p>";
			$string .= (!$info) ? "" :  "<p>Other Info: ".$info."</p>";
			$string .= "</a></li>";
		}
		$string .= "</ul></div>";
		echo $string;
	}
?>
