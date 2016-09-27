<?php

/**
 * Author:    Joe Zachary
 * Modified:  H. James de St. Germain
 *
 * The following code is the start of a Girl Scout Cookie ordering page:
 *
 * Things to note:
 *
 *   1) Use of views and pages (~= models)
 *   2) Question: is the "Create Shopping Cart Display" code used
 *        in another file?  If so, how would you refactor this?
 */

require ('application/cookies.php');

// Start/resume a session. This must be done before any
// output is generated. Create a cart if necessary.
session_start ();

if (! isset ( $_SESSION ['cart'] ))
{
   $_SESSION ['cart'] = Array ();
}

$shoppingCart = & $_SESSION ['cart'];

// Create shopping cart display
$cartContents = '';
foreach ( $shoppingCart as $variety => $quantity )
{
   $cartContents .= "<tr><td>$cookieTypes[$variety]</td>" . "<td><input type='text' size='10' name='$variety' value='$quantity'</td></tr>\n";
}

// Include the page
require ('views/viewcart.php');
?>
