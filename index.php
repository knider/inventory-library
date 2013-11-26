<?php
	$title = "";
	$subtitle = $email;
	include(dirname(__FILE__).'/loader.php');
	check_session();
	get_header();
?>

<body>
<script language="javascript" type="text/javascript">
	//Popup window code
	function listPopup(url){
		popupWindow = window.open(url, 'popUpWindow', 'height=500, width=1000,left=1-,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
	}
</script>
<div data-role="page" id="page1" data-theme="a">
	
	<?php get_page_header(); ?>
	
	<div data-role="content" data-theme="a">
		<script>
        $("#page1").on("pagechange", getAjax("page1", "get_item_list.php", "ulist"));
        </script>
		<div id="mainbuttons" class="ui-grid-b">
			<div class="ui-block-a">
					<a href="add_item.php" data-role="button" data-mini="true">+ Item</a>
					<p id="here3">
					</p>
			</div>
			<div class="ui-block-b">
					<a href="add_borrower.php" data-role="button" data-mini="true">+ Borrower</a>
					<p id="here3">
					</p>
			</div>
			<div class="ui-block-c">
					<a href="logout.php" data-ajax="false" data-role="button" data-mini="true">Logout</a>
					</p>
			</div>
		</div>                
		<div id="secondary buttons" class="ui-grid-a">
			<div class="ui-block-a">
					<a href="checking.php" data-role="button" data-mini="true">Check In/Out</a>
					<p id="here1">
					</p>
			</div>
			<div class="ui-block-b">
					<a href="history.php" data-role="button" data-ajax="false" data-mini="true">History</a>
			</div>
			
		</div> 

		

	</div> <!-- /content -->
</div> <!-- /page -->
</body>
</html>
