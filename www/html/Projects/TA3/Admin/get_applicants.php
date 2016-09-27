<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting all applicants.
Uses the database php file

-->

<?php

session_start();

require "../db.php";

$output = "";

$applicants = Array();

getApplicants($applicants);

$output .= "<table><tr><th>Applicant</th><th>Applied For</th><th>Accepted To</th></tr>";
foreach($applicants as $key => $value)
{
	$output .= "<tr><td>" . $key . "</td><td>";
	foreach($value['applied'] as $class)
	{
		$output .= $class . ", ";
	}
	$output .= "</td><td>";
	foreach($value['assigned'] as $class)
	{
		$output .= $class . ", ";
	}
	$output .= "</td></tr>";
}

$output .= "</table>";

require "applicants.php";

?>