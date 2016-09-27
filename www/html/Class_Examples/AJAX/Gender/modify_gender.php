<?php

/**
 *
 *  Author: H. James de St. Germain
 *  Date:   Spring 2014
 *
 *  Send a requiest to the DB to modify a student's gender 
 *
 *     need the following:   uid, gender
 *
 *  Return the word "Modified" if everything goes correctly...
 *
 */
include 'db_config.php';         // contains db connection variables
include 'helper_functions.php';  // contains helpful functions

try
{

  //
  // Connect to the data base and select it.
  //
  $pdo = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  //
  // Pull out data from request
  //
  $uid     = handle_post('uid','');
  $gender  = handle_post('gender', '');

  if ($gender == "Male")
    {
      $gender = 1;
    }
  else if ($gender == "Female")
    {
      $gender = 2;
    }
  else if ($gender == "Unknown")
    {
      $gender = 0;
    }
  else
    {
      die("error in gender value: $gender");
    }

  if ($uid == "")
    {
      die("error in uid: $uid");
    }


  //
  // For the given student change the gender field
  //

  $query = "UPDATE students SET gender=:gender WHERE uid=:uid";
      
  $statement = $pdo->prepare( $query );

  $values = array(':uid'       => $uid,
		          ':gender'    => $gender);
  
  $result = $statement->execute( $values );

  if ($result == 1)
    {
      $return_value = "Modified";
    }
  else
    {
      $return_value = "Didn't work...";
    }
  
}
catch (PDOException $ex)
{
  $return_value = "failure - save gpas to db\n\n" . $return_value;
      $return_value .= "\n<p>Exception:</p>\n";
      $return_value .= "<pre>$ex</pre>\n";
}

echo $return_value;

