<!DOCTYPE html>

<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) here we take the value out of the associative array
           and place it in a variable for more convenient use.
        2) notice how we not only send the answer back but
           also the original value

-->


<html>
  <head>
    <title>Extracting a Parameter</title>
  </head>
  
  <body>
    
    <?php 
$inputF = '';
$degreesC = '';
if (isset($_REQUEST['temp'])) {
        $inputF = $_REQUEST['temp'];
        if (is_numeric($inputF)) {
                $degreesC = ($inputF - 32) * 5.0/9.0;
        }
}
    ?>

    <form method="get">
      
      <p>
        <label for="temp">Degrees Fahrenheit:</label>
        <input type="text" size=5 id="temp" name="temp"
               value="<?php echo $inputF ?>"/>
      </p>
      
      <p>
        <label for="answer">Degrees Celsius:</label>
        <input type="text" size=5 id="answer" 
               value="<?php echo $degreesC ?>"/>
      </p>
      
      <p>
        <input type="submit" value="Calculate"/>
      </p>
      
    </form>
  </body>

</html>

