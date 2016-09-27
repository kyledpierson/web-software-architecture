<!DOCTYPE html>
<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) notice use of $_REQUEST (you should experiment with using _GET/_POST
        2) notice use of isset function
        3) notice use of variables and math

-->

<html>
<head>
<title>Extracting a Parameter</title>
</head>

<body>
    
  <?php
  // Converts Fahrenheit to Celsius
  $degreesC = '';
  if (isset ( $_REQUEST ['temp'] ))
  {
   $degreesC = ($_REQUEST ['temp'] - 32) * 5.0 / 9.0;
  }
  ?>

  <form method="get">

    <p>
      <label for="temp">Degrees Fahrenheit:</label> <input type="text" size=5
        id="temp" name="temp" />
    </p>

    <p>
      <label for="answer">Degrees Celsius:</label> <input type="text" size=5
        id="answer" value="<?php echo $degreesC ?>" />
    </p>

    <p>
      <input type="submit" value="Calculate" />
    </p>

  </form>
</body>
</html>