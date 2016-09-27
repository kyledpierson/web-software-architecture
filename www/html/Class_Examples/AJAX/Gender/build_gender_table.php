<?php

  /**
   * Author: H. James de St. Germain
   * Date: Spring 2014
   *
   *  Print a table of students and genders followed
   *  by a list of all students without a known gender
   *  
   *  Additionally, allow, via AJAX, the ability to modify
   *  the entries
   *
   */


include 'db_config.php';         // contains db connection variables
require 'helper_functions.php';  // contains helpful functions


try
{

  $return_all          =  handle_post( 'return_all', 'nope' );
  $allow_modification  =  handle_post( 'modify',     'nope' ) == 'true' ? true : false;

  //
  // Connect to the data base and select it.
  //
  $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  if ( $return_all != "All") 
    {
      $where = " WHERE gender=0 ORDER BY name";
    }
  else
    {
      $where = " ORDER BY gender DESC, name";
    }
		
  $query =     "
       SELECT * FROM students
       $where
       ";

  $statement = $db->prepare( $query );
  $statement->execute(  );
  $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

  echo "<p>Found: " . count($result) . " records </p>";

  if ( empty( $result ) )
    {
      echo "<h2> All students have a gender value </h2>";
      return;
    }

  if  ($allow_modification)
    {
      $modify_header = "<th>Assign Gender</th>";
      echo "<h2> Warning: modifications are immediately saved! </h2>";
    }
  else
    {
      $modify_inputs = "";
      $modify_header = "";
    }

  echo "

<table border='1'> 
  <thead>          
    <tr>
       <th> U Id</th>
       <th> Name</th>
       <th> Gender</th>
       $modify_header
    </tr> 
  </thead>          
  <tbody> ";

  foreach ($result as $row)
    {
      $male_checked = "";
      $female_checked = "";
      $unknown_checked = "";


      if ( $row['gender'] == 0 )
	{
	  $gender = "unknown";
	  $unknown_checked = "checked";
	}
      else if ($row['gender'] == 1)
	{
	  $gender = "male";
	  $male_checked = "checked";
	}
      else if ($row['gender'] == 2)
	{
	  $gender = "female";
	  $female_checked = "checked";
	}
      else 
	{
	  $gender = "???WHAT???";
	}

      if ($allow_modification)
	{
	  $modify_inputs = "<td>
                              <form id='form_" . $row['uid'] . "'>
                                 <input type='radio'  name='gender' value='Male'    onchange='modify_gender(" . $row['uid'] .")' $male_checked>Male
                                 <input type='radio'  name='gender' value='Female'  onchange='modify_gender(" . $row['uid'] .")' $female_checked>Female
                                 <input type='radio'  name='gender' value='Unknown' onchange='modify_gender(" . $row['uid'] .")' $unknown_checked>Unknown
                                 <input type='hidden' name='uid'    value='" . $row['uid'] ."'>
                              </form>
                              <div id='return_info_" . $row['uid'] . "'></div>
                            </td>";
	}
      

      echo
	"<tr>"
	.  "<td>" . $row['uid'] . "</td>"
	.  "<td>" . $row['name'] . "</td>"
	.  "<td id='td_" . $row['uid'] . "'>" . $gender . "</td>"
	.  $modify_inputs 
	."</tr>\n";
    }
  echo "</tbody></table>";



}
catch (PDOException $ex)
{
  echo "<p>oops</p>";
  echo "$ex";
}

?>
