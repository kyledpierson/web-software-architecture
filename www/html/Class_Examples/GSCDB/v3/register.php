<?php 

// Get DB functions
require 'application/db.php';

// Helper functions
require 'application/functions.php';

// If this is a submission, process it
$nameError = '';
$loginError = '';
$passwordError = '';

if (isset($_REQUEST['name']) && isset($_REQUEST['password']) && isset($_REQUEST['login'])) {
	
	$name = trim($_REQUEST['name']);
	$login = trim($_REQUEST['login']);
	$password = trim($_REQUEST['password']);
	
	// Register user if name, login, and password are provided
	if ($name != '' && $password != '' && $login != '') {
		$isAdmin = isset($_REQUEST['admin']);
		if (registerNewUser($name, $login, $password, $isAdmin)) {
			require 'views/registered.php';
			return;
		}
		else {
			$loginError = 'That login name is already in use';
			require 'views/register.php';
			return;
		}
	}
	
	// Complain if name is missing
	if ($name == '') {
		$nameError = 'Enter your name';
	}
	
	// Complain if name is missing
	if ($password == '') {
		$passwordError = 'Pick a password';
	}
	
	// Complain if login is missing
	if ($login == '') {
		$loginError = 'Pick a login name';
	}
	
	// Redisplay form
	require 'views/register.php';
	
}

else {
	require 'views/register.php';
}

?>
