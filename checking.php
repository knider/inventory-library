<?php
   	
	$title = "Item Check-In/Out";
	include(dirname(__FILE__).'/loader.php');
	get_header();
	
?>
<body>
<div data-role="page" id="page3" data-theme="a">
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">
		
		<?php get_menu(); ?>

		
		<div data-theme="a">
			Get item, get its status, change status
			
		</div>                  

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>