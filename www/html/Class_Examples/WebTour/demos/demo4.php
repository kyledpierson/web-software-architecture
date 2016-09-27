<?php

// Format the current date
$current = date("l F j Y h:i:s A");

// Get the name and welcome message
$name = "";
$welcome = "";
if (isset($_REQUEST["firstName"])) {
	$name = trim($_REQUEST["firstName"]);
	if ($name != "") {
		$welcome = "Welcome $name!";
	}
}

// Get the favorite planet message
$favorite = "";
if (isset($_REQUEST["planet"])) {
	$planet = trim($_REQUEST["planet"]);
	if ($planet != "") {
		$favorite = "Your favorite planet is $planet!";
	}
}

// Display the page
include "../src/page4.php";

?>
