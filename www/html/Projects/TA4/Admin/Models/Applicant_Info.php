<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting all applicants.
Uses the database php file

-->

<?php

class Applicant_Info
{
	private $applicants;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		require "../Models/db.php";
		$this->applicants = Array();
		getApplicants($this->applicants);
	}

	/**
	 * Returns the string representation of this table
	 */
	public function __toString()
	{
		$output = "<table><tr><th>Applicant</th><th>Applied For</th><th>Accepted To</th></tr>";
		foreach($this->applicants as $key => $value)
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
		
		return $output;
	}
}

?>