<?php 

require 'application/functions.php';

// Log out
session_start();

if (isset($_SESSION['userid']))
  {
    echo "<h2>Goodbye {$_SESSION['realname']}</h2><hr/>";

    unset($_SESSION['userid']);
    unset($_SESSION['realname']);
    unset($_SESSION['login']);

    echo"<p>You have logged out.  What would you like to do now?</p>";

  }
else
  {
    echo "<h2>To die one must first live, to logout ...</h2><hr/>";
  }

?>

<html>

<body>


<p><a href="order.php">Order cookies</a>

<p><a href="manageOrders.php">Manage orders</a></p>

</body>
</html>
