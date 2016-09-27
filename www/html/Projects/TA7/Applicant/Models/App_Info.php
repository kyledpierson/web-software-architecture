<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting a users requested applications

-->

<?php

class App_Info
{
	private $first_name, $last_name, $email, $classAppsBig, $appInfo, $classesTaken, $classApps, $course;
	
	public function __construct($app_id, $f_name, $l_name, $app_email)
	{
		require_once "../Models/db.php";
		
		$this->first_name = $f_name;
		$this->last_name = $l_name;
		$this->email = $app_email;
		
		$this->classAppsBig = Array();
		$this->appInfo = Array();
		$this->classesTaken = Array();
		$this->classApps = Array();
		
		getClassApps($app_id, $this->classAppsBig);
		getAppInfo($app_id, $this->appInfo);
		getClassesTaken($app_id, $this->classesTaken);
	}
	
	public function update_visible_class($new_class)
	{
		$this->classApps = $this->classAppsBig[$new_class];
		$this->course = $new_class;
	}
	
	public function show_class_options()
	{
		$result = "";
		foreach($this->classAppsBig as $key => $value)
		{
			$result .= "<option value=\"" . $key . "\">" . $key . "</option>";
		}
		
		return $result;
	}
	
	public function __toString()
	{
		$output = "<p>Showing applicant information for " . $this->first_name . "</p>";
		$output .= "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Major</th><th>Year</th><th>GPA</th></tr><tr>";
		$output .= "<td>" . $_SESSION['first_name']
				. "</td><td>" . $this->last_name
				. "</td><td id=\"email\">" . $this->email
				. "</td><td>" . $this->appInfo['major']
				. "</td><td>" . $this->appInfo['level']
				. "</td><td>" . $this->appInfo['gpa'] . "</td><tr></table>";
		
		$output .= "<p>Showing classes taken by " . $this->first_name . "</p>";
		$output .= "<table><tr><th>Department</th><th>Course Number</th><th>Teacher</th><th>Term</th><th>Year</th><th>Grade</th></tr>";
		foreach($this->classesTaken as $value)
		{
			$output .= "<tr><td>" . $value['dept_name']
					. "</td><td>" . $value['course_num']
					. "</td><td id=\"teacher\">" . $value['teacher_first'] . " " . $value['teacher_last']
					. "</td><td>" . $value['term']
					. "</td><td>" . $value['year']
					. "</td><td>" . $value['grade'] . "</td></tr>";
		}
		$output .= "</table>";
	
		$output .= "<p>Showing " . $this->first_name . "'s application for " . $this->course . "</p>";
		$output .= "<table><tr><th>Department</th><th>Course Number</th><th>Essay</th><th>Status</th></tr><tr>";
		$num = 1;
		foreach($this->classApps as $value)
		{
			$output .= "<td id=\"element" . $num . "\">" . $value . "</td>";
			$num = $num + 1;
		}
		$output .= "</tr></table>";
		
		return $output;
	}
}

?>
