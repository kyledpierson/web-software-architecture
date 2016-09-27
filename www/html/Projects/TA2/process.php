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
  <link rel="stylesheet" media="screen" type="text/css" href="ta_style.css"
    
	<title>TA Application Page</title>
    
  </head>
  
  <body>
    
	<div id="image_container">
		<img id="image"; src="dark_mosaic.png" alt="mosaic"/>
	</div>
	
	<h1>Application Submitted!</h1>
	
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
	
	<h2>Your application was submitted!</h2>
	<a href="display_apps.php"><p>Click here to view your applications</p></a>

<?php

  /**
   * Author: Kyle Pierson
   * Date: 2 February 2015
   * Assignment: TA2
   * Version: 1.0
   *
   * PHP code using PDO object used for communicating with the MySQL database
   * Stores information about applications and applicants in the database
   *
   */

include 'db_config.php';	// contains db connection variables, separated for security and abstraction purposes

try
{
	// The main content of the page will be in this variable
	$output = "";
	
	// Connect to the data base and select it.
	$db = new PDO("mysql:host=localhost;dbname=TA_Application;charset=utf8", $db_user_name, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	
	// Check the fields to make sure that they have been set
	$first = $_REQUEST['FirstName'];
	$last  = $_REQUEST['LastName'];
	$email = $_REQUEST['Email'];
	$role = "0";
	$userid = intval("0");
  
	// Build the basic query
	$query = "
	SELECT * FROM Users WHERE email = '$email'
	";

	// Prepare and execute the query
	$statement = $db->prepare( $query );
	$statement->execute(  );
	
	// Fetch the result
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	
	// If this user existed in the database, get his or her id
	if($result)
	{
		$userid = intval($result[user_id]);
	}
	else
	{
		// Otherwise, we need to add the user to the database and get the newly generated id
		$query =     "
		INSERT INTO Users (first_name, last_name, email, user_password, role)
		VALUES ('$first', '$last', '$email', '$first', '$role')
		";

		$statement = $db->prepare( $query );
		$statement->execute(  );
		$userid = intval($db->lastInsertId());
	}
	
	// Get some fields to insert about the user
	$gpa = $_REQUEST['GPA'];
	$major  = $_REQUEST['Major'];
	$academic_level = $_REQUEST['Academic'];
	$phone = $_REQUEST['Phone'];
	$myAddress = "myAddress";
	$myCity = "myCity";
	$myState = "myState";
	$myZip = "myZip";
	
	$query = "
	INSERT INTO Applicant_Info (user_id, gpa, major, academic_level, phone, address, city, state, zip)
	VALUES ('$userid', '$gpa', '$major', '$academic_level', '$phone', '$myAddress', '$myCity', '$myState', '$myZip')
	";
	
	$statement = $db->prepare( $query );
	$statement->execute(  );
	
	$check = $_POST['taken'];
	foreach($check as $value)
	{
		// Submits course info when given class number as value (referenced from process.php which references ta_application_form)
		$grade_index = 'grade' . $value;
		$term_index = 'term' . $value;
		$year_index = 'year' . $value;
		
		$grade = $_POST[$grade_index];
		$term = $_POST[$term_index];
		$year = $_POST[$year_index];
		$dept_name = "CS";
		
		// Get the course info
		$query = "
		SELECT course_info_id FROM Course_Info WHERE dept_name = '$dept_name' AND course_num = '$value'
		";

		$statement = $db->prepare( $query );
		$statement->execute(  );

		$result = $statement->fetch(PDO::FETCH_ASSOC);
		$course_info_id = intval($result[course_info_id]);

		// Get the specific class info
		$query = "
		SELECT course_id FROM Courses WHERE course_info_id = '$course_info_id' AND term = '$term' AND course_year = '$year'
		";
		
		$statement = $db->prepare( $query );
		$statement->execute(  );

		$result = $statement->fetch(PDO::FETCH_ASSOC);
		$course_id = intval($result[course_id]);
		
		// Use this info to put an entry in the courses_taken table for this user
		$query = "
		INSERT INTO Courses_Taken (timestamp_taken, user_id, course_id, grade, valid_taken)
		VALUES (NOW(), '$userid', '$course_id', '$grade', '1')
		";

		$statement = $db->prepare( $query );
		$statement->execute(  );
	}
	
	$check = $_POST['apply'];
	foreach($check as $value)
	{
		$essay = $_REQUEST['Essay'];

		// Get the course info again
		$query = "
		SELECT course_info_id FROM Course_Info WHERE dept_name = '$dept_name' AND course_num = '$value'
		";
		$statement = $db->prepare( $query );
		$statement->execute(  );

		$result = $statement->fetch(PDO::FETCH_ASSOC);
		$course_info_id = intval($result[course_info_id]);

		// Use this course info to submit an application for the user
		$query = "
		INSERT INTO Course_Applications (timestamp_app, user_id, course_info_id, essay, valid_app)
		VALUES (NOW(), '$userid', '$course_info_id', '$essay', 1)
		";
		$statement = $db->prepare( $query );
		$statement->execute(  );
	}
}
catch (PDOException $ex)
{
  $output .= "<p> Code: {$ex->getMessage()} </p>";
}

//
// Build the web page for the results
//

echo <<<END

$output

END;

?>
	
  </body>
</html>