/*
sources listed as comments
*/

//gets information from website parameter and displays it in the 
//docID field on the html page
function ajaxData(docID, website){
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById(""+ docID).innerHTML = xmlhttp.responseText;
			}
		};
		document.getElementById(""+docID).innerHTML = "";

		xmlhttp.open('GET', ""+website, true);
	
		xmlhttp.send();
}

//specific code for creating the listview
function getAjax(pageDOM, website, newDOM){
	//http://the-jquerymobile-tutorial.org/jquery-mobile-tutorial-CH11.php

		if($("#"+pageDOM).innerHTML != ""){
			$("#"+pageDOM).innerHTML = "";
		}

		$.ajax (
		{ 
  			url : ""+website, 
  			complete : function (xhr, result)
  		{
   			if (result != "success") return;
   	 		var response = xhr.responseText;
   	 		$("#"+pageDOM+" div:jqmData(role=content)").append (response);
   	 		$("#"+newDOM).listview ();
 		}
	}); 
}

//called after searching for an item and clicking

//http://snipplr.com/view/19838/get-url-parameters/
function getUrlVars() {
	var map = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		map[key] = value;
	});
	return map;
}