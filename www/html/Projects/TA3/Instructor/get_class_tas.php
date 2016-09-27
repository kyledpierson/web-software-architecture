<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Gets and displayes everyone who has applied to be a TA for this instructors classes

-->

<?php

session_start();

if(isset($_SESSION['user_id']))
{
	require "../db.php";
	
	$output = "";
	
	$inst_id = $_SESSION['user_id'];
	$ta_info = Array();
	
	getPossibleTAs($inst_id, $ta_info);
	
	foreach($ta_info as $key => $value)
	{
		$output .= "<h2>" . $key . "</h2>";
		$output .= "<table><tr><th>Possible TA</th><th>Essay</th><th>Recommendation</th><th>Assigned</th><th>Add Recommendation</th></tr>";
		foreach($value as $key2 => $value2)
		{
		  $output .= "<tr><td>" . $key2 . "</td><td>" . $value2['essay'] . "</td><td>" . $value2['recommend'] . "</td><td>" . $value2['assign'] . "</td>";
		  if($value2['recommend'] == '')
		  {
			  $output .= "<td><form method=\"POST\"><select name=" . $value['user_id'] . ">"
			  . "<option value=\"\"></option>"
			  . "<option value=\"Not Interested\">Not Interested</option>"
			  . "<option value=\"Possible\">Possible</option>"
			  . "<option value=\"Recommended\">Recommended</option>"
			  . "<option value=\"Desired\">Desired</option>"
			  . "<option value=\"Confirmed\">Confirmed</option></select></form><input type=\"submit\" name=\"SubmitButton\" value=\"Submit\" /></td></tr>";
			  
			  if(isset($_REQUEST[$value['user_id']]) && $_REQUEST[$value['user_id']] != '')
			  {
				  commitRecommends($value['user_id'], $value['course'], $_REQUEST[$value['user_id']]);
			  }
		  }
		}
		$output .= "</table>";
	}
}

require "class_view.php";

?>