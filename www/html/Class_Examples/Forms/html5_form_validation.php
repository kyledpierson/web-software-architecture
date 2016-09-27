<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HTML5 form validation</title>
    <script type="text/javascript" src="../../jquery/jquery.js"></script>
</head>

<body>



<!-- Author: H. James de St. Germain
     Date: Spring 2015

   This file contains examples of form validation using HTML5


Notes:

1) required field for an input forces it to be ... required ...
2) attribute type: can change input type from "text" to:
                email, url, number, tel, date, color, date, datetime, month, search, time, week, range

     - note "tel" just tells mobile to bring up number inputs, does not validate

2.5)  Not all types supported by all browsers - this is always a concern

3) attribute placeholder:  can show original input field message
4) attribute value: can use to preset data in form
5) attribute pattern: allows regular expression checking


o) For custom message, see setCustomValidity in JS below



-->


<style type="text/css">

   
input:required:invalid, input:focus:invalid
{
  background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAeVJREFUeNqkU01oE1EQ/mazSTdRmqSxLVSJVKU9RYoHD8WfHr16kh5EFA8eSy6hXrwUPBSKZ6E9V1CU4tGf0DZWDEQrGkhprRDbCvlpavan3ezu+LLSUnADLZnHwHvzmJlvvpkhZkY7IqFNaTuAfPhhP/8Uo87SGSaDsP27hgYM/lUpy6lHdqsAtM+BPfvqKp3ufYKwcgmWCug6oKmrrG3PoaqngWjdd/922hOBs5C/jJA6x7AiUt8VYVUAVQXXShfIqCYRMZO8/N1N+B8H1sOUwivpSUSVCJ2MAjtVwBAIdv+AQkHQqbOgc+fBvorjyQENDcch16/BtkQdAlC4E6jrYHGgGU18Io3gmhzJuwub6/fQJYNi/YBpCifhbDaAPXFvCBVxXbvfbNGFeN8DkjogWAd8DljV3KRutcEAeHMN/HXZ4p9bhncJHCyhNx52R0Kv/XNuQvYBnM+CP7xddXL5KaJw0TMAF8qjnMvegeK/SLHubhpKDKIrJDlvXoMX3y9xcSMZyBQ+tpyk5hzsa2Ns7LGdfWdbL6fZvHn92d7dgROH/730YBLtiZmEdGPkFnhX4kxmjVe2xgPfCtrRd6GHRtEh9zsL8xVe+pwSzj+OtwvletZZ/wLeKD71L+ZeHHWZ/gowABkp7AwwnEjFAAAAAElFTkSuQmCC);
  background-position: right top;
  background-repeat: no-repeat;
  -moz-box-shadow: none;
}


input:required:valid
{
  background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAepJREFUeNrEk79PFEEUx9/uDDd7v/AAQQnEQokmJCRGwc7/QeM/YGVxsZJQYI/EhCChICYmUJigNBSGzobQaI5SaYRw6imne0d2D/bYmZ3dGd+YQKEHYiyc5GUyb3Y+77vfeWNpreFfhvXfAWAAJtbKi7dff1rWK9vPHx3mThP2Iaipk5EzTg8Qmru38H7izmkFHAF4WH1R52654PR0Oamzj2dKxYt/Bbg1OPZuY3d9aU82VGem/5LtnJscLxWzfzRxaWNqWJP0XUadIbSzu5DuvUJpzq7sfYBKsP1GJeLB+PWpt8cCXm4+2+zLXx4guKiLXWA2Nc5ChOuacMEPv20FkT+dIawyenVi5VcAbcigWzXLeNiDRCdwId0LFm5IUMBIBgrp8wOEsFlfeCGm23/zoBZWn9a4C314A1nCoM1OAVccuGyCkPs/P+pIdVIOkG9pIh6YlyqCrwhRKD3GygK9PUBImIQQxRi4b2O+JcCLg8+e8NZiLVEygwCrWpYF0jQJziYU/ho2TUuCPTn8hHcQNuZy1/94sAMOzQHDeqaij7Cd8Dt8CatGhX3iWxgtFW/m29pnUjR7TSQcRCIAVW1FSr6KAVYdi+5Pj8yunviYHq7f72po3Y9dbi7CxzDO1+duzCXH9cEPAQYAhJELY/AqBtwAAAAASUVORK5CYII=);
  background-position: right top;
  background-repeat: no-repeat;
}
</style>


<form>

  <ul>
    <li>
      <p>
	Your Name:
	<input type="text" name="name" value="default" required/>
      </p>
    </li>

    <li>
      <p>Your email:
      <input type="email" name="email"
	     placeholder="login@gmail.com"
	     required/> </p>
    </li>

    <li title="Example: http://page.loc">
      <p>Your homepage:
      <input type="url" name="url" size="50"
	     placeholder="http://www.cs.utah.edu/~germain"
             onchange="validate_homepage(event)"
	     required/> </p>
    </li>

    <li>
      <p>Your telephone number:
      <input type="tel" name="telephone"
	     placeholder="(801) 123-4567"
	     pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$"
	     required/> </p>
    </li>

    <li>
      <p>Your age:
      <input type="number" name="age" size="5"
	     min="1" max="150"
	     required/> </p>
    </li>

    <li>
      <p>Your favorite color:
      <input type="color" name="color"
	     required/> </p>
    </li>
    
    <li>
      <p>Your birthday:
      <input type="date" name="bd"
	     required/> </p>
    </li>
    
    <li>
      <p>Search Box:
      <input type="search" name="search"
	     required/> </p>
    </li>


    <li>
      <p>How Happy are You:
      <input type="range" name="happy"
	     min="1" max="100" value="50"
	     required/> </p>
    </li>

    <li>
      <p>Password:
      <input type="password" name="pass"
	     required/> </p>
    </li>
  </ul>
  
  <br/>
     
  <input type="submit"/>
</form>




<script>


//
// This function is applied when the homepage input is changed,
// thus allowing a custom error message (and if the pattern isn't
// enough, a custom regular expression check could be made as well)
//
// WARNING: when a message is set using setCustomValidity,  THIS
//          MAKES THE INPUT INVALID!  Inorder or the input to be valid
//          at a future point, the Custom message has to be blanked.
//
function validate_homepage(event)
{
  var input        = event.target;
  var validity_obj = input.validity;

  input.setCustomValidity("");

  console.log("in validate homepage");
  
  if (! validity_obj.valid)
    {
      console.log(" homepage is invalid, setting custom message");
      input.setCustomValidity("Please use the following form: http://site.com");
    }
  else
    {
      console.log("homepage Url is valid");
    }
}
     
</script>

</body>