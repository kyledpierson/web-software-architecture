<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting a users requested applications

-->

<?php

require_once "../db.php";
  
session_start();

$classAppsBig = Array();

$user = $_SESSION['user_id'];
getClassApps($user, $classAppsBig);
$output = "";

if(isset($_REQUEST['choose_class']))
{
	$appInfo = Array();
	$classesTaken = Array();
	$classApps = Array();
	getAppInfo($user, $appInfo);
	getClassesTaken($user, $classesTaken);
	
	$class = $_REQUEST['choose_class'];
	$classApps = $classAppsBig[$class];
			
	$output = "<p>Showing applicant information for " . $_SESSION['first_name'] . "</p>";
	$output .= "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Major</th><th>Year</th><th>GPA</th></tr><tr>";
	$output .= "<td>" . $_SESSION['first_name']
			. "</td><td>" . $_SESSION['last_name']
			. "</td><td>" . $_SESSION['email']
			. "</td><td>" . $appInfo['major']
			. "</td><td>" . $appInfo['level']
			. "</td><td>" . $appInfo['gpa'] . "</td><tr></table>";
	
	$output .= "<p>Showing classes taken by " . $_SESSION['first_name'] . "</p>";
	$output .= "<table><tr><th>Department</th><th>Course Number</th><th>Teacher</th><th>Term</th><th>Year</th><th>Grade</th></tr>";
	foreach($classesTaken as $value)
	{
		$output .= "<tr><td>" . $value['dept_name']
				. "</td><td>" . $value['course_num']
				. "</td><td>" . $value['teacher_first'] . " " . $value['teacher_last']
				. "</td><td>" . $value['term']
				. "</td><td>" . $value['year']
				. "</td><td>" . $value['grade'] . "</td></tr>";
	}
	$output .= "</table>";

	$output .= "<p>Showing " . $_SESSION['first_name'] . "'s applications for " . $class . "</p>";
	$output .= "<table><tr><th>Department</th><th>Course Number</th><th>Essay</th></tr><tr>";
	foreach($classApps as $value)
	{
		$output .= "<td>" . $value . "</td>";
	}
	$output .= "</tr></table>";
}

require "app_view.php";

?>
