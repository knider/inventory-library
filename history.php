<?php

	$title = "Item History";
	include(dirname(__FILE__).'/loader.php');
	check_session();
	get_header();
	
	echo "
	<style>
		table {margin: 1em; border-collapse: collapse} 
		th, td {padding:.3em;border:1px #ccc solid;text-align:left}
		thead{background:#fc9}
	</style>
	";

	
	
	
?>
<body><div data-role="page" id="page5" data-theme="a">
	
	<?php get_page_header(); ?>

	<div data-role="content">
		<!--<script>
		function getHistory(){
				ajaxData("historydata", "history.php");
			}
		$(document).on("pagechange", getHistory);			
		</script>-->

		<?php get_menu(); ?>

		<div id="itemstuff">
			
			<div id="historydata">
			<?php
			if($stmt = $mysqli->prepare("SELECT date, i.itemName, i.status, borrower_email ". 
										"FROM item_borrower ib ".
										"LEFT JOIN item i ON ib.item_id = i.id ".
										"ORDER BY date DESC")){
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($date,$itemName,$status,$email);
		echo "<table><tr><td>Date</td><td>Item Name</td><td>Borrower</td><td>Status</td></tr>";
		while($stmt->fetch()){
			$status_str = ($status) ? "Checked Out" : "Checked In";
			$status_color = ($status) ? "#990000" : "#009900";
			echo "<tr><td>".$date."</td><td>".$itemName."</td><td>".$email."</td><td style='color: ".$status_color." '>".$status_str."</td><tr>";
		}
		echo "</table>";
	}
			
			?>
			</div>
		
		</div>
	
	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>