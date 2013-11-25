<?php
	session_start();
	$email = $_SESSION['email'];
	if(isset($_SESSION['email'])){
	}
	else{
		header('Location: login.php?login=0');
	}

	$title = "Add Borrower";
	include(dirname(__FILE__).'/loader.php');
	
	$name = array_key_exists("name", $_POST) ? $_POST["name"] : '';
	$email = array_key_exists("email", $_POST) ? $_POST["email"] : '';
	$address = array_key_exists("address", $_POST) ? $_POST["address"] : '';
	$phone = array_key_exists("phone", $_POST) ? $_POST["phone"] : '';

	if ($name) {
		if ( !($stmt = $mysqli->prepare("INSERT INTO borrower(name,emailAddress,phoneNumber,streetAddress) values(?,?,?,?)") ) ) {
			echo "Prepare failed: (" . $mysqli->errno . ")" . $mysqli->error;
		}
		if ( !$stmt->bind_param('ssss', $name, $email, $phone, $address) ) { 
			echo "Bind paramaters failed: (" . $mysqli->errno . ")" . $mysqli->error; 
		}
		if ( !$stmt->execute() ) { echo "Execute failed: (" . $mysqli->errno . ")" . $mysqli->error; }
		else {
			header('Location: '.Home.'');
			exit();
		}
	}
	
	
	
	get_header();
?>

<body>
<div data-role="page" id="page3" data-theme="a">
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">
		
		<?php get_menu(); ?>

		<div data-theme="a">
			<form id="borrowerForm" data-ajax="false" method="post" action="add_borrower.php">
				<!--<input type="hidden" name="form" value="add_borrower">-->
				<h3>Please Enter the New Borrower's Information and Submit</h3><br>
				<div><label for="name">Name: </label><input id="name" name="name" type="text" required /></div>
				<div><label for="email">E-Mail:</label><input id="email" type="email" name="email" required /></div>
				<div><label for="phone">Phone Number: </label><input class="phoneUS" id="phone" name="phone"></div>
				<div><label for="address">Address:</label><input id="address" type="text" name="address" /></div>
				<div><input type="submit" value="Add Borrower"/></div>
			</form>
			<script>$("#borrowerForm").validate();</script>
		</div>                

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>