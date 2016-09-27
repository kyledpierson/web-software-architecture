<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting all classes.
Uses the database php file

-->

<?php

require_once "../Models/db.php";

session_start();
if(!isset($_SESSION['class_info']))
{
	$output = new Class_Info();
	$_SESSION['class_info'] = $output;
}
else
	$output = $_SESSION['class_info'];

if(isset($_REQUEST['submit']))
{
	$output->submit($_REQUEST['term'], $_REQUEST['year']);
}
else if(isset($_REQUEST['fetch']))
{
	$output->fetch();
}
else if(isset($_REQUEST['reset']))
{
	$output->reset_enroll();
}
else
{
	$output->default_vals();
}

class Class_Info
{
	private $classes;
	private $term;
	private $year;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->default_vals();
	}
	
	public function default_vals()
	{
		$this->term = 'Fall';
		$this->year = '2015';
		$this->classes = Array();
		getClasses($this->term, $this->year, $this->classes);
	}
	
	public function get_term()
	{
		return $this->term;
	}
	
	public function get_year()
	{
		return $this->year;
	}
	
	public function submit($sel_term, $sel_year)
	{
		require_once "../Models/db.php";
		
		$this->term = $sel_term;
		$this->year = $sel_year;
		$this->classes = Array();
		getClasses($sel_term, $sel_year, $this->classes);
	}
	
	public function fetch()
	{
		require_once "../Models/db.php";
		
		$this->classes = Array();
		$bad_courses = Array();
		
		if($this->term == 'Spring')
			$temp_term = 4;
		if($this->term == 'Summer')
			$temp_term = 6;
		if($this->term == 'Fall')
			$temp_term = 8;
			
		$temp_year = substr($this->year, 2);
		
		$fp = fsockopen("www.acs.utah.edu", 80, $errno, $errstr, 5);
		$out = "GET /uofu/stu/scheduling?term=1" . $temp_year . $temp_term . "&dept=CS&classtype=g HTTP/1.1\r\n";
		$out .= "Host: www.acs.utah.edu\r\n";
		$out .= "Connection: Close\r\n\r\n";
		
		fwrite($fp, $out);
		if ($fp)
  		{
			$page = "";
			while (!feof($fp))
			{
				$page .= fgets($fp, 1000);
			}
			$nbsp = utf8_decode('Ã¡');
			$page = str_replace($nbsp, '', $page);
			$page = str_replace("\xc2\xa0",'',$page);
			$page = str_replace('&nbsp;', '', $page);
			fclose($fp);
			
			$doc = new DOMDocument();
			$doc->loadHTML($page);
			
			$table = $doc->getElementsByTagName('table');
			$rows = $table->item(4)->getElementsByTagName('tr');
			
			foreach ($rows as $row)
			{
				$cells = $row->getElementsByTagName('td');
				
				$type = utf8_encode(trim(htmlspecialchars($cells->item(4)->nodeValue)));
				if($type == '001' || $type == '090')
				{
					$dept_name = utf8_encode(trim(htmlspecialchars($cells->item(2)->nodeValue)));			
					$course_num = utf8_encode(trim(htmlspecialchars($cells->item(3)->nodeValue)));
					$class_key = $dept_name . ' ' . $course_num;
					
					$teacher = utf8_encode(trim(htmlspecialchars($cells->item(12)->nodeValue)));
					$credits = utf8_encode(trim(htmlspecialchars($cells->item(6)->nodeValue)));
					$course_details = utf8_encode(trim(htmlspecialchars($cells->item(7)->nodeValue)));
					
					$days = utf8_encode(trim(htmlspecialchars($cells->item(8)->nodeValue)));
					$time = utf8_encode(trim(htmlspecialchars($cells->item(9)->nodeValue)));
					$location = utf8_encode(trim(htmlspecialchars($cells->item(10)->nodeValue)));
					
					if(strpos($teacher, ',') !== FALSE)
					{
						$this->classes[$class_key]['dept_name'] = $dept_name;
						$this->classes[$class_key]['course_num'] = $course_num;
						$this->classes[$class_key]['credits'] = $credits;
						$this->classes[$class_key]['details'] = $course_details;
						$this->classes[$class_key]['days'] = $days;
						$this->classes[$class_key]['time'] = $time;
						$this->classes[$class_key]['location'] = $location;
						$this->classes[$class_key]['first_name'] = utf8_encode(trim(substr($teacher, strrpos($teacher, ',') + 2)));
						$this->classes[$class_key]['last_name'] = utf8_encode(trim(substr($teacher, 0, strrpos($teacher, ','))));
						$this->classes[$class_key]['teacher'] = utf8_encode(trim($this->classes[$class_key]['first_name'] . ' ' . $this->classes[$class_key]['last_name']));
					}
					else
					{
						array_push($bad_courses, $class_key);
					}
				}
			}
		}
		
		$fp = fsockopen("www.acs.utah.edu", 80, $errno, $errstr, 5);
		$out = "GET /uofu/stu/scheduling/crse-info?term=1" . $temp_year . $temp_term . "&subj=CS HTTP/1.1\r\n";
		$out .= "Host: www.acs.utah.edu\r\n";
		$out .= "Connection: Close\r\n\r\n";
		
		fwrite($fp, $out);
		if ($fp)
  		{
			$page = "";
			while (!feof($fp))
			{
				$page .= fgets($fp, 1000);
			}
			$nbsp = utf8_decode('Ã¡');
			$page = str_replace($nbsp, '', $page);
			$page = str_replace("\xc2\xa0",'',$page);
			$page = str_replace('&nbsp;', '', $page);
			fclose($fp);
			
			$doc = new DOMDocument();
			$doc->loadHTML($page);
			
			$table = $doc->getElementsByTagName('table');
			$rows = $table->item(0)->getElementsByTagName('tr');
			
			foreach ($rows as $row)
			{
				$cells = $row->getElementsByTagName('td');
				
				$type = utf8_encode(trim(htmlspecialchars($cells->item(3)->nodeValue)));
				if($type == '001' || $type == '090')
				{
					$dept_name = utf8_encode(trim(htmlspecialchars($cells->item(1)->nodeValue)));			
					$course_num = utf8_encode(trim(htmlspecialchars($cells->item(2)->nodeValue)));
					$class_key = $dept_name . ' ' . $course_num;
					
					if(!in_array($class_key, $bad_courses))
					{
						$enroll = utf8_encode(trim(htmlspecialchars($cells->item(6)->nodeValue)));
						$this->classes[$class_key]['enroll'] = $enroll;
					}
				}
			}
		}
		
		submitCourses($this->year, $this->term, $this->classes);
	}
	
	public function reset_enroll($year, $term)
	{
		require_once "../Models/db.php";
		
		$this->classes = Array();
		resetEnroll($this->year, $this->term);
		getClasses($this->term, $this->year, $this->classes);
	}

	/**
	 * Returns the string representation of this table
	 */
	public function __toString()
	{
		$bool = 0;
		
		$output = "<h2>Showing classes for " . $this->term . " of " . $this->year . "</h2>";
		$output .= "<input type=\"button\" id=\"show_col\" value=\"Hide Title\">";
		$output .= "<table style=\"font-size:14px\"><tr><th></th><th class=\"c_title\">Class</th><th>Instructor</th><th>Credits</th><th>Details</th><th>Enrollments</th><th>Assigned</th></tr>";
		foreach($this->classes as $key => $value)
		{
			$bool = 1;
			$output .= "<tr><td><img src=\"../Images/icon_small_plus.gif\" class=\"expand\"/></td><td class=\"c_title\">" . $key . "</td><td>" . $value['teacher'] . "</td><td>" . $value['credits']
				. "</td><td>" . $value['details'] . "</td><td>" . $value['enroll'] . "</td>";
			
			$output .= "<td>";
			foreach($value['assign'] as $key)
			{
				$output .= $key . ", ";
			}
			$output .= "</td></tr>";
			
			$output .= "<tr style=\"display:none\"><td colspan=100% style=\"border:none; padding-left:5em\">Days:&nbsp;" . $value['days'] . "&nbsp;&nbsp;&nbsp;&nbsp;Time:&nbsp;" . $value['time'] . "&nbsp;&nbsp;&nbsp;&nbsp;Location:&nbsp;" . $value['location'] . "</td></tr>";
		}
		if($bool == 1)
			$output .= "</table>";
		else
			$output = "<h2>Showing classes for " . $this->term . " of " . $this->year . "</h2><p>None</p>";
		
		return $output;
	}
}

?>