<!DOCTYPE html>
<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) see use of inline php
        2) see use of echo function
        3) see use date function
        4) see use of $_SERVER variable
        5) see use of var_dump and print_r

-->

<html>
  <head>
    <style>
      .red {color:red;}
    </style>
    <title>Some Straightline Examples</title>
  </head>
  
  <body>
    
    <p class="red">
      The current date and time is:
    </p>
    
    <p> 
      <!-- echo is used to insert text into the output stream -->
      <?php echo date("D M G Y h:i:s A") ?>
    </p>
    
    <p class="red">
      This page was requested from: 
    </p>
    
    <p>
      <!-- $_SERVER is a predefined array (more like a hash map, really)
	   that contains information about the request that triggered
	   the execution of this file. -->
      <?php echo $_SERVER["REMOTE_ADDR"]?>
    </p>
    
    <p class="red">
      This page requested via: 
    </p>
    <p>
      <!-- Another piece of information about the request -->
      <?php echo $_SERVER["SERVER_PROTOCOL"]?>
    </p>
    
    <p class="red">
      Information about the server and the current request
    </p>
	
    <p>
      <!-- Prints a variable in human readable form -->
      <?php print_r($_SERVER); ?>
    </p>

    <p class="red">
      Same as above with more detail.
    </p>
	
    <p>
      <!-- Similar to above but also displays type information,
	   typically for deugging purposes. -->
      <?php var_dump($_SERVER); ?>
    </p>

  </body>
</html>