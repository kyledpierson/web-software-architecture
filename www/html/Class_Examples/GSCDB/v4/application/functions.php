<?php

// Echoes a parameter value if it exists
function sticky ($name) {
	if (isset($_REQUEST[$name])) {
		echo $_REQUEST[$name];
	}
}

// Sets up a session and returns the shopping cart
function &getShoppingCart () {
	session_start();
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = Array();
	}
	return $_SESSION['cart'];
}


// Figures out what to display in the quantity field, how many boxes
// have been ordered, and what message to display on the form.
function checkQuantity (&$display, &$order, &$message, $isSubmission) {

	// Set default values
	$display = '';
	$order = 0;
	$message = '';

	if (isset($_REQUEST['quantity'])) {
		$display = $_REQUEST['quantity'];
		if ($isSubmission) {
			$quantity = filter_var(trim($display), FILTER_VALIDATE_INT);
			if (is_bool($quantity)) {
				$message = 'Enter a count';
			}
			else if ($quantity <= 0) {
				$message = 'Enter a positive count';
			}
			else {
				$message = 'Thank you!';
				$order = $quantity;
				$display = '';
			}
		}
	}
}

// Returns a sequence of OPTION tags that can be used to display
// the cookie choices in a pulldown menu. $cookieTypes is an array
// of key/value pairs; $selected is the key of the cookie that should
// be the selected option.
function createCookieOptions ($cookieTypes, $selected) {
	$result = '';
	foreach ($cookieTypes as $key => $name) {
		$selection = ($selected == $key) ? "selected='selected'" : "";
		$result = $result . "<option value='$key' $selection>$name</option>\n";
	}
	return $result;
}


// Returns a table containing the state of a shopping cart.
function createCartTable ($cart, $cookieTypes) {
	$table = "<table border='1' cellspacing = 0 cellpadding='2'>\n";
	$table .= "<tr><th>Variety</th><th>Quantity</th></tr>\n";
	foreach ($cart as $key => $quantity) {
		$table .= "<tr><td>$cookieTypes[$key]</td><td align='right'>$quantity</td></tr>\n";
	}
	return $table . "</table>\n";
}


// Returns the URL of the cookie image to be displayed.
function createCookieImage ($defaultCookie) {
	return "../cookies/$defaultCookie.jpg";
}

?>
