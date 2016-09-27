<?php

/**
 *
 *  Author: H. James de St. Germain
 *  Date:   Spring 2014
 *
 *  Return something for use by ajax call
 *
 */


session_start();
  
if (isset($_SESSION['count']))
  {
    $_SESSION['count']++;
  }
else
  {
    $_SESSION['count'] = 1;
  }
$count = $_SESSION['count'];
echo
"
  <h1> AJAX has responded! For the $count time</h1>    
";
  
if (isset($_REQUEST['message']))
  {
    $message = $_REQUEST['message'];
      
    echo "<p> $message </p>";
  }
  
if (isset($_REQUEST['show_origination']))
  {
    $orig = $_SERVER['HTTP_REFERER'];
      
    echo "<p> AJAX request came from: $orig </p>";
  }


