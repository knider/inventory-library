
//I need to test this, but it should get data from a php page without 
//refreshing the page a user is on
function getData(div, phpPage){
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById(''+div).innerHTML = xmlhttp.responseText;
			}
		};
		document.getElementById(''+div).innerHTML = "";

		xmlhttp.open('GET', ''+phpPage, true);
	
		xmlhttp.send();
}
