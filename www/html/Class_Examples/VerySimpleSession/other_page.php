<?php

session_start();

if (isset($_SESSION['user']))
  {
    $user = " " . $_SESSION['user'];
  }
else
  {
    $user = "... WAIT a minute!  You are not Jim!";
  }

echo "<p>welcome$user</p>";
