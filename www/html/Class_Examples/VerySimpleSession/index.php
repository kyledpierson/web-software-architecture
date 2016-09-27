<?php

session_start();

//
// Data about how many time users has come here
//
if (isset($_SESSION['count']))
  {
    $_SESSION['count']++;
  }
else
  {
    $_SESSION['count'] = 1;
  }


//
// Set a default unknown user
//
if (! isset($_SESSION['user']))
  {
    $_SESSION['user'] = "unknown";
  }

//
// If the users was selected from the drop down, save this info
//

if (isset($_REQUEST['mydropdown']))
  {
    echo "<p>got a post request: {$_REQUEST['mydropdown']}</p>";

    $_SESSION['user'] = "User: " . $_REQUEST['mydropdown'];
  }
else
  {
   echo "<p>not from a post</p>";
  }

//
// Verify workings of above
//

echo "<p>count is {$_SESSION['count']}</p>";
echo "<p>user is {$_SESSION['user']}</p>";

?>

<h2> Choose who you are </h2>

<form name="myform" action="" method="POST">
  <div align="center">
    <select name="mydropdown">
      <option value="1">User 1</option>
      <option value="2">User 2</option>
      <option value="3">User 3</option>
    </select>
  </div>

  <input type=submit value="Submit"/>

</form>


  <p><a href="other_page.php">Another page somewhere else in the program </a> </p>

