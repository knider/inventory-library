<?php
   	/* ===================================================================
	*   CS419 Project
	*	Fall 2013
	*	File Name: add_item.php
	*	Description: This will add a new item to the item table
	*  ================================================================= */
	$title = "Add Item";
	include(dirname(__FILE__).'/loader.php');
	check_session();

	$features = array_key_exists("features", $_POST) ? $_POST["features"] : '';
	$info = array_key_exists("info", $_POST) ? $_POST["info"] : '';
	$itemName = array_key_exists("itemName", $_POST) ? $_POST["itemName"] : '';
	$itemNumber = array_key_exists("itemNumber", $_POST) ? $_POST["itemNumber"] : '';
	$type = array_key_exists("type", $_POST) ? $_POST["type"] : '';
	$os = array_key_exists("os", $_POST) ? $_POST["os"] : '';
	$pages = array_key_exists("pages", $_POST) ? '' : '';
	
	if( $itemNumber) {
		if (!($stmt = $mysqli->prepare("INSERT INTO item(features, info, itemName, itemNumber, type, os, pages, user) values(?, ?, ?, ?, ?, ?, ?,?)"))) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		
		if (!($stmt->bind_param("ssssssss", $features, $info, $itemName, $itemNumber, $type, $os, $pages, $email))) {
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}

		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		else {
			header('Location: '.Home.'');
			exit();
			//echo "<p>Your item is added to Tech Library.</p>";
			/* Need to change these lines later */ 		
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
			} else if ( $( "#type option:selected" ).val() == "book" )  {
				$( "#pages-row" ).show();
				$( "#os" ).val("");
				$( "#os-row" ).hide();
			} else {
				$( "#os" ).val("");
				$( "#pages" ).val("");
				$( "#pages-row" ).hide();
				$( "#os-row" ).hide();
			}
		}
		</script>
		<div data-theme="a">
			<form id="itemAddForm" method="post" action="add_item.php" data-ajax="false">
				<h3>Please Enter the New Item's Information and Submit</h3><br>
				<div><label for="itemNumber">Item Number: </label><input type="text" id="itemNumber" name="itemNumber" required /></div>
				<div><label for="itemName">Name:</label><input type="text" id="itemName" name="itemName" required /></div>
				<div><label for="type">Type:</label><select id="type" name="type" onblur="javascript: updateType()">
					<option value="" selected></option>
					<option value="computer">Computer</option>
					<option value="book">Book</option>
					<option value="other">Other</option>
					</select>
				</div>
				<div id="os-row" style="display:none;"><label for="os">OS: </label><input type="text" id="os" name="os"></div>
				<div id="pages-row" style="display:none;"><label for="pages">Pages: </label><input type="text" id="pages" name="pages"></div>
				<div><label for="features">Features: </label><input type="text" id="features" name="features"></div>
				
				<div><label for="info">Other Info: </label><input type="text" id="info" name="info"></div>
				<div id="item buttons" class="ui-grid-a">
					<div class="ui-block-a"><input type="reset" value="Clear All"/></div>
					<div class="ui-block-b"><input type="submit" value="Add Item"/></div>
				</div>			
			</form>
			<script>$("#itemAddForm").validate();</script>
			
		</div>                  

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>