<?php
  /**
   * Author: H. James de St. Germain
   * Date: Summer 2013
   */

  

/**
 *
 *  Function Handle Post
 *
 *  If the variable does not exist, replace
 *  it with the given default
 *
 *  $var_name    - the posted variable name
 *  $default     - if the posted variable doesn't exist or is empty, use the default 
 *
 */

function  handle_post( $var_name, $default )
{
  if (isset($_POST[$var_name]))
    {
      return $_POST[$var_name];
    }
  else
    {
      return $default;
    }
}


?>