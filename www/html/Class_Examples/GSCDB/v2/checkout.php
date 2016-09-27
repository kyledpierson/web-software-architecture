<?php

/**
 * Author:    Joe Zachary
 * Modified:  H. James de St. Germain
 *
 * GSC13 - Version 2
 *
 * The following code is the next state of evolution for the GSC page
 *
 * Things to note:
 *
 */
require ('application/db.php');

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
$loginNameError = '';
if (isset ( $_REQUEST ['loginName'] ))
{
   
   $loginName = trim ( $_REQUEST ['loginName'] );
   
   // If empty, complain.
   if ($loginName == '')
   {
      $loginNameError = 'Enter your login name';
   }
   // Otherwise, try to place the order
   else
   {
      // Get user's name
      $realName = getRealName ( $loginName );
      if ($realName == NULL)
      {
         $loginNameError = 'Invalid login name';
      }
      else
      {
         // Place the order
         placeOrder ( $loginName, $shoppingCart );
         
         // End the session
         session_destroy ();
         
         // Display an acknowledgment
         require 'views/checkedout.php';
         return;
      }
   }
}

// Create shopping cart display
$cookieTypes = getCookieTypes ();
$cartContents = '';
foreach ( $shoppingCart as $variety => $quantity )
{
   $cartContents .= "<tr><td>$cookieTypes[$variety]</td>" . "<td><input type='text' size='10' name='$variety' readonly='readonly' value='$quantity'</td></tr>\n";
}

// Include the page
require ('views/checkout.php');

?>
