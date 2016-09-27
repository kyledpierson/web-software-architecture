<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Used to log out and return to the home page

-->

<?php 

// Log out
session_start();

if (isset($_SESSION['user_id']))
  {
    session_unset();
	session_destroy();
  }
  
$message = "You have successfully logged out";

require 'ta_index.php';

?>
