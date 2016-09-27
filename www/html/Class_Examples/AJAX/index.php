<?php

/**
 *
 *  Author: H. James de St. Germain
 *  Date:   Spring 2014
 *
 *  Simple program showing how to use AJAX
 *
 */

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>AJAX Demo</title>

    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="get_data.js"></script>
  </head>

   <body>
      <h1> AJAX </h1>
      
        <form  id="form_id"   onsubmit="return find_data()">
       
         <input type="checkbox" name="cause_error" value="true"> Cause an Error<br/>
         <input type="checkbox" name="before_send" value="true">Enable before send alert <br/>
         <input type="checkbox" name="on_success" value="true">Enable on_success alert<br/>
         <input type="checkbox" name="show_origination" value="true">Show where we came form
         
         <br/>
         
         Message: <input type="text" name="message"> 
                             	  
         <br/>
         
         <input type="submit" value="Submit">
         </form>
      

      <div id="content"></div>
   </body>
   
</html>