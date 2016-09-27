<?php 

require('application/db.php');
require('application/authentication.php');
require('application/functions.php');

// Start/resume session and get shopping cart.
$shoppingCart =& getShoppingCart();

// Make sure the user is logged in
verifyLogin('user');

// Place the order
placeOrder($_SESSION['userid'], $shoppingCart);

// Reset the cart
unset($_SESSION['cart']);

// Display an acknowledgement
require 'views/checkedout.php';

?>
