<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting all applicants.
Uses the database php file

-->

<?php

class TA_Eval_Info
{
	private $evaluations;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		require "../Models/db.php";
		$this->evaluations = Array();
		getEvaluations($this->evaluations);
	}

	/**
	 * Returns the string representation of this table
	 */
	public function __toString()
	{
		$output = "<table id=\"sorted_table\" class=\"tablesorter\"><thead>"
		. "<tr><th>TA</th><th>Course</th><th>Term</th><th>Performace</th><th>Communication</th><th>Comments</th></tr>"
		. "</thead><tbody>";
		
		foreach($this->evaluations as $key => $value)
		{
			$output .= "<tr><td>" . $value['ta'] . "</td>";
			$output .= "<td>" . $value['class'] . "</td>";
			$output .= "<td>" . $value['term'] . "</td>";
			$output .= "<td>" . $value['performance'] . "</td>";
			$output .= "<td>" . $value['communication'] . "</td>";
			$output .= "<td><div id='" . $key . "'><button id='" . $key . "'onclick='return get_comments(" . $key . ")'>Show Comments</button></div></td></tr>";
		}
		
		$output .= "</tbody></table>";
		
		return $output;
	}
}

?>