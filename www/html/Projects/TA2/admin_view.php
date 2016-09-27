<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<!--
		Author:		Kyle Pierson
		Date:		4 February 2015
		Version:	1.0

		This is the webpage for the administrator's view.  It shows all classes
		that are currently seeking a TA.
-->


<html lang="en">
  
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" media="screen" type="text/css" href="ta_style.css">
    
	<title>TA Application Page</title>
    
  </head>
  
  <body>
    
	<!--The header images-->
	<div id="image_container">
		<img id="image" src="dark_mosaic.png" alt="mosaic"/>
	</div>
		
	<h1>Administrator View</h1>
	
	<div id="image_container_2">
		<img id="computer" src="computer.png" alt="computer_image">
	</div>
	
	<!--The section on the right-->
	<div id="right_section">
	</div>
	
		<!--The right-side menu-->
		<div id="menu">
		<ul style="list-style-type:none">
			<a href="index.html"><li>Home</li></a>
			<a href="ta_application_form.php"><li>Apply Here</li></a>
			<a href="display_apps.php"><li>View your Applications</li></a>
			<a href="admin_view.php"><li>Administrator View</li></a>
			<a href="http://uofu-cs4540-57.cloudapp.net"><li>My Website</li></a>
			<a href="schema.html"><li>Database Schema</li></a>
			<a href="README.html"><li>README</li></a>
		</ul>
	</div>
	
	<h2>Below is a list of classes open for TAs</h2>
	
	<table border="1">
      <tr>
        <th>Course</th>
        <th>Details</th>
		<th>Instructor</th>
		<th>Credits</th>
		<th>Term</th>
		<th>Year</th>
		<th>TA's Needed</th>
		<th>TA's Assigned</th>
      </tr>
	  
<?php

include 'db_config.php';	// contains db connection variables, separated for security and abstraction purposes

try
{

	// The main content of the page will be in this variable
	$output = "";
	
	// Connect to the data base and select it.
	$db = new PDO("mysql:host=localhost;dbname=TA_Application;charset=utf8", $db_user_name, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	
	// Query for getting every class
	$query =     "
	SELECT * FROM Courses
	";

	$statement = $db->prepare( $query );
	$statement->execute(  );
			
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
  
  
	// Once we have all the classes, loop through and display them in the table
    foreach ($result as $row)
	{
		$query = "
		SELECT * FROM Course_Info WHERE course_info_id = " . $row['course_info_id'];
	
		$statement = $db->prepare( $query );
		$statement->execute(  );
				
		$result_two = $statement->fetch(PDO::FETCH_ASSOC);
	
		$dept_name = $result_two[dept_name];
		$course_num = $result_two[course_num];
		$credits = $result_two[credits];
		$course_details = $result_two[course_details];
		$teacher_id = $row['user_id'];
		
		$query = "
		SELECT * FROM Users WHERE user_id = '$teacher_id'
		";
		
		$statement = $db->prepare( $query );
		$statement->execute(  );
				
		$result_two = $statement->fetch(PDO::FETCH_ASSOC);
		
		$first_name = $result_two[first_name];
		$last_name = $result_two[last_name];
		$course_id = $row['course_id'];
		
		
		$output .=
        "<tr>"
        .  "<td>" . $dept_name . " " . $course_num . "</td>"
        .  "<td>" . $course_details . "</td>"
		.  "<td>" . $first_name . " " . $last_name . "</td>"
		.  "<td>" . $credits . "</td>"
		.  "<td>" . $row['term'] . "</td>"
		.  "<td>" . $row['course_year'] . "</td>"
		.  "<td>" . $row['ta_num'] . "</td>"
		.  "<td>";

		$query = "
		SELECT * FROM Assignments WHERE course_id = '$course_id'
		";
		
		$statement = $db->prepare( $query );
		$statement->execute(  );
				
		$result_two = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result_two as $row_two)
		{
			$ta_id = $row_two[user_id];
			
			$query = "
			SELECT * FROM Users WHERE user_id = '$ta_id'
			";
			
			$statement = $db->prepare( $query );
			$statement->execute(  );
					
			$result_three = $statement->fetch(PDO::FETCH_ASSOC);
			$ta_first = $result_three[first_name];
			$ta_last = $result_three[last_name];
			
			$output .= $ta_first . " " . $ta_last . ", ";
		}
		
        $output .=  "</td></tr>";
		
	}

	//End the table
     $output .=   "</table>";
}
catch (PDOException $ex)
{
  $output .= "<p> Error Code: {$ex->getCode()} </p>";
}

echo <<<END

$output

END;

?>
	  
	  </table>
	
	</body>
</html>
