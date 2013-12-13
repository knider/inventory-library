<?php
	include(dirname(__FILE__).'/loader.php');
	check_session();
	$title = "";
	$subtitle = getNumberOfItems($email);
	get_header();
?>

<body>

<div data-role="page" id="page1" data-theme="a">
	
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">
		
		<?php get_home_menu(); ?>
		<div id="clear" style="margin-top:15px; clear: both;"></div>
		

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>
