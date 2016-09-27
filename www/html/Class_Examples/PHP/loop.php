<!DOCTYPE html>

<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) Notice use of arrays and the getallheaders function
        2) Notice use of foreach key/value pair loop

-->

<html>
  <head>
    <title>Loop Example</title>
  </head>
  
  <body>
    
    <?php 

// Array of all headers that came from browser
// Note that arrays are actually maps
$headers = getallheaders();

// Creating an array with indexes 0, 1, 2, 5, and 6
$myarray = array("a", "b", "c", 5 => "d", "e");

// Adding an index 'joe"
$myarray["joe"] = "zachary";

// Appending "f" with index 7
$myarray[] = "d";

// Ugly display of the array
echo("<p>");
print_r($myarray);
echo("</p>");

// Nicer display of the array
echo("HERE<p>");
foreach ($myarray as $key => &$value)
{
        echo "$key: $value<br/>";
	$myarray[2] = "";
	$myarray[10] = "jim";
	$value = "hello";
}
echo("DONE $myarray[10]</p>");

print_r($myarray);
    ?>

    <p>Here are all of the incoming headers:</p>

    <pre>
      <?php 
foreach ($headers as $name => $value)
{
        echo "$name: $value\n";
}
      ?>

    </pre>
    
  </body>
</html>