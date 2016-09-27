<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting all classes.
Uses the database php file

-->

<?php

session_start();

require "../db.php";

$output = "";

$classes = Array();

getClasses($classes);

$output .= "<table><tr><th>Class</th><th>Instructor</th><th>Credits</th><th>Details</th><th>Applied</th><th>Assigned</th></tr>";
foreach($classes as $key => $value)
{
	$output .= "<tr><td>" . $key . "</td><td>" . $value['teacher'] . "</td><td>" . $value['credits'] . "</td><td>" . $value['details'] . "</td>";
	
	$output .= "<td>";
	
	foreach($value['applied'] as $key)
	{
		$output .= $key . ", ";
	}
	$output .= "</td><td>";
	foreach($value['assign'] as $key)
	{
		$output .= $key . ", ";
	}
	$output .= "</td></tr>";
}

$output .= "</table>";

require "classes.php";

?>