<?php	
	define('PATH', dirname(__FILE__));
	
	include_once(PATH . '/inc/config.php');
		
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	if ($mysqli->connect_errno){ 
		echo "Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error; 
	}


function get_header(){
	global $title;
	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>';
	if (!$title) echo SiteName;
	else echo $title. ' | ' .SiteName;
		
	echo '</title>	
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="themes/cs419.css" />
		<link rel="stylesheet" href="themes/jquery.mobile.structure-1.3.2.min.css" />
		<link rel="stylesheet" href="themes/jquery.mobile.popup.css" />

		<script src="scripts/jquery-1.10.2.min.js"></script>
		<script src="scripts/jquery.mobile-1.3.2.min.js"></script>
		<script src="scripts/jquery.validate.min.js"></script>
		<script src="scripts/functions.js"></script>
	</head>
	';
}

function getNumberOfItems($email){
	global $mysqli;

	if($stmt = $mysqli->prepare("SELECT COUNT(*) FROM item")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		$numRows = $stmt->num_rows;
	}
	$string = $numRows . " item(s)";
	return $string;
}

function check_session(){
	session_start();
	global $email;
	if(isset($_SESSION['email'])){
		$email = $_SESSION['email'];
		if($_SESSION['string'] == sessionString($email)){
			//success
		}
		else{
		header('Location: login.php?login=0');
		}
	}
	else{
		header('Location: login.php?login=0');
	}
}

//simple session protector, not very secure
function sessionString($email){
	$string;
	$string = ($email * 5 + 30) ^ 4;
	return $string;
}

function get_page_header(){
	global $title;
	global $subtitle;
	$page_header = (!$title) ? SiteName : $title.' | '.SiteName;
	if($subtitle)  echo '<div data-role="header"><a href="logout.php" data-ajax="false" data-role="button" data-mini="false" style="right: 5px; left: auto;">Logout</a>	<h1>'.$page_header.'</h1> <h3>'.$subtitle.'</h3></div>';
	else echo '<div data-role="header"><a href="logout.php" data-ajax="false" data-role="button" data-mini="true" style="right: 5px; left: auto;">Logout</a><h1>'.$page_header.'</h1></div>';

}
	
/**
 * Output nav buttons
 */
function get_menu(){
	echo '
	<div id="mainbuttons" class="ui-grid-a">
		<div class="ui-block-a">
			<a href="/" data-icon="back" data-ajax="false" data-role="button" data-rel="back" data-mini="true">Back</a>
		</div>
		<div class="ui-block-b">
			<a href="'.Home.'" data-icon="home" data-ajax="false" data-role="button" data-mini="true">Home</a>
		</div>
	</div>';
}
	
	function get_item_menu(){
		if(!$itemNumber) { $itemNumber = array_key_exists("itemnumber", $_GET) ? $_GET["itemnumber"] : ""; }
		get_menu();
		echo '
		<div id="secondary_buttons" class="ui-grid-a">
			<div class="ui-block-a">
				<a href="edit_item.php?itemNumber='.$itemNumber.'" data-ajax="false" data-role="button" data-mini="true">Edit Item</a>
			</div>
			<div class="ui-block-b">
				<a href="add_borrower.php" data-icon="plus" data-role="button" data-ajax="false" data-mini="true">+ Borrower</a>
			</div>
		</div>';
	}
	
	function get_history_menu(){
		echo '
			<div id="mainbuttons" class="ui-grid-a">
			<div class="ui-block-a">
				<a href="javascript:submitForm()" data-icon="delete" data-ajax="false" data-role="button" data-mini="true">Clear History</a>
			</div>
				<div class="ui-block-b"><a href="'.Home.'" data-ajax="false" data-icon="home" data-role="button" data-mini="true">Home</a>
			</div>
			
		</div>';
	}
	
	function get_home_menu(){
		echo '<script>$("#page1").on("pagechange", getAjax("page1", "get_item_list.php", "ulist"));</script>
		<div id="mainbuttons" class="ui-grid-a">
			<div class="ui-block-a">
				<a href="add_item.php" data-icon="plus" data-role="button" data-mini="true">+ Item</a>
			</div>
			<div class="ui-block-b">
				<a href="add_borrower.php" data-icon="plus" data-ajax="false" data-role="button" data-mini="true">+ Borrower</a>
			</div>	
		</div>                
		<div id="secondary_buttons" class="ui-grid-a">
			<div class="ui-block-a">
				<a href="checking.php" data-role="button" data-mini="true">Check In/Out</a>
			</div>
			<div class="ui-block-b">
				<a href="history.php" data-role="button" data-ajax="false" data-mini="true">History</a>
			</div>
		</div>';
	}
	
	//Retrieve borrower list to display in select menu
	function get_borrower_list($borrower_list) {
		global $mysqli;
		global $email;
		if (!($stmt = $mysqli->prepare("SELECT id, name FROM borrower WHERE user=?"))) {echo "Prepare failed: " .$stmt->errno." ".$stmt->error;}
		if (!$stmt->bind_param('s',$email)) { echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error; }
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		if (!$stmt->bind_result($borrower_id, $name)) { echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error; }
		else {
			$stmt->store_result();
			$borrower_list .= "<select name=\"borrower_id\">\n";
			while($stmt->fetch()){
				$borrower_list .= "<option value=\"" .$borrower_id. "\">" .$name. "</option>\n";
			}
			$borrower_list .= "</select>\n";
		}
	}

?>