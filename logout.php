<?php
header('Location: login.php?login=3');
ini_set('display_errors', 'On');
session_start();
	if(isset($_SESSION['email'])){
	unset($_SESSION);
	session_destroy();
	session_write_close();
	}
exit;
?>