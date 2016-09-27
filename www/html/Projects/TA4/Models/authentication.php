<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Returns if the user has permission to visit a site

-->

<?php

// This function will return only if the current user is logged in, using the specified
// role (if $role is nonempty).
function verifyLogin($role)
{
	session_start();
	
	// Perhaps the user is already logged in
	if (isset($_SESSION['role']))
	{
		// Does the user belong to the appropriate role?
		if ($role == $_SESSION['role'])
		{
			return;		// Logged in, right role
		}
		else
		{
			if($_SESSION['role'] == 0)
			  header("Location: http://uofu-cs4540-57.cloudapp.net/Projects/TA4/Applicant/app_home.php");
			else if($_SESSION['role'] == 1)
			  header("Location: http://uofu-cs4540-57.cloudapp.net/Projects/TA4/Instructor/inst_home.php");
			else if($_SESSION['role'] == 2)
			  header("Location: http://uofu-cs4540-57.cloudapp.net/Projects/TA4/Admin/ad_home.php");
			else
			  header("Location: http://uofu-cs4540-57.cloudapp.net/Projects/TA4/ta_index.php");
			exit();
		}
	}
	
	header("Location: http://uofu-cs4540-57.cloudapp.net/Projects/TA4/login.php");
	exit();
}

?>
