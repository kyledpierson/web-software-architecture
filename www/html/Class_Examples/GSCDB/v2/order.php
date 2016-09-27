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


require ("application/db.php");

// Start/resume a session. This must be done before any
// output is generated. Create a cart if necessary.
session_start ();
if (! isset ( $_SESSION ['cart'] ))
{
   $_SESSION ['cart'] = Array ();
}

// Without the =&, we would be copying the array
$shoppingCart = & $_SESSION ['cart'];

// Contains information about cookies
$cookieTypes = getCookieTypes ();

// Figure out which cookie should be displayed in the form.
if (isset ( $_REQUEST ['variety'] ))
{
   $chosenCookie = $_REQUEST ['variety'];
}
else
{
  $array = array_keys($cookieTypes);
  $chosenCookie = $array[0];
}

// Determine if this is a real submission.
$isSubmission = isset ( $_REQUEST ['submission'] ) && $_REQUEST ['submission'] == 'yes';

// Initialize the variable that generates the cookie options
$cookieOptions = createCookieOptions ( $cookieTypes, $chosenCookie );

// Figure out what message related to quantity should be displayed
checkQuantity ( $quantityDisplay, $quantityOrder, $quantityMessage, $isSubmission );

// Update the cart
if ($quantityOrder > 0)
{
   if (isset ( $shoppingCart [$chosenCookie] ))
   {
      $shoppingCart [$chosenCookie] += $quantityOrder;
   }
   else
   {
      $shoppingCart [$chosenCookie] = $quantityOrder;
   }
}

// Pick the image to be displayed
$cookieImage = createCookieImage ( $chosenCookie );

// Include the page
require ("views/order.php");

// Figures out what to display in the quantity field, how many boxes
// have been ordered, and what message to display on the form.
function checkQuantity(&$display, &$order, &$message, $isSubmission)
{
   
   // Set default values
   $display = '';
   $order = 0;
   $message = '';
   
   if (isset ( $_REQUEST ['quantity'] ))
   {
      $display = $_REQUEST ['quantity'];
      if ($isSubmission)
      {
         $quantity = filter_var ( trim ( $display ), FILTER_VALIDATE_INT );
         if (is_bool ( $quantity ))
         {
            $message = 'Enter a count';
         }
         else if ($quantity <= 0)
         {
            $message = 'Enter a positive count';
         }
         else
         {
            $message = 'Thank you!';
            $order = $quantity;
            $display = '';
         }
      }
   }
}

// Returns a sequence of OPTION tags that can be used to display
// the cookie choices in a pulldown menu. $cookieTypes is an array
// of key/value pairs; $selected is the key of the cookie that should
// be the selected option.
function createCookieOptions($cookieTypes, $selected)
{
   $result = '';
   foreach ( $cookieTypes as $key => $name )
   {
      $selection = ($selected == $key) ? "selected='selected'" : "";
      $result = $result . "<option value='$key' $selection>$name</option>\n";
   }
   return $result;
}

// Returns the URL of the cookie image to be displayed.
function createCookieImage($defaultCookie)
{
   return "../cookies/$defaultCookie.jpg";
}

?>
