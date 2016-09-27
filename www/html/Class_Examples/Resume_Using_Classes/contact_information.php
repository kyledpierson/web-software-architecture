<?php

/**
 *
 * Author: H. James de St. Germain
 * Date: Spring 2014
 * 
 * This is a resume genereator program.
 * 
 * This is the page that allows the user to type in contact information
 * 
 */

require("Helpers/helper_functions.php");


load_session($resume, $navigation_bar);

$navigation_bar->set_current_page("contact");

$valid_name = "";
$valid_addr = "";
$valid_phone = "";
$saved = "";

if (isset($_REQUEST['save']))
{
  $valid_name  = $resume->person->set_name($_REQUEST['name']);
  $valid_addr  = $resume->person->set_address($_REQUEST['address']);
  $valid_phone = $resume->person->set_phone($_REQUEST['phone']);
  
  $saved = "<p class='saved'>Information Saved!</p>";
}


echo build_html_page_header("Contact Information", ""); 

echo "
<body>
$navigation_bar
		
<h2>Welcome to the resume Generator</h2>
<p> Please enter your name, address, and phone number</p> 

<form method='post'>

<table class='block'>
 <tr>
   <td $valid_name> Name</td>
   <td><input class='contact' type='text' name='name'
         value='{$resume->person->name}'></td>
 </tr>
 <tr>
  <td $valid_addr>Address</td>
  <td><input class='contact' type='text' name='address'
         value='{$resume->person->address}'/></td>
 </tr>
 <tr>
  <td $valid_phone>Phone</td>
  <td><input class='contact' type='text' name='phone'
         value='{$resume->person->phone}'/></td>
 </tr>
</table>

<p>
<input type='submit' name='save' value='Save'/>
$saved
</p>

</form>

</body></html>";

