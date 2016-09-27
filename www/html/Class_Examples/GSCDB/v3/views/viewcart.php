<!DOCTYPE html>

<html>

<head>
<title>Girl Scout Cookie Shopping Cart</title>
</head>

<body>


<h1>Girl Scout Cookie Shopping Cart</h1>

<h2> Greeting <?php echo ($_SESSION['realname']); ?></h2>

<?php echo $cartContents ?>

<p><a href="order.php">Resume shopping</a></p>

<p><a href="checkout.php">Check out</a></p>

<p><a href="index.html">Home</a></p>

</body>
</html>