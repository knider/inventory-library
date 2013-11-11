<?php
ini_set('display_errors', 'On');
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","starkst-db","e0Wm80emmSOBOQSD","starkst-db");
if($mysqli->connect_errno){
	echo"Connection Error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!DOCTYPE html><html><head>      <title>Item List Title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="themes/cs419.min.css" />
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
        <script src="jquery.mobile.popup.css"></script>

        <script src="jquery-1.10.2.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
        <script src="jquery.validate.min.js"></script>
        <script src="additional-methods.min.js"></script>
        <script src="functions.js"></script>  
		<style>
			table {margin: 1em; border-collapse: collapse} 
			th, td {padding:.3em;border:1px #ccc solid;text-align:left}
			thead{background:#fc9}
		</style>
        
</head><body><div data-role="page" id="page1" data-theme="a">
        <script>
        </script>

        <div data-role="header">
                <h1>Item List</h1>
        </div>

        <div data-role="content" data-theme="a">
				<div>
					<table>
						<tr>
							<th>Item Name</th>
							<th>Features</th>
							<th>Info</th>
							<th>Item Number</th>
							<th>OS</th>
							<th>Status</th>
							<th>Type</th>
						</tr>
						<?php
							if(!($stmt = $mysqli->prepare("SELECT itemName, features, info, itemNumber, os, status,
								type FROM item"))){echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute()){
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}

							if(!$stmt->bind_result($itemName, $features, $info, $itemNumber, $os, $status, $type)){
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch()){
							if($status === 1){
								$statusString = "Checked Out";
							}else $statusString = "Available";
 								echo "<tr>\n<td>\n" . $itemName . "\n</td>\n<td>\n" . $features . "\n</td>\n<td>\n" . $info . "\n</td>\n<td>\n" 
 								. $itemNumber  . "\n</td>\n<td>\n" . $os  . "\n</td>\n<td>\n" . $statusString  . "\n</td>\n<td>\n" . $type . "\n</td>\n</tr>";
							}	

							$stmt->close();
						?>
					</table>
				</div>
        </div>
</div>
</body>
</html>