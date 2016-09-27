<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<!-- 	This is the php page for the processing of the data recieved in the
		application form.-->


<html lang="en">
  
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" media="screen" type="text/css" href="http://uofu-cs4540-57.cloudapp.net/Projects/TA1/ta_style.css">
    
	<title>TA Application Page</title>
    
  </head>
  
  <body>
    
	<div id="image_container">
		<img id="image"; src="http://uofu-cs4540-57.cloudapp.net/Projects/TA1/dark_mosaic.png" alt="mosaic"/>
	</div>
	
	<h1>Application Submitted!</h1>
	
	<div id="image_container_2">
		<img id="computer" src="http://uofu-cs4540-57.cloudapp.net/Projects/TA1/computer.png" alt="computer_image">
	</div>
	
		<div id="right_section">
	</div>
	
	<div id="menu">
		<ul style="list-style-type:none">
			<a href="http://uofu-cs4540-57.cloudapp.net/Projects/TA1/index.html"><li>Home</li></a>
			<a href="http://uofu-cs4540-57.cloudapp.net/Projects/TA1/ta_application_form.html"><li>Apply Here</li></a>
			<a href="http://uofu-cs4540-57.cloudapp.net/Projects/TA1/admin_view.html"><li>Administrator View</li></a>
			<a href="http://uofu-cs4540-57.cloudapp.net"><li>My Website</li></a>
		</ul>
	</div>
	
	<h2>Below are your responses to the previous questions:</h2>
  
  <table border="1">
      <tr>
        <th>Field</th>
        <th>Your Response</th>
      </tr><?php 
		foreach ($_REQUEST as $name => $value)
		{
			if($name !="FormType" && $name !="SubmitButton")
				echo "<tr><td>$name</td><td>$value</td></tr>";
		}
	?>
	</table>
	
  </body>
</html>