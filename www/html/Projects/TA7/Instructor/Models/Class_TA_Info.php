<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Gets and displayes everyone who has applied to be a TA for this instructors classes

-->

<?php

class Class_TA_Info
{
	private $ta_info;
	
	/**
	 * Constructor
	 */
	public function __construct($instructor_id)
	{
		require "../Models/db.php";
		$this->ta_info = Array();
		getPossibleTAs($instructor_id, $this->ta_info);
	}

	/**
	 * Returns the string representation of this table
	 */
	public function __toString()
	{
		$output = "";
		
		foreach($this->ta_info as $key => $value)
		{
			$output .= "<h2>" . $key . "</h2>";
			$output .= "<table><tr><th>Possible TA</th><th>Essay</th><th>Recommendation</th><th>Assigned</th><th>Add Recommendation</th></tr>";
			foreach($value as $key2 => $value2)
			{
		  		$output .= "<tr><td>" . $key2 . "</td><td>" . $value2['essay'] . "</td><td>" . $value2['recommend'] . "</td><td>" . $value2['assign'] . "</td>";
		  		$output .= "<td><form method=\"POST\"><select name=" . $value['user_id'] . ">"
			  	. "<option value=\"\"></option>"
			  	. "<option value=\"Not Interested\">Not Interested</option>"
			  	. "<option value=\"Possible\">Possible</option>"
				. "<option value=\"Recommended\">Recommended</option>"
				. "<option value=\"Desired\">Desired</option>"
			  	. "<option value=\"Confirmed\">Confirmed</option></select></form><input type=\"submit\""
				. "name=\"SubmitButton\" value=\"Submit\" /></td></tr>";
			}
			$output .= "</table>";
		}
		return $output;
	}	
}

?>