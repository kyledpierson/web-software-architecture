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
 *   2) User ID check
 *      - In the future, we will save the checkout info to the DB
 *   3) Upon checkout, we destroy the session
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

// If a userid was submitted, validate it and either display
// an error message or place the order.
$useridError = '';
if (isset ( $_REQUEST ['userid'] ))
{
   
   $userid = trim ( $_REQUEST ['userid'] );
   
   // If empty, complain.
   if ($userid == '')
   {
      $useridError = 'Enter your unique UserID';
   }
   // Otherwise, place the order
   else
   {
      // Place the order
      // NOTHING TO DO YET
      
      // End the session
      session_destroy ();
      
      // Display an acknowledgment
      require 'views/checkedout.php';
      return;
   }
}

// Create shopping cart display
$cartContents = '';
foreach ( $shoppingCart as $variety => $quantity )
{
   $cartContents .= "<tr><td>$cookieTypes[$variety]</td>" . "<td><input type='text' size='10' name='$variety' readonly='readonly' value='$quantity'</td></tr>\n";
}

// Include the page
require ('views/checkout.php');

?>
