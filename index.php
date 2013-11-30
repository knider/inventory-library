<?php
	include(dirname(__FILE__).'/loader.php');
	session_set_cookie_params(60);
	check_session();
	$title = "";
	$subtitle = $email;
	get_header();
?>

<body>
<script language="javascript" type="text/javascript">
	//Popup window code 
	/* function listPopup(url){
		popupWindow = window.open(url, 'popUpWindow', 'height=500, width=1000,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
	} */
</script>
<div data-role="page" id="page1" data-theme="a">
	
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">
		<script>
        $("#page1").on("pagechange", getAjax("page1", "get_item_list.php", "ulist"));
        </script>
		<?php get_home_menu(); ?>

		

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>
