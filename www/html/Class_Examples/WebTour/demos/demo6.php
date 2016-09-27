<?php

// Start/resume the session
session_start();

// Format the current date
$current = date("l F j Y h:i:s A");

// If a non-empty name was supplied, remember it in the session.
$name = "";
if (isset($_REQUEST["firstName"])) {
	$name = trim($_REQUEST["firstName"]);
	if ($name != "") {
		$_SESSION["firstName"] = $name;
	}
}

// If there's no name, try to retrieve one from the session
if ($name == "" && isset($_SESSION["firstName"])) {
	$name = $_SESSION["firstName"];
}

// Get the welcome message
$welcome = "";
if ($name != "") {
	$welcome = "Welcome $name!";
}

// Get the favorite planet provided by the user
$planet = "";
if (isset($_REQUEST["planet"])) {
	$planet = trim($_REQUEST["planet"]);
}

// If the name was non-empty and no planet was provided, we need
// to look up the planet in the DB.  If the name was non-empty and
// a planet was provided, we need to store the planet in the DB.
if ($name != "") {

	// Configure DB connection
	$DBH = new PDO("mysql:host=atr.eng.utah.edu;dbname=cs4540",
			'cs4540-software', 'hello');
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	// A favorite planet was provided
	if ($planet != "") {

		// Remove any existing record
		$stmt = $DBH->prepare("delete from Planets where Name = ?");
		$stmt->bindValue(1, $name);
		$stmt->execute();

		// Create a new record
		$stmt = $DBH->prepare("insert into Planets (Name,Planet) values(?,?)");
		$stmt->bindValue(1, $name);
		$stmt->bindValue(2, $planet);
		$stmt->execute();
	}

	// A favorite planet was not provided
	else {

		// Extract favorite planet, if one exists
		$stmt = $DBH->prepare("select Planet from Planets where Name = ?");
		$stmt->bindValue(1, $name);
		$stmt->execute();

		// If a favorite planet exists, save it
		if ($row = $stmt->fetch()) {
			$planet = $row['Planet'];
		}
	}
}

// Make the favorite message
$favorite = "";
if ($planet != "") {
	$favorite = "Your favorite planet is $planet!";
}

// Display the page
include "../src/page4.php";
