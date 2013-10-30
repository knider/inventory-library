

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
