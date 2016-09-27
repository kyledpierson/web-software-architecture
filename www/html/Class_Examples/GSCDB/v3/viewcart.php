<?php

require('application/functions.php');
require('application/db.php');

// Start/resume session and get cart
$shoppingCart =& getShoppingCart();

// Get information about cookies
$cookieTypes = getCookieTypes();

// Make cart display
$cartContents = createCartTable($shoppingCart, $cookieTypes);

// Include the page
require('views/viewcart.php');
?>
