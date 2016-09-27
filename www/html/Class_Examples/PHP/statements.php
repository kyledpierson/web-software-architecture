<!DOCTYPE html>
<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) notice larger blocks of php code
        2) notice use of if statement
        3) notice use rand function
        4) notice use of ? if statement notation
        5) notice use of "broken" php with html in the middle 
        6) notice use of loops

-->

<html>
  <head>
    <title>Statements</title>
  </head>
  
  <body>
    
    <?php 
      
// Define two variables
$name = 'Joe';
$number = rand(0,3);

// In strings delimited with double quotes, variables are replaced
// with their values and escaped characters are respected.
echo "<p>$name: The \trandom number was $number.</p>";

// In strings delimited with single quotes, variables are not
// replaced with their values and escaped characters are dealt
// with verbatim.
echo '<p>$name: The \trandom number was $number.</p>';

// Like a double-quoted string, but ended with a keyword.
echo <<<FOO
  <p>$name:
  The \trandom number was 2.
  </p>
FOO;

// Like a single-quoted string, but ended with a quoted keyword.
echo <<<'END'
  <p>$name:
  The \trandom number was 3.
  </p>
END;
    ?>

    <!-- Conditional examples -->

    <?php 

// Pure conditional
$number = rand(0,1);
if ($number == 0) {
        echo "<p>Hello!  The number was 0.</p>";
}
else {
        echo "<p>Goodbye!  The number was 1.</p>";
}
    ?>

    <?php
// Compute now and plug later
$number = rand(0,1);
$greeting = ($number==0) ? 'Hello' : 'Goodbye';
    ?>

    <p>
      <?php echo $greeting?>!  
      The number was <?php echo $number?>.
    </p>


    <?php 
// Select an HTML block
if (rand(0,1) == 0) {
    ?>
    
    <p>Hello!  The number was 0.</p>
    
    <?php 
}
else {
    ?>
    <p>Goodbye!  The number was 1.</p>
    <?php 
}
    ?>


    <!-- Two examples of for loops -->

    <ol>
      <?php 
for ($i = 0; $i < 10; $i++) {
        echo "<li>Iteration $i</li>";
}
      ?>
    </ol>

    <ul>
      <?php
for ($i = 0; $i < 10; $i++) {
      ?>
      <li>Iteration <?php echo $i?></li>
      <?php 
}
      ?>
    </ul>

  </body>
</html>