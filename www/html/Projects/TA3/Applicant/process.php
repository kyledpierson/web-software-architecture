<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for processing applications

-->

<?php
  require_once "../authentication.php";
  
  verifyLogin(0);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Application Submitted</title>
<link href="../style.css" rel="stylesheet" type="text/css">
</head>
  
<body>
<div id="wrapper">

  <img id="headerbg" src="../Images/background_swirl.png" alt="headerbg"/>

<p id="subtitle">Welcome to the TA Application, this is your first step on the path to becoming a TA.</p>

  <div id="rhs"></div>

  <header>
    <img id="icon" src="../Images/earth.png" alt="icon"/>
    <h1>TA Application</h1>
  </header>

  <ul>
    <a href="app_home"><li>Home</li></a>
    <a href="application.php"><li>Apply Here</li></a>
    <a href="get_apps.php"><li>View Applications</li></a>
    <?php
        if(isset($_SESSION['user_id'])) { echo "<a href=\"../logout.php\"><li>Logged in as " . $_SESSION['first_name'] . " (Log Out)</li></a>"; }
      ?>
  </ul>

  <div id="main">
    <h2>Your Application Was Submitted!</h2>
  </div>
</div>

<?php

require_once '../db.php';
session_start();

// Get some fields to insert about the user
$user_id = $_SESSION['user_id'];
$gpa = $_REQUEST['GPA'];
$major  = $_REQUEST['Major'];
$academic_level = $_REQUEST['Academic'];
$dept_name = "CS";

$coursesTaken = Array();
$courseApps = Array();

$count = 0;
$check = $_REQUEST['taken'];
foreach($check as $value)
{
	// Submits course info when given class number as value (referenced from process.php which references ta_application_form)
	$grade_index = 'grade' . $value;
	$term_index = 'term' . $value;
	$year_index = 'year' . $value;
	
	$grade = $_REQUEST[$grade_index];
	$term = $_REQUEST[$term_index];
	$year = $_REQUEST[$year_index];
	
	$coursesTaken[$count]['dept_name'] = $dept_name;
	$coursesTaken[$count]['course_num'] = $value;
	$coursesTaken[$count]['term'] = $term;
	$coursesTaken[$count]['year'] = $year;
	$coursesTaken[$count]['user_id'] = $user_id;
	$coursesTaken[$count]['grade'] = $grade;
	
	$count++;
}

$count = 0;
$check = $_POST['apply'];
foreach($check as $value)
{
	$essay = $_REQUEST['Essay'];
	
	$courseApps[$count]['user_id'] = $user_id;
	$courseApps[$count]['dept_name'] = $dept_name;
	$courseApps[$count]['course_num'] = $value;
	$courseApps[$count]['essay'] = $essay;
	
	$count++;
}

submitAppInfo($user_id, $gpa, $major, $academic_level);
submitCoursesTaken($coursesTaken);
submitCourseApps($courseApps);

?>
  </body>
</html>