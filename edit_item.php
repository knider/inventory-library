<?php
   	/* ===================================================================
	*   CS419 Project
	*	Fall 2013
	*	File Name: edit_item.php
	*	Description: This will edit an item
	*  ================================================================= */
	
	include(dirname(__FILE__).'/loader.php');
	check_session();
	$title = "Edit Item";
	
	$features = array_key_exists("features", $_POST) ? $_POST["features"] : '';
	$info = array_key_exists("info", $_POST) ? $_POST["info"] : '';
	$itemName = array_key_exists("itemName", $_POST) ? $_POST["itemName"] : '';
	$itemNumber = array_key_exists("itemNumber", $_POST) ? $_POST["itemNumber"] : '';
	$type = array_key_exists("type", $_POST) ? $_POST["type"] : '';
	$os = array_key_exists("os", $_POST) ? $_POST["os"] : '';
	$pages = array_key_exists("pages", $_POST) ? '' : '';
	if(!$itemNumber) { $itemNumber = array_key_exists("itemNumber", $_GET) ? $_GET["itemNumber"] : ""; }
	
	
	if( $itemNumber && !array_key_exists("form", $_POST)) {
		if (!($stmt = $mysqli->prepare("SELECT features, info, itemName, type, os, pages FROM item WHERE itemNumber = ?"))) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $itemNumber))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		if (!$stmt->bind_result($features, $info, $itemName, $type, $os, $pages)) {
				echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		
		else { //no problems
			$stmt->fetch();
		}
	}

	
	if(array_key_exists("form", $_POST)) {
		if (!($stmt = $mysqli->prepare("INSERT INTO item(features, info, itemName, itemNumber, type, os, pages) values(?, ?, ?, ?, ?, ?, ?)"))) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		
		if (!($stmt->bind_param("sssssss", $features, $info, $itemName, $itemNumber, $type, $os, $pages))) {
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		else {
			header('Location: '.Home.'');
			exit();
			//echo "<p>Your item is added to Tech Library.</p>";
			// Need to change these lines later  		
			//echo "<p><a href=\"main.php\">Go back to the previous page</a></p>"; 
			//echo "<p><a href=\"logout.php\">Log out</a></p>";
		}
	} 
	
	get_header();
?>


<body>
<div data-role="page" id="page3" data-theme="a">
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">
		
		<?php get_menu(); ?>

		<script>
		function updateType() {
			if ( $( "#type option:selected" ).val() == "computer" ) {
				$( "#os-row" ).show();
				$( "#pages" ).val("");
				$( "#pages-row" ).hide();
			}
			else if ( $( "#type option:selected" ).val() == "book" )  {
				$( "#pages-row" ).show();
				$( "#os" ).val("");
				$( "#os-row" ).hide();
			} else {
				$( "#os" ).val("");
				$( "#pages" ).val("");
				$( "#pages-row" ).hide();
				$( "#os-row" ).hide();
			}
			
			//
		}
		</script>
		<div data-theme="a">
			<form id="itemEditForm" method="post" action="edit_item.php" data-ajax="false">
				<h3>Please Enter the New Item's Information and Submit</h3><br>
				<div><label for="itemNumber">Item Number: </label><input class="required" type="text" id="itemNumber" name="itemNumber" value="<?php echo $itemNumber; ?>"></input></div>
				<div><label for="itemName">Name:</label><input type="text" id="itemName" name="itemName" value="<?php echo $itemName; ?>" required></input></div>
				<div><label for="type">Type:</label><select id="type" name="type" onblur="javascript: updateType()">
					<option value="<?php echo $type; ?>" selected><?php echo $type; ?></option>
					<option value="computer">Computer</option>
					<option value="book">Book</option>
					<option value="other">Other</option>
					</select>
				</div>
				<div id="os-row" style="display:none;"><label for="os">OS: </label><input type="text" id="os" name="os" value="<?php echo $os; ?>"></input></div>
				<div id="pages-row" style="display:none;"><label for="pages">Pages: </label><input type="text" id="pages" name="pages" value="<?php echo $pages; ?>"></input></div>
				<div><label for="features">Features: </label><input type="text" id="features" name="features" value="<?php echo $features; ?>"></input></div>
				
				<div><label for="info">Other Info: </label><input type="text" id="info" name="info" value="<?php echo $info; ?>"></input></div>
				<input type="hidden" name="form" value="edit_item" />
				<div><input type="submit" value="Edit Item"/></div>
			</form>
			<script>$("#itemEditForm").validate();</script>
			
		</div>                  

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>