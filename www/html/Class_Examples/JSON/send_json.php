<?php
  /**
   * 
   * Author: H. James de St. Germain
   * Date:   Spring 2014
   * 
   * Very basic example of JSON coding.
   * 
   * This file creates a PHP object and then sends it direclty to the web browser
   * for use with Javascript.
   *
   * Note 1: PHP uses the json_encode function to automagically turn a PHP object into a JavaScript object.
   * Note 2:the receiving javascript takes the JSON and uses it directly.
   * 
   */


/**
 * A basic person object
 * @author germain
 *
 */
class Person
{
   public $name    = "Jim";
   public $address = "Home";
   public $phone   = "123-1234";
}


$jim = new Person();

$jim->name = $_POST['username'];

// Note: Important step --> convert PHP object to JavaScript object
echo json_encode($jim);


// NOTE: if you were receiving a JSON object instead of returning one, you can use:
//       $obj = json_decode( $received_json );
//
//       and then treat $obj as a PHP object.


