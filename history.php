<?php

	$title = "Item History";
	include(dirname(__FILE__).'/loader.php');
	check_session();
	get_header();

	if(array_key_exists("clear", $_POST))
	{
		if (!($stmt = $mysqli->prepare("delete from item_borrower where user = ?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		if ( !$stmt->bind_param('s', $_SESSION['email']) ) { echo "Bind failed: (" . $mysqli->errno . ")" . $mysqli->error; }
		if ( !$stmt->execute() ) { echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error; }
	}
?>
<script>

function submitForm(){
	if (confirm('Are you sure you wish to clear all item history?')) {
		document.getElementById("clearForm").submit();
    }
}

</script>
<body><div data-role="page" id="page5" data-theme="a">
	<?php 
	echo "
	<style>
		table {margin: 1em; border-collapse: collapse} 
		th, td {padding:.3em;border:1px #ccc solid;text-align:left}
		thead{background:#fc9}
	</style>
	"; 
	?>
	<?php get_page_header(); ?>

	<div data-role="content">

		<?php get_history_menu(); ?>

		<div id="itemstuff">
			
			<div id="historydata">
			<?php
		if (!($stmt = $mysqli->prepare("SELECT ib.id, ib.date, i.itemName, i.itemNumber, ib.status, b.name, ib.user ". 
										"FROM item_borrower ib ".
										"LEFT JOIN item i ON ib.item_id = i.id ".
										"LEFT JOIN borrower b ON ib.borrower_id = b.id ".
										"WHERE ib.user=? ".
										"ORDER BY ib.id DESC"))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if (!($stmt->bind_param('s', $email))) { echo "Bind failed: "  . $stmt->errno . " " . $stmt->error; }
		
		if (!$stmt->execute()){ echo "Execute failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		if (!$stmt->store_result()){ echo "Store result failed: "  . $stmt->errno . " " . $stmt->error; } 
		
		$stmt->bind_result($id,$date,$itemName,$itemNumber,$status,$borrower,$user);
		
		if (!$stmt->num_rows) {
			printf("No history log entries.");
		} else {
		
		echo "<table><tr><td>Date</td><td>Item Number</td><td>Item Name</td><td>Borrower</td><td>Status</td></tr>";
		
		while($stmt->fetch()){
			$status_str = ($status) ? "Checked Out" : "Checked In";
			$status_color = ($status) ? "#990000" : "#009900";
			echo "<tr><td>".$date."</td><td>".$itemNumber."</td><td>".$itemName."</td><td>".$borrower."</td><td style='color: ".$status_color." '>".$status_str."</td><tr>";
		}
		
		echo "</table>";
		}
			
			?>
			</div>
		</div>
		<div>
			<form id="clearForm" method="POST" action="history.php">
				<input type="hidden" id="clear" value="clear" name="clear">
			</form>
		</div>
	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>