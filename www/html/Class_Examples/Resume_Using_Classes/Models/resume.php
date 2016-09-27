<?php

require("person.php");
require("history.php");

/**
 *
 * Author: H. James de St. Germain
 * Date: Spring 2014
 *
 * This class represents a resume.
 * 
 * Things of Note:
 * 
 *    1) to access a property, use $this->property_name   (NOT $this->$property_name)
 *       WARNING: failure to use $this-> (such as just $person) will result in a new temporary variable, which is probably not what you want
 *    2) 
 *
 */

class Resume
{
	
	public $person;
	public $jobs;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->person = new Person;
		$this->jobs   = new History;
	}
	
	
	/**
	 * Print the HTML of the resume
	 *
	 * @return string
	 */
	
	public function __toString()
	{
		$output =
		 "
		  <div id='resume'>
		    <h1>resume</h1>
		    <p>Name:     {$this->person->name} </p>
		    <p>Address:  {$this->person->address} </p>
		    <p>Phone:    {$this->person->phone} </p>";
		
		$output .= $this->jobs;
		
		
		$output .=
		"
	      </div>
 	     ";
		
		return $output;
		
	}
	
	/**
	 *  return true if the requested data is valid
	 *
	 */
	function validate()
	{
		return "";
	}
	
	
	
}