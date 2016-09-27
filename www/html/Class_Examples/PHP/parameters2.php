<!DOCTYPE html>
<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) Notice type check before code execution
        2) Notice informative error message to user

-->

<html>
  <head>
    <title>Extracting a Parameter</title>
  </head>
  
  <body>
    
    <?php 
// Converts Fahrenheit to Celsius
$degreesC = '';
if (isset($_REQUEST['temp']) )
  {
    if ( is_numeric($_REQUEST['temp'])) 
      {
        $degreesC = ($_REQUEST['temp'] - 32) * 5.0/9.0;
      }
    else
      {
        echo "<p><em>You must provide a number</em></p>";
      }
  }

    ?>
    
    <form method="get">
      
      <p>
        <label for="temp">Degrees Fahrenheit:</label>
        <input type="text" size=5 id="temp" name="temp"/>
      </p>
      
      <p>
        <label for="answer">Degrees Celsius:</label>
        <input type="text" size=5 name="answer"
               value="<?php echo $degreesC ?>"/>
      </p>
      
      <p>
        <input type="submit" value="Calculate"/>
      </p>
      
    </form>
  </body>
  
</html>