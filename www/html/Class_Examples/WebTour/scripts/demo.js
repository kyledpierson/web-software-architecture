// Rotates the rows in the planet table

function rotate (dir) {
	
	// Save information from first column
	var image = document.getElementById("image1").innerHTML;
	var label = document.getElementById("label1").innerHTML;
	
	// Move according to direction
	if (dir < 0) {

		// Move second column over to first column
		document.getElementById("image1").innerHTML = 
			document.getElementById("image2").innerHTML;
		document.getElementById("label1").innerHTML = 
			document.getElementById("label2").innerHTML;

		// First third column over to second column
		document.getElementById("image2").innerHTML = 
			document.getElementById("image3").innerHTML;
		document.getElementById("label2").innerHTML = 
			document.getElementById("label3").innerHTML;

		// Move original first column to third column
		document.getElementById("image3").innerHTML = 
			image;
		document.getElementById("label3").innerHTML = 
			label;	

	}
	
	else if (dir > 0) {
		
		// Move last column over to first column
		document.getElementById("image1").innerHTML = 
			document.getElementById("image3").innerHTML;
		document.getElementById("label1").innerHTML = 
			document.getElementById("label3").innerHTML;
		
		// Move second column over to third column
		document.getElementById("image3").innerHTML = 
			document.getElementById("image2").innerHTML;
		document.getElementById("label3").innerHTML = 
			document.getElementById("label2").innerHTML;
		
		// Move original first column over to second column
		document.getElementById("image2").innerHTML = 
			image;
		document.getElementById("label2").innerHTML = 
			label;	
	}
	
}