<?php
   	/* ===================================================================
	*   CS419 Project
	*	Fall 2013
	*	File Name: item.php
	*	Description: This will show the details of an item
	*  ================================================================= */
	include(dirname(__FILE__).'/loader.php');
	check_session();

	$itemNumber = array_key_exists("itemnum", $_POST) ? $_POST["itemnum"] : "";
	
	$form = array_key_exists("form", $_POST) ? $_POST["form"] : "";
	
	if ($itemNumber && $form == "checkin") {
		
		if (!($stmt = $mysqli->prepare("UPDATE item SET status=0 WHERE itemNumber= ?"))) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $itemNumber))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
	
	} else if ($itemNumber && $form == "checkout") {
		
		$name = array_key_exists("borrower_name", $_POST) ? $_POST["borrower_name"] : "";
		$date = date("Ymd");
		
		if (!($stmt = $mysqli->prepare("UPDATE item SET status=1 WHERE itemNumber= ?"))) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $itemNumber))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
	

		if($stmt = $mysqli->prepare("INSERT INTO item_borrower(date, item_id, borrower_email) VALUES(?, (SELECT id FROM item WHERE itemNumber=?), (SELECT emailAddress FROM borrower WHERE name = ?))")){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		
		if (!($stmt->bind_param('sss', $date, $itemNumber, $name))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }

		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
	
	} 
	//if it wasn't a POST, try to get the item number from a GET
	if(!$itemNumber) { $itemNumber = array_key_exists("itemnumber", $_GET) ? $_GET["itemnumber"] : ""; }
	
	if( $itemNumber) {
		if (!($stmt = $mysqli->prepare("SELECT features, info, itemName, type, os, pages, status FROM item WHERE itemNumber = ?"))) {
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $itemNumber))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		if ( !$stmt->bind_result($features, $info, $itemName, $type, $os, $pages, $status) ) {
				echo "Binding result failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		
		else { //no problems
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
		if (!($stmt = $mysqli->prepare("SELECT name FROM borrower"))) {echo "Prepare failed: " .$stmt->errno." ".$stmt->error;}
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
				}else $("#switch").val("IN").slider("refresh");
			}
			$(document).on("pagechange", getItemData);
			//$(document).on("pageinit", ajaxData("ajaxForm","borrower_list.php"));			
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
				
				<div data-role="popup" id="popupBasic" class="ui-content" data-history="false" data-dismissible="false" data-transition="flip">
				<a href="index.php" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
					<h3>Check OUT:</h3>
					<div>
						<form action="item.php" method="POST" data-ajax="false">
						<input type="hidden" name="itemnum" id="itemnum" value="<?php echo $itemNumber; ?>">
						<input type="hidden" name="form" value="checkout">
						<?php echo $borrower_list; ?>
						<input type="submit" value="Check Out">
						</form>
					</div>
				</div>

				<div data-role="popup" id="checkinPopup" data-history="false" class="ui-content" data-dismissible="false" data-transition="flip">
				<a href="index.php" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
					<h3>CHECK IN?</h3>
					<div>
						<form action="item.php" method="POST" data-ajax="false">
						<input type="hidden" name="itemnum" id="itemnum2" value="<?php echo $itemNumber; ?>">
						<input type="hidden" name="form" value="checkin">
						<input type="submit" value="Check In">
						</form>
					</div>
				</div>
				
				<script>
				$("#switch").change(function(){
					var val = $("#switch").val();
					if(val == "OUT"){
						$("#popupBasic").popup("open");
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