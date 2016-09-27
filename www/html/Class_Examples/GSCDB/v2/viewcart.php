<?php 

require('application/cookies.php');

// Start/resume a session.  This must be done before any
// output is generated.  Create a cart if necessary.
session_start();
if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = Array();
}
$shoppingCart =& $_SESSION['cart'];

// Create shopping cart display
$cartContents = '';
foreach ($shoppingCart as $variety => $quantity) {
	$cartContents .= 
		"<tr><td>$cookieTypes[$variety]</td>" .
		"<td><input type='text' size='10' name='$variety' value='$quantity'</td></tr>\n";
}

// Include the page
require('views/viewcart.php');
?>
