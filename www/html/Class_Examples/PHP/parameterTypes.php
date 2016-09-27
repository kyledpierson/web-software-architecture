<!DOCTYPE html>
<!--
      Author: Zachary
      Modified by: H. James de St. Germain  -  Spring 2014

      Important Notes:

        1) notice the various input types
        2) notice how the php can access them all using the
          given name
        3) notice that the checkbox input doesn't send a value if it is not checked....

-->

<html>
  <head>
    <title>Extracting Parameters</title>
  </head>
  
  <body>
    
    <form method="post">
      
      <p>
        <label for="textbox">Text Box:</label>
        <input type="text" size=10 id="textbox" name="textbox_name"/>
      </p>
      
      <p>
        <label for="checkbox">Checkbox:</label>
        <input type="checkbox" size=10 id="checkbox" checked name="checkbox_name"/>
      </p>
      
      <p>
        <label for="radio1">Radio 1:</label>
        <input type="radio" id="radio1" name="radio_name" value="radio1" checked /><br/>
        <label for="radio2">Radio 2:</label>
        <input type="radio" id="radio2" name="radio_name" value="radio2"/><br/>
        <label for="radio3">Radio 3:</label>
        <input type="radio" id="radio3" name="radio_name" value="radio3"/><br/>
      </p>
      
      <p>
        <label for="menu">Menu:</label>
        <select name="menu_name" id="menu">
          <option value="One">One</option>
          <option value="Two">Two</option>
          <option value="Three" selected>Three</option>
        </select>
      </p>
      
      <p>
        <input type="submit" value="Submit"/>
      </p>
      
    </form>
    
    <table border=1>
      <tr><th>Input Name</th><th>Input Value</th></tr>
      <?php 
        foreach ($_REQUEST as $name => $value)
        {
          echo "<tr><td>$name</td><td>$value</td></tr>";
        }
      ?>
    </table>
    
  </body>
  
</html>