<?php 

require 'application/functions.php';

// Start session
getShoppingCart();

// Log out
unset($_SESSION['userid']);
unset($_SESSION['realname']);
unset($_SESSION['login']);

?>

<html>

<body>

<p>You have logged out.  What would you like to do now?</p>

<p><a href="order.php">Order cookies</a>

<p><a href="manageOrders.php">Manage orders</a></p>

</body>
</html>
