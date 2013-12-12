<?php
$title = "Register";
include(dirname(__FILE__).'/loader.php');

get_header();
?>
<body>
<div data-role="page" data-theme="a">
	
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">

		<div data-theme="a" id="error"> </div>
		
		<div data-theme="a">
			<form id="regForm" data-ajax="false" method="post" action="validate_reg.php">
				<h3>Enter Username and Password</h3><br>
				<div><label for="username">Username:</label><input type="text" id="username" name="username" minlength="4" required /></div>
				<div><label for="password">Password:</label><input type="password" id="password" name="password" minlength="8" required /></div>
				<input type="hidden" name="form" value="form" />
				<div><input type="submit" value="Register" /></div>
			</form>
			<script>$("#regForm").validate();</script>
		</div>                

		

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>
