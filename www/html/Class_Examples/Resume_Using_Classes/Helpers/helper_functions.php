<?php

require("Models/resume.php");
require("Models/navigation_bar.php");


/**
 * 
 * Author: H. James de St. Germain
 * Date: Spring 2014
 * 
 * These functions are used by the resume program to make life easier....
 * 
 * 
 */

// Return the value of the parameter $param if it exists.
// Otherwise, return $default.
function getParam ($param, $default)
{
	return (isset($_REQUEST[$param])) ? $_REQUEST[$param] : $default;
}



/**
 * 
 * start the session and load the appropraite variables
 * (as references to the data stored in the session)
 */

function load_session(&$resume, &$navigation_bar)
{
	session_start();
	
	if (! isset($_SESSION['resume']) )
	{
		$_SESSION['resume']         = new Resume();
		$_SESSION['navigation_bar'] = new Navigation_Bar();
	}

	$resume         =  $_SESSION['resume'];
	$navigation_bar =  $_SESSION['navigation_bar'];
	
}


/**
 * Build the common HTML header, including CSS links!
 */
function build_html_page_header( $title, $other )
{
 return "
 	   <!doctype html>
 	   <html>
 		 <head>
 		 	<title> $title </title>
            <link href='CSS/resume.css' rel='stylesheet' type='text/css'/>
 		    $other
         </head>
 		";
}



 