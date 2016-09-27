// Uses Ajax to update the welcome line at the top of the page
function showInfo () {
	
	// Get the name and planet
	name = document.infoForm.firstName.value;
	planet = document.infoForm.planet.value;

	// Get a request object
	var xmlhttp = GetXmlHttpObject();
	if (xmlhttp == null) {
		alert("Your browser does not support Ajax!");
		return;
	}
	
	// Compose the URL of the server-side script
	var url = "../src/info7.php" + "?firstName=" + name + "&planet=" + planet;

	// This function will be called when a response is received
	xmlhttp.onreadystatechange = function () {update(xmlhttp);};
	
	// Make the request
	xmlhttp.open("GET", url, true);
	xmlhttp.send(null);
	
}


// When the response is received, updates the page
function update (request) {
	if (request.readyState == 4 && request.status == 200) {
		var pieces = request.responseText.split("\n");
		document.getElementById("current").innerHTML = pieces[0];
		document.getElementById("firstName").value = pieces[1];
		document.getElementById("welcome").innerHTML = pieces[2];
		document.getElementById("favorite").innerHTML = pieces[3];
	}
}


// Browser-specfic code for obtaining an XMLHttpRequest object
function GetXmlHttpObject () {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject) {
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}