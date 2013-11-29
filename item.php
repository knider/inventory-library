<?php
   	/* ===================================================================
	*   CS419 Project
	*	Fall 2013
	*	File Name: item.php
	*	Description: This will show the details of an item
	*  ================================================================= */
	include(dirname(__FILE__).'/loader.php');
	check_session();
	$title = "View Item";
	
	$itemNumber = array_key_exists("itemnum", $_POST) ? $_POST["itemnum"] : "";
	$item_id = array_key_exists("item_id", $_POST) ? $_POST["item_id"] : "";
	
	$form = array_key_exists("form", $_POST) ? $_POST["form"] : "";
	
	if ($itemNumber && $form == "checkin") { //check in
		
		//update item table
		if (!($stmt = $mysqli->prepare("UPDATE item SET status=0 WHERE itemNumber= ?"))) {
			echo "Update Item Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $itemNumber))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		$newstatus = "0";
		
		//get borrower ID
		if (!($stmt = $mysqli->prepare("SELECT borrower_id FROM item_borrower WHERE item_id=? ORDER BY id DESC LIMIT 1"))) {
			echo "Borrower Email Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $item_id))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		if ( !$stmt->bind_result($borrower_id) ) {
				echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		
		$stmt->store_result();
		
		$stmt->fetch();
		
		//update history log
		if($stmt = $mysqli->prepare("INSERT INTO item_borrower(status, item_id, borrower_id, user) VALUES(?, ?, ?, ?)")){
			echo "Update History Log Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		
		if (!($stmt->bind_param('iiis', $newstatus, $item_id, $borrower_id, $email))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }

		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; }
	
	} else if ($itemNumber && $form == "checkout") { // check out
		
		$borrower_id = array_key_exists("borrower_id", $_POST) ? $_POST["borrower_id"] : "";
		$newstatus = "1";
		
		//update item
		if (!($stmt = $mysqli->prepare("UPDATE item SET status=1 WHERE itemNumber= ?"))) {
			echo "Update Item Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $itemNumber))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		//update history log
		if($stmt = $mysqli->prepare("INSERT INTO item_borrower(status, item_id, borrower_id, user) VALUES(?, ?, ?, ?)")){
			echo "Update History Log Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		
		if (!($stmt->bind_param('iiis', $newstatus, $item_id, $borrower_id, $email))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }

		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; }
	
	} 
	
	//if it wasn't a POST, try to get the item number from a GET
	if(!$itemNumber) { $itemNumber = array_key_exists("itemnumber", $_GET) ? $_GET["itemnumber"] : ""; }
	
	if( $itemNumber) {
		if (!($stmt = $mysqli->prepare("SELECT id, features, info, itemName, type, os, pages, status FROM item WHERE itemNumber = ?"))) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $itemNumber))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		if ( !$stmt->bind_result($item_id, $features, $info, $itemName, $type, $os, $pages, $status) ) {
				echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		
		else { //no problems, show item details
			$list_data = "<ul class=\"itemDetailList\">\n";
			while($stmt->fetch()){
				if ($itemName) $list_data .= "<li class=\"itemName\">".$itemName."</li>\n";
				if ($itemNumber) $list_data .= "<li class=\"itemNumber\">".$itemNumber."</li>\n";
				if ($type) $list_data .= "<li class=\"itemType\">Type: ".$type."</li>\n";
				
				if ($os) $list_data .= "<li class=\"itemOS\">OS: ".$os."</li>\n";
				if ($pages) $list_data .= "<li class=\"itemPages\">Pages: ".$pages."</li>\n";
				if ($features) $list_data .= "<li class=\"itemFeatures\">Features: ".$features."</li>\n";
				if ($info) $list_data .= "<li class=\"itemInfo\">Other Info: ".$info."</li>\n";
				if($status == 1){
					$statusString = "Checked Out";
				} else {
					$statusString = "Available";
				}
				$list_data .= "<li class=\"itemStatus\">".$statusString."</li>\n";
			}
			$list_data .= "</ul>\n";
		}
		
		//Get borrowers for checkout
		if (!($stmt = $mysqli->prepare("SELECT id, name FROM borrower WHERE user=?"))) {echo "Prepare failed: " .$stmt->errno." ".$stmt->error;}
		if (!$stmt->bind_param('s',$email)) { echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error; }
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		if (!$stmt->bind_result($borrower_id, $name)) { echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error; }
		else {
			$stmt->store_result();
			$borrower_list = "<select name=\"borrower_id\">\n";
			while($stmt->fetch()){
				$borrower_list .= "<option value=\"" .$borrower_id. "\">" .$name. "</option>\n";
			}
			$borrower_list .= "</select>\n";
		}
		
	} else { //didn't have itemNumber
		$list_data = "<p>No item number provided</p>";
	}

	get_header();
?>


<body>
<div data-role="page" id="page2" data-theme="a">
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">
		<script>
		function getItemData(){
			var status = <?php echo $status;?>;
			if(status==1){
				$("#switch").val("OUT").slider("refresh");			
			} else $("#switch").val("IN").slider("refresh");
		}
		$(document).on("pagechange", getItemData);
		
		function closeout() {
			$("#checkoutPopup").popup("close");
			$("#switch").val("IN").slider("refresh");
		}
		function closein() {
			$("#checkinPopup").popup("close");
			$("#switch").val("OUT").slider("refresh");
		}
		</script>
		
		<?php get_item_menu(); ?>

		<div id="itemstuff" class="ui-grid-a">
			<div id="itemdata" class="ui-block-a">
				<?php echo $list_data; ?>
			</div>
			
			<div id="flipswitch" class="ui-block-b">
				<label for="flip-mini">Checked:</label>
				<select id="switch" name="flip-mini" data-role="slider" data-mini="true">
					<option value="IN">In</option>
					<option value="OUT">Out</option>
				</select>
				
				<div data-role="popup" id="checkoutPopup" class="ui-content" data-history="false" data-dismissible="false" data-transition="flip">
					<a href="javascript: closeout()" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
					<h3>Check OUT:</h3>
					<div>
						<form action="item.php?itemnumber=<?php echo $itemNumber; ?>" method="POST" data-ajax="false">
						<input type="hidden" name="form" value="checkout" />
						<input type="hidden" name="item_id" id="item_id" value="<?php echo $item_id; ?>" />
						<input type="hidden" name="itemnum" id="itemnum" value="<?php echo $itemNumber; ?>" />
						<?php echo $borrower_list; ?>
						<input type="submit" value="Check Out" />
						</form>
					</div>
				</div>

				<div data-role="popup" id="checkinPopup" data-history="false" class="ui-content" data-dismissible="false" data-transition="flip">
					<a href="javascript: closein()" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
					<div>
						<form action="item.php?itemnumber=<?php echo $itemNumber; ?>" method="POST" data-ajax="false">
						<input type="hidden" name="form" value="checkin" />
						<input type="hidden" name="item_id" id="item_id2" value="<?php echo $item_id; ?>" />
						<input type="hidden" name="itemnum" id="itemnum2" value="<?php echo $itemNumber; ?> "/>
						<input type="submit" value="Check In" />
						</form>
					</div>
				</div>
				
				<script>
				$("#switch").change(function(){
					var val = $("#switch").val();
					if(val == "OUT"){
						$("#checkoutPopup").popup("open");
					}else{
						$("#checkinPopup").popup("open");
					}

				});
				</script>

			</div>
		
		</div>                

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>