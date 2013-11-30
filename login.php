<?php
$title = "Login";
include(dirname(__FILE__).'/loader.php');

get_header();
?>
<body>
<script src="functions.js"></script>  
<script language="javascript" type="text/javascript">
</script>

<script>
/*
Getting description of login attempt:
status 0 means user attempted to load index without logging in
status 1 means invalid password
status 2 means invalid email
*/
$(document).ready(function(){
var status = getUrlVars()["login"];
if(status == 0)
	$("#error").html("Please Login First");
else if(status == 1)
	$("#error").html("Invalid Password, Please Try Again");
else if(status == 2)
	$("#error").html("Invalid Email, Please Try Again");
else if(status == 3)
	$("#error").html("Successfully Logged Out");
});
</script>
<div data-role="page" data-theme="a">
	
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">

		<div data-theme="a" id="error">
		</div>
		<div data-theme="a">
			<form id="loginForm" data-ajax="false" method="post" action="validate_login.php">
				<h3>Enter Email and Password</h3><br>
				<div><label for="email">E-Mail:</label><input id="email" type="email" name="email" required /></div>
				<div><label for="password">Password:</label><input id="password" type="password" name="password" required /></div>
				<div><input type="submit" value="Login"/></div>
			</form>
			<script>$("#loginForm").validate();</script>
		</div>                

		

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>
