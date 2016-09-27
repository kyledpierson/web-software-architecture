<!DOCTYPE html>
<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) this code (is very similar to the loop.php code) just shows the foreach loop in a cleaner manner
        2) notice the creation of a table via code.

-->

<html>
  <head>
    <title>Loop Example 2</title>
  </head>
  
  <body>
    
    <?php 
      $headers = getallheaders();
    ?>
    
    <p>Here are all of the incoming headers:</p>
    
    <table border="1">
      
      <?php 
        foreach ($headers as $name => $value)
        {
          echo "<tr><td>$name</td><td>$value</td></tr>";
        }
      ?>
      
    </table>
    
  </body>
</html>