<!doctype html>

<html>

<head>
<title>Checkout</title>
</head>
<body>

<h2>Checkout</h2>

<p>Here is your order: 

<table border=1>
<tr><th>Variety</th><th>Quantity</th></tr>
<?php echo $cartContents ?>
</table>

<p>Please enter your login name and you will be billed.
Thanks for the order.</p>

<form method="get" action="checkout.php">
<label for="userid">UserID</label>
<input type="text" size="10" id="loginName" name="loginName"/>
<input type="submit" value="Place Order"/>
<span style="color:red"><?php echo $loginNameError ?></span>
</form>

<p><a href="order.php">Resume shopping</a></p>

</body>
</html>