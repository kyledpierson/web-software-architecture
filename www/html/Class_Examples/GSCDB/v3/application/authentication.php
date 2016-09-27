<?php

// This function will return only if the current user is logged in, using the specified
// role (if $role is nonempty).

function verifyLogin ($role) {
	
	// Perhaps the user is already logged in
	if (isset($_SESSION['userid'])) {
		
		// Does the user belong to the appropriate role?
		if ($role == '' || (isset($_SESSION['roles']) && in_array($role, $_SESSION['roles']))) {
			return $_SESSION['realname'];            // Logged in, right role
		}
		else {
			require 'views/badRole.php';       // Logged in, wrong role
			exit();
		}
		
	}
	
	// Empty error message
	$message = "";

	// User is attempting to log in.  Verify credentials.
	if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		try {
			$DBH = openDBConnection();
			$stmt = $DBH->prepare("select UserID, RealName from Users where Login='$username' and PW='$password'");
			$stmt->execute();
			if ($row = $stmt->fetch()) {
				$_SESSION['userid'] = $row['UserID'];
				$_SESSION['realname'] = $row['RealName'];
				$_SESSION['login'] = $username;
				$stmt->closeCursor();
				$stmt = $DBH->prepare("select Role from Roles where Login = ?");
				$stmt->bindValue(1, $username);
				$stmt->execute();
				$roles = array();
				while ($row = $stmt->fetch()) {
					$roles[] = $row['Role'];
				}
				$_SESSION['roles'] = $roles;
			}
			else {
				$message = "Username or password was wrong";
				require "application/login.php";
				exit();
			}
		}
		catch (PDOException $exception) {
			require "views/error.php";
			exit();
		}
		
		if ($role == '' || in_array($role, $_SESSION['roles'])) {
			return;                                  // Right role
		}
		else {
			require 'views/badRole.php';       // Wrong role
			exit();
		}
	}
	else {
		require 'application/login.php';
		exit();
	}

}

?>