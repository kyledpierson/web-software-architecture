<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The model component of registering

-->

<?php 

// Get DB functions
require 'Models/db.php';
require_once 'Models/password.php';

// If this is a submission, process it
$registered = '';
$firstNameError = '';
$lastNameError = '';
$loginError = '';
$passwordError = '';

if(isset($_REQUEST['first']) && isset($_REQUEST['last']) && isset($_REQUEST['email']) && isset($_REQUEST['pass']))
{
	$first = htmlspecialchars(trim($_REQUEST['first']));
	$last = htmlspecialchars(trim($_REQUEST['last']));
	$email = htmlspecialchars(trim($_REQUEST['email']));
	$pass = htmlspecialchars(trim($_REQUEST['pass']));
	
	// Register user if name, login, and password are provided
	if ($first != '' && $last != '' && $email != '' && $pass != '')
	{
		$hash = password_hash($pass, PASSWORD_BCRYPT);
		
		if(submitUser($first, $last, $email, $hash, 0))
		{
			$message = 'You have been successfully registered';
			require 'ta_index.php';
			return;
		}
		else
		{
			$loginError = 'That login name is already in use';
			require'register_view.php';
			return;
		}
	}
	
	// Complain if first name is missing
	if ($first == '')
	{
		$firstNameError = 'Enter your first name';
	}
	
	// Complain if last name is missing
	if ($last == '')
	{
		$lastNameError = 'Enter your last name';
	}
	
	// Complain if login is missing
	if ($email == '')
	{
		$loginError = 'Enter your email to use for logging in';
	}
	
	// Complain if password is missing
	if ($pass == '')
	{
		$passwordError = 'Pick a password';
	}
	
	// Re-display form
	require 'register_view.php';
}

else
{
	require 'register_view.php';
}

?>