<?php 

require("application/db.php");
require("application/functions.php");

// Start/resume session and get shopping cart
$shoppingCart =& getShoppingCart();   

// Get information about cookies
$cookieTypes = getCookieTypes();

if ($_SESSION['login'])
  {
    $welcome_message= "Welcome " . $_SESSION['realname'];
  }
else
  {
    $welcome_message = "Welcome shopper!";
  }

// Figure out which cookie should be displayed in the form.
if (isset($_REQUEST['variety'])) {
	$chosenCookie = $_REQUEST['variety'];
}
else {
  $array =array_keys($cookieTypes);
  $chosenCookie = $array[0];
}

// Determine if this is a real submission.
$isSubmission = isset($_REQUEST['submission']) && $_REQUEST['submission'] == 'yes';

// Initialize the variable that generates the cookie options
$cookieOptions = createCookieOptions($cookieTypes, $chosenCookie);

// Figure out what message related to quantity should be displayed
checkQuantity($quantityDisplay, $quantityOrder, $quantityMessage, $isSubmission);

// Update the cart
if ($quantityOrder > 0) {
	if (isset($shoppingCart[$chosenCookie])) {
		$shoppingCart[$chosenCookie] += $quantityOrder;
	}
	else {
		$shoppingCart[$chosenCookie] = $quantityOrder;
	}
}

// Pick the image to be displayed
$cookieImage = createCookieImage($chosenCookie);

// Include the page
require("views/order.php");

?>
