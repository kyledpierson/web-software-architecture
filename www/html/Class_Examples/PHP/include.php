

<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) Notice the use of the include statment
           Note: the use of the stat/end php tags in the simple.php file

        2) Familiarize yourself with the require syntax.

-->

<p> Below is an included file: </p>

<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

// This includes the contents of "simple.php" as if its contents
// had been entered right here.
include("simple2.php");
?>

<p> Even though include did not work, the web page continues </p>

<?php

// This is like an include except that it complains if the file
// doesn't exist.
require("simple2.php");
?>

<p> If require worked, you will see this. </p>