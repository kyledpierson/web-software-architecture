<?php

  /**
   * Author: H. James de St. Germain
   * Date: Spring 2015
   *
   *  Sample code for using PHP PDO object
   *
   * Note separation of main PHP from main HTML using output variable
   */

include 'db_config.php';         // contains db connection variables
                                 // separated for security and abstraction purposes

try
{
  //
  // The main content of the page will be in this variable
  //
  $output = "";
  
  //
  // Connect to the data base and select it.
  //
  $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


  //
  // Check to see if a new addition has been requested
  //
  if (isset ( $_GET['first_name'] ))
    {
      $first = $_GET['first_name'];
      $last  = $_GET['last_name'];
      $role  = 'applicant';
      
      $query =     "
       INSERT INTO Users (name_first, name_last, role, login, email)
       VALUES            ('$first', '$last', '$role', '$first', '$first@cs4540.com')
       ";

      $output =
      "<h2> Inserting new row into Users Table of DB</h2>
       <p> This page was called by a form using a GET request </p>
       <p> The query was: </p>
       $query<hr/>";

      $statement = $db->prepare( $query );
      $statement->execute(  );
      
    }
  else
    {
      $output .=  "<h2> Listing All Rows of DB Table: Users</h2>";
    }

  //
  // Build the basic query
  //
  $query =     "
       SELECT * FROM Users 
   ";

  //
  // Prepare and execute the query
  //
  $statement = $db->prepare( $query );
  $statement->execute(  );

  //
  // Fetch all the results
  //
  $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

  //
  // Build the web page for the results
  //
  $output .= "<p>Found: " . count($result) . " records </p>";

  if ( empty( $result ) )
    {
      $output .= "<h2> No Info </h2>";
    }
  else
    {
      $output .= "<ol>";
  
      foreach ($result as $row)
	{
	  $output .=
        "<li>"
        .  "<p>" . $row['name_first'] . ", "
        .  $row['name_last'] . ", "
	.  $row['role']
        ."</p></li>\n";
	}

       $output .=   "</ol>";
    }

}
catch (PDOException $ex)
{
  $output .= "<p>oops</p>";
  $output .= "<p> Code: {$ex->getCode()} </p>";
  $output .=" <p> See: dev.mysql.com/doc/refman/5.0/en/error-messages-server.html#error_er_dup_key";
  $output .= "<pre>$ex</pre>";

  if ($ex->getCode() == 23000)
    {
      $output .= "<h2> Duplicate Entries not allowed </h2>";
    }
}

//
// Below is the HTML content
//

echo <<<END

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
    <meta name="author" content="H. James de St. Germain"/>

    <title> Example of using PDO</title>
  </head>
  
  <body>

    <h1> Welcome to the PDO Example </h1>

    $output

    <hr/>

    <h2> New User Addition </h2>

    <form method="get">
      
      <p>
        <label for="first_name">First Name:</label>
        <input type="text" size=20 id="first_name" name="first_name"/>
      </p>
      <p>
        <label for="last_name">Last Name:</label>
        <input type="text" size=40 id="last_name" name="last_name"/>
      </p>

      <p>
        <input type="submit" value="Add User to DB"/>
      </p>
 </form>


END;

?>
