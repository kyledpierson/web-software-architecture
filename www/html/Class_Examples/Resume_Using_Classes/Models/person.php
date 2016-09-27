<?php
  /**
   *
   * Author: H. James de St. Germain
   * Date: Spring 2014
   * 
   * This code represents a person
   * 
   */


class Person
{
  public $name = "Please Enter";
  public $address = "Please Enter";
  public $phone   = "Please Enter";
	
  /**
   * Constructor
   */
  public function __construct()
  {
    //$this->name = "";
  }

  /**
   * Print a concise (for debugging) string representation of the resume object
   *
   * @return string
   */
  public function __toString()
  {
    return "Person $this->name";
  }
	
  /**
   *  return error class if name is not valid
   *
   */
  function set_name( $name )
  {
    if (  strlen($name) > 0 && $name != "Please Enter")
      {
	$this->name = htmlspecialchars($name);
	return "";
      }
    else
      {
	return "class='error'";
      }
	
  }
	
  /**
   *  return error class if name is not valid
   *
   */
  function set_address( $addr )
  {
    if ( strlen($addr) > 0 && $addr!="Please Enter")
      {
	$this->address = $addr;
	return "";
      }
    else
      {
	return "class='error'";
      }
	
  }
	
  /**
   *  return error class if phone is not valid
   *
   */
  function set_phone( $phone )
  {
    if (  strlen($phone) > 0 && $phone!="Please Enter")
      {
	$this->phone = $phone;
	return "";
      }
    else
      {
	return "class='error'";
      }
	
  }
	


}