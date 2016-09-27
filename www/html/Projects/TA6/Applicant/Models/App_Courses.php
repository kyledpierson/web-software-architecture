<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

PHP script for getting all classes.
Uses the database php file

-->

<?php

class App_Courses
{
	public $classes;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		require_once "../Models/db.php";
		
		$this->classes = Array();
		getAppClasses($this->classes);
	}
}