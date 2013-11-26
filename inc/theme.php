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
	<html lang="en_US">
	<head>
		<title>';
	if (!$title) echo SiteName;
	else echo $title. ' | ' .SiteName;
		
	echo '</title>	
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="themes/cs419.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
		<link rel="stylesheet" href="jquery.mobile.popup.css" />

		<script src="jquery-1.10.2.min.js"></script>
		<script src="jquery.mobile-1.3.2.min.js"></script>
		<script src="jquery.validate.min.js"></script>
		<script src="functions.js"></script>
	</head>
	';
}

function check_session(){
	session_start();
	global $email;
	if(isset($_SESSION['email'])){
		$email = $_SESSION['email'];
	}
	else{
		header('Location: login.php?login=0');
	}
}

function get_page_header(){
	global $title;
	global $subtitle;
	$page_header = (!$title) ? SiteName : $title.' | '.SiteName;
	if($subtitle)  echo '<div data-role="header"><h1>'.$page_header.'</h1> <h3>'.$subtitle.'</h3></div>';
	else echo '<div data-role="header"><h1>'.$page_header.'</h1></div>';

}
	
	/**
	 * Output nav buttons
	 */
	function get_menu(){
		echo '<div id="mainbuttons" class="ui-grid-b">
			<div class="ui-block-a">
				<a href="/" data-icon="back" data-ajax="false" data-role="button" data-rel="back" data-mini="true">Back</a>
				<p id="here1"></p>
			</div>
			<div class="ui-block-b"><a href="'.Home.'" data-ajax="false" data-role="button" data-mini="true">Home</a>
			</div>
			<div class="ui-block-c">
					<a href="logout.php" data-ajax="false" data-role="button" data-mini="true">Logout</a>
			</div>
		</div>';
	}
	
	function get_item_menu(){
		if(!$itemNumber) { $itemNumber = array_key_exists("itemnumber", $_GET) ? $_GET["itemnumber"] : ""; }
		echo '<div id="mainbuttons" class="ui-grid-b">
			<div class="ui-block-a">
				<a href="/" data-icon="back" data-ajax="false" data-role="button" data-rel="back" data-mini="true">Back</a>
				<p id="here1"></p>
			</div>
			<div class="ui-block-b"><a href="'.Home.'" data-ajax="false" data-role="button" data-mini="true">Home</a>
			</div>
			<div class="ui-block-c">
					<a href="logout.php" data-ajax="false" data-role="button" data-mini="true">Logout</a>		
			</div>
		</div>
		<div id="secondary buttons" class="ui-grid-a">
			<div class="ui-block-a">
					<a href="edit_item.php?itemNumber='.$itemNumber.'" data-ajax="false" data-role="button" data-mini="true">Edit Item</a>
					<p id="here1">
					</p>
			</div>
			<div class="ui-block-b">
				<a href="add_borrower.php" data-role="button" data-ajax="false" data-mini="true">+ Borrower</a>
				<p id="here3"></p>
			</div>
		</div>';
	}
	
	function get_home_menu(){
		echo '<div id="mainbuttons" class="ui-grid-b">
			<div class="ui-block-a">
					<a href="add_item.php" data-role="button" data-mini="true">+ Item</a>
					<p id="here3"></p>
			</div>
			<div class="ui-block-b">
					<a href="add_borrower.php" data-role="button" data-mini="true">+ Borrower</a>
					<p id="here3"></p>
			</div>
			<div class="ui-block-c">
					<a href="logout.php" data-ajax="false" data-role="button" data-mini="true">Logout</a>		
			</div>
		</div>                
		<div id="secondary buttons" class="ui-grid-a">
			<div class="ui-block-a">
					<a href="checking.php" data-role="button" data-mini="true">Check In/Out</a>
					<p id="here1">
					</p>
			</div>
			<div class="ui-block-b">
					<a href="history.php" data-role="button" data-ajax="false" data-mini="true">History</a>
			</div>
			
		</div>';
	}
	
?>