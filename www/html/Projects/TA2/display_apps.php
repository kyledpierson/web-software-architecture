<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<!--
		Author:		Kyle Pierson
		Date:		4 February 2015
		Version:	1.0

		This is the php page for the processing of the data recieved in the
		application form.
-->


<html lang="en">
  
  <head>
  <meta charset="utf-8">
  <link rel="stylesheet" media="screen" type="text/css" href="ta_style.css">
    
	<title>TA Application Page</title>
    
  </head>
  
  <body>
    
	<div id="image_container">
		<img id="image"; src="dark_mosaic.png" alt="mosaic"/>
	</div>
	
	<h1>Look up your applications</h1>
	
	<div id="image_container_2">
		<img id="computer" src="computer.png" alt="computer_image">
	</div>
	
		<div id="right_section">
	</div>
	
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
	
	<h2>Please enter your email address</h2>
	<form method="post">
	<p><label for="email_lookup">Email</label>
	<input type="text" id="email_lookup" name="email_lookup"/></p>
	<input type="submit" value="View Applications"/></form>
	
	<div id = "main_text">

<?php

include 'db_config.php';         // contains db connection variables
                                 // separated for security and abstraction purposes

try
{
  //
  // The main content of the page will be in this variable
  //
  $output = "";
  
  //
  // Connect to the data base and select it.
  //
  $db = new PDO("mysql:host=localhost;dbname=TA_Application;charset=utf8", $db_user_name, $db_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


  //
  // Check to see if a new addition has been requested
  //
  
  if (isset ( $_POST['email_lookup'] ))
    {
		$email = $_POST['email_lookup'];
      
		$query = "
		SELECT * FROM Users WHERE email = '$email'
		";

		$statement = $db->prepare( $query );
		$statement->execute(  );
		
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		

		if(empty($result))
		{
			$output .= "<p style=\"color:white;\">You have not applied for any courses</p>";
		}
		else
		{
			$user_id = intval($result[user_id]);
			$first_name = $result[first_name];
			$last_name = $result[last_name];
			
			$output = "<h2>Displaying applications for " . $first_name . " " . $last_name . "</h2>";
			
			$query = "
			SELECT * FROM Applicant_Info WHERE user_id = '$user_id' ORDER BY timestamp_info DESC LIMIT 1
			";
			$statement = $db->prepare( $query );
			$statement->execute(  );
			
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			$gpa = $result[gpa];
			$major = $result[major];
			$academic_level = $result[academic_level];
			$phone = $result[phone];
			
			
			$output .= "<table><th>GPA</th><th colspan=\"2\">Major</th><th>Academic Level</th><th>Phone Number</th></tr>"
						.   "<tr><td>" . $gpa . "</td>"
						.	"<td colspan=\"2\">" . $major . "</td>"
						.	"<td>" . $academic_level . "</td>"
						.	"<td>" . $phone . "</td></tr><tr><th colspan=\"5\">Courses Taken</th></tr>";
						
			$query = "
			SELECT course_id FROM Courses_Taken WHERE user_id = '$user_id' GROUP BY course_id
			";
			
			$statement = $db->prepare( $query );
			$statement->execute(  );
			
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			if(empty($result))
			{
				$output .= "<tr><td colspan=\"5\">None</td></tr>";
			}
			else
			{
				$output .= "<tr><th>Class</th><th>Teacher</th><th>Term</th><th>Year</th><th>Grade</th></tr>";
			
				foreach($result as $row)
				{
					$mult_course_id = $row[course_id];
				
					$query = "
					SELECT * FROM Courses_Taken WHERE course_id = '$mult_course_id' ORDER BY timestamp_taken DESC LIMIT 1
					";
					
					$statement = $db->prepare( $query );
					$statement->execute(  );
				
					$result = $statement->fetch(PDO::FETCH_ASSOC);
					$grade = $result[grade];
					
					
					$query = "
					SELECT * FROM Courses WHERE course_id = '$mult_course_id'
					";
					
					$statement = $db->prepare( $query );
					$statement->execute(  );
				
					$result = $statement->fetch(PDO::FETCH_ASSOC);
					$term = $result[term];
					$year = $result[course_year];
					$teacher_id = $result[user_id];
					
					$query = "
					SELECT * FROM Course_Info WHERE course_info_id = " . $result[course_info_id];
					
					$statement = $db->prepare( $query );
					$statement->execute(  );
				
					$result = $statement->fetch(PDO::FETCH_ASSOC);
					$dept_name = $result[dept_name];
					$course_num = $result[course_num];
					
					$query = "
					SELECT * FROM Users WHERE user_id = '$teacher_id'
					";
					
					$statement = $db->prepare( $query );
					$statement->execute(  );
				
					$result = $statement->fetch(PDO::FETCH_ASSOC);
					$teacher_first = $result[first_name];
					$teacher_last = $result[last_name];
					
					$output .=	"<tr><td>" . $dept_name . " " . $course_num . "</td><td>" . $teacher_first . " " . $teacher_last . "</td><td>"
									. $term . "</td><td>" . $year . "</td><td>" . $grade . "</td></tr>";
				}
			}
			
			
			$output .= "<tr><th colspan=\"5\">Courses Applied For</th></tr><tr><th>Course</th><th colspan=\"4\">Essay</th></tr>";
			
			$query = "
			SELECT course_info_id FROM Course_Applications WHERE user_id = '$user_id' GROUP BY course_info_id
			";
			
			$statement = $db->prepare( $query );
			$statement->execute(  );
			
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
			if(empty($result))
			{
				$output .= "<tr><td colspan=\"5\">None</td></tr>";
			}
			foreach($result as $row)
			{
				$mult_course_id = $row[course_info_id];
			
				$query = "
				SELECT * FROM Course_Applications WHERE course_info_id = '$mult_course_id' ORDER BY timestamp_app DESC LIMIT 1
				";
				
				$statement = $db->prepare( $query );
				$statement->execute(  );
			
				$result = $statement->fetch(PDO::FETCH_ASSOC);
				$essay = $result[essay];
				
				
				$query = "
				SELECT * FROM Course_Info WHERE course_info_id = '$mult_course_id'
				";
				
				$statement = $db->prepare( $query );
				$statement->execute(  );
			
				$result = $statement->fetch(PDO::FETCH_ASSOC);
				$dept_name = $result[dept_name];
				$course_num = $result[course_num];
				
				$output .=	"<tr><td>" . $dept_name . " " . $course_num . "</td><td colspan=\"4\">" . $essay . "</td></tr>";
			}
			
			$output .= "</table>";
		}
	}
}
catch (PDOException $ex)
{
  $output .= "<p> Code: {$ex->getMessage()} </p>";
}


//
// Below is the HTML content
//

echo <<<END
	
	$output
	
	</div>
	</body>
	</html>

END;

?>
