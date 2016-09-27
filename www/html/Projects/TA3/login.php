<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The model component of logging in

-->

<?php

require_once 'db.php';
require_once 'password.php';

session_start();
// Perhaps the user is already logged in
if (isset($_SESSION['role']))
{
	// Does the user belong to the appropriate role?
	require 'ta_index.php';
	exit();
}

// Empty error message
$message = "";

// User is attempting to log in.  Verify credentials.
if (isset($_REQUEST['log_email']) && isset($_REQUEST['log_pass']))
{
	$email = $_REQUEST['log_email'];
	$pass = $_REQUEST['log_pass'];
	
	try
	{
		$db = openDBConn();
		$db->beginTransaction();
		
		$stmt = $db->prepare("SELECT user_id, first_name, last_name, role, user_password FROM Users WHERE email = ?");
		$stmt->bindValue(1, $email);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$password = $result['user_password'];
		
		// Hashing the password with its hash as the salt returns the same hash
		if(password_verify($pass, $password) || $pass == $password)
		{
			$_SESSION['user_id'] = $result['user_id'];
			$_SESSION['first_name'] = $result['first_name'];
			$_SESSION['last_name'] = $result['last_name'];
			$_SESSION['email'] = $email;
			$_SESSION['role'] = $result['role'];
			$stmt->closeCursor();
		}
		else
		{
			$message = "Incorrect username or password <br>";
			require 'login_view.php';
			exit();
		}
	}
	catch (PDOException $exception)
	{
		require "Views/error.php";
		exit();
	}
	
	require 'ta_index.php';
	exit();
}
else
{
	require 'login_view.php';
	exit();
}
    
?>