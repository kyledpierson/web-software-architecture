<?php 

// DB
require 'application/db.php';

// Functions
require 'application/functions.php';

// Authentication
require 'application/authentication.php';

// Start session
session_start();

// Authenticate access
verifyLogin('admin');

// Is there a request for shipment?
if (isset($_REQUEST['orderNum'])) {
	shipOrder(trim($_REQUEST['orderNum']));
}

// Get types of cookies
$cookieTypes = getCookieTypes();

// Set up unshipped orders
$orders = &getAllOrders(false);
$unshippedOrders = '';

foreach ($orders as $orderNum => $orderInfo) {
	$name = $orderInfo['name'];
	$unshippedOrders .= "<p>Order Number: $orderNum <br/> Customer Name: $name</p>\n";
    $unshippedOrders .= createCartTable($orderInfo['cart'], $cookieTypes);
	$unshippedOrders .= "</table>\n";
	$unshippedOrders .= "<form><input type='hidden' name='orderNum' value='$orderNum'/>";
	$unshippedOrders .= "<p><input type='submit' value='Ship'/></p>\n";
	$unshippedOrders .= "</form></table><hr/>\n";
}

// Set up shipped orders
$orders = &getAllOrders(true);
$shippedOrders = '';

foreach ($orders as $orderNum => $orderInfo) {
	$name = $orderInfo['name'];
	$date = $orderInfo['date'];
	$shippedOrders .= "<p>Order Number: $orderNum <br/> Customer Name: $name</p>\n";
	$shippedOrders .= createCartTable($orderInfo['cart'], $cookieTypes);
	$shippedOrders .= "</table>\n";
	$shippedOrders .= "<p>Date shipped: $date<p/><hr/>\n";
}

require 'views/manageOrders.php'

?>
