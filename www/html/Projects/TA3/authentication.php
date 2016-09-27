<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Returns if the user has permission to visit a site

-->

<?php

// This function will return only if the current user is logged in, using the specified
// role (if $role is nonempty).
function verifyLogin ($role)
{
	require_once 'db.php';
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
			require 'Views/badRole.php';		// Logged in, wrong role
			exit();
		}
	}
	
	// Empty error message
	$message = "";

	// User is attempting to log in.  Verify credentials.
	if (isset($_REQUEST['temp_log_email']) && isset($_REQUEST['temp_log_pass']))
	{
		$email = $_REQUEST['log_email'];
		$pass = $_REQUEST['log_pass'];
		try
		{
			$db = openDBConn();
			$stmt = $db->prepare("SELECT user_id, first_name, role FROM Users WHERE email='$email' and user_password='$pass'");
			$stmt->execute();
			
			if ($row = $stmt->fetch())
			{
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['first_name'] = $row['first_name'];
				$_SESSION['last_name'] = $row['last_name'];
				$_SESSION['email'] = $email;
				$_SESSION['role'] = $row['role'];
				$stmt->closeCursor();
			}
			else
			{
				$message = "Incorrect username or password";
				require 'login.php';
				exit();
			}
		}
		catch (PDOException $exception)
		{
			require "Views/error.php";
			exit();
		}
		
		if ($role == $_SESSION['role'])
		{
			return;								// Right role
		}
		else
		{
			require 'Views/badRole.php';		// Wrong role
			exit();
		}
	}
	else
	{
		require 'login.php';
		exit();
	}
}

?>
