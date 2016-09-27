<!DOCTYPE html>
<html>

<head>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script>

$(function () {

	// Set the state of the submit button when page is loaded
	checkQuantity();

	// When the menu is changed, submit the form
	$('select').change(function () {$('form').submit();});

	// When a key is typed in the quantity box, set the state of
	// the submit button
    $('input[name=quantity]').keyup(checkQuantity);

    // When the submit button is clicked, set the hidden field
	$('input[type=submit]').click(
		function () {$('input[name=submission]').val('yes');});
});

// Disables the submit button depending on quantity in box
function checkQuantity () {
	var value = $('input[name=quantity]').val();
	if (/^\d+$/.test(value) && parseInt(value)>0) {
		$('input[type=submit]').removeAttr("disabled");
	}
	else {
		$('input[type=submit]').attr("disabled", "disabled");
	}	
}
</script>

<title>Girl Scout Cookie Order Form</title>
</head>

<body>

<h2>Girl Scout Cookie Order Form</h2>

<p>Please use the form below to add boxes of cookies to your shopping cart.
Thank you!</p>

<!-- This form has no action, so it is submitted to the page on which it appears. -->
<form method="get">

<!-- Hidden field to identify real submissions -->
<input type="hidden" name="submission" value="no"/>

<table>

 <tr>
  <td>Variety</td>
  <td>Quantity</td>
 </tr>

 <tr>
  <td>
   <select name="variety">
    <?php echo $cookieOptions ?>
   </select>
  </td>

  <td><input type="text" name="quantity" 
             value="<?php echo $quantityDisplay ?>" /></td>

  <td><input type="submit" value="Add to Cart"/></td>
  
  <td style="color:red"><?php echo $quantityMessage ?></td>
 </tr>
 
</table>

<!-- This is where cookie images are placed. -->
<p><img src="<?php echo $cookieImage ?>"/></p>

<!-- Displays contents of shopping cart -->
<p><a href="viewcart.php">View Shopping Cart</a></p>

</form>
</body>

</html>
