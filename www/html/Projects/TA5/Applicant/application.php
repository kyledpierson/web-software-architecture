<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Represents the actual TA application

-->

<?php
  require_once "../Models/authentication.php";
  verifyLogin(0);
  session_start();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Application Page</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="Models/app_functions.js"></script>

  <body>
  <div id="wrapper">
    
    <img id="headerbg" src="../Images/background_swirl.png" alt="headerbg"/>
    <p id="subtitle">Welcome to the TA Application, this is your first step on the path to becoming a TA.</p>

    <div id="rhs"></div>

    <header>
      <img id="icon" src="../Images/earth.png" alt="icon"/>
      <h1>TA Application</h1>
    </header>

    <ul>
    	<a href='app_home.php'><li>Home</li></a>
    	<a href='application.php'><li>Apply Here</li></a>
		<a href='app_view.php'><li>View Your Applications</li></a>
        <a href='../logout.php'><li>Logged in as <?php echo $_SESSION['first_name']; ?> (Log Out)</li></a>
		<a href='../schema.html'><li>DB Schema</li></a>
      	<a href='../README.html'><li>README</li></a>
	</ul>

    <div id="main">
  <h2>Please fill out the form below</h2>
	
	<form name="app_form" method="post" action="Models/process.php" enctype="multipart/form-data" onsubmit="return validate();">
      <fieldset>
	  
	  <p>
	  <label for="Major" class="aligned_box">Major</label> 
      <input type="text" maxlength=20 placeholder="Computer Science" id="Major" name="Major" class="aligned_box" required/>
	  
	  <label for="GPA" class="aligned_box">GPA</label>
      <input type="text" maxlength=5 placeholder="4.0" id="GPA" name="GPA" class="aligned_box" required/></p>
      
	  <p>
      <input type="radio" name="Academic" id="Academic" value="Freshman" checked="checked"/> 
      <label for="Academic">Freshman</label>
	  <br>
      
	  <input type="radio" name="Academic" id="Academic" value="Sophomore" /> 
      <label for="Academic">Sophomore</label>
	  <br>
	  
	  <input type="radio" name="Academic" id="Academic" value="Junior" /> 
      <label for="Academic">Junior</label>
	  <br>
      
	  <input type="radio" name="Academic" id="Academic" value="Senior" /> 
      <label for="Academic">Senior</label>
	  <br>
	  
	  <input type="radio" name="Academic" id="Academic" value="Graduate" /> 
      <label for="Academic">Graduate</label>
	  <br></p><br>
        
      
      <div id="division">
      <label>Select the CS classes you have taken</label><br>
      <label id="lbl">Only entries in which all fields have been selected will be recorded</label>
      <table id="Class_List">
        <tr class="block">
        	<td id="content" style="border:none">
            <label for="loop[]">Class</label>
        	<select name="loop[]" class="class">
				<option value="None" selected="selected">None</option>
				<option value="1400">CS 1400</option>
                <option value="1410">CS 1410</option>
                <option value="2100">CS 2100</option>
                <option value="2420">CS 2420</option>
                <option value="3100">CS 3100</option>
                <option value="3200">CS 3200</option>
                <option value="3500">CS 3500</option>
                <option value="3505">CS 3505</option>
                <option value="3810">CS 3810</option>
                <option value="4000">CS 4000</option>
                <option value="4150">CS 4150</option>
				<option value="4400">CS 4400</option>
                <option value="4500">CS 4500</option>
                <option value="4940">CS 4940</option>
                <option value="4970">CS 4970</option>
			</select>
            <label for="grade">Grade</label>
            <select name="grade" class="grade">
				<option value="None" selected="selected">None</option>
				<option value="A+">A+</option>
                <option value="A">A</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B">B</option>
                <option value="B-">B-</option>
                <option value="C+">C+</option>
                <option value="C">C</option>
                <option value="C-">C-</option>
                <option value="D+">D+</option>
                <option value="D">D</option>
				<option value="D-">D-</option>
                <option value="F">F</option>
			</select>
            <label for="term">Term</label>
				<select name="term" class="term">
                	<option value="None" selected="selected">None</option>
					<option value="Fall">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>
            <label for="year">Year</label>
				<select name="year" class="year">
					<option value="None" selected="selected">None</option>
                    <option value="2010">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select>
                <input type='button' value='Add Class' id="Add"/>
                <input type='button' value='Remove Class' id="Remove"/>
              </td>
          </tr>
      </table>
      <p id="message" class="warning"></p>
      </div><br><br>
	  
	  <div id="division">
      <label>Select the CS classes for which you wish to TA</label><br>
      <table id="App_List">
        <tr class="app_block">
        	<td id="app_content" style="border:none">
            <label for="app_loop[]">Class</label>
        	<select name="app_loop[]" class="app">
				<option value="None" selected="selected">None</option>
				<option value="1400">CS 1400</option>
                <option value="1410">CS 1410</option>
                <option value="2100">CS 2100</option>
                <option value="2420">CS 2420</option>
                <option value="3100">CS 3100</option>
                <option value="3200">CS 3200</option>
                <option value="3500">CS 3500</option>
                <option value="3505">CS 3505</option>
                <option value="3810">CS 3810</option>
                <option value="4000">CS 4000</option>
                <option value="4150">CS 4150</option>
				<option value="4400">CS 4400</option>
                <option value="4500">CS 4500</option>
                <option value="4940">CS 4940</option>
                <option value="4970">CS 4970</option>
			</select><br><br>
            <label for="essay" id="lbl">Why do you think you would be a good teaching assistant for this class?</label>
        	<br>
        	<textarea class="essay" name="essay" rows="5" cols="30" maxlength=300 placeholder="Write your response here"></textarea>
            	<input type='button' value='Add Application' id="Add_app"/>
                <input type='button' value='Remove Application' id="Remove_app"/>
			</td>
          </tr>
        </table> 
        <p id="app_message" class="warning"></p>           
	  </div>
      
	  <p>
        <input type="submit" name="SubmitButton" value="Submit"/>
      </p></fieldset>
    </form>
</div>

</div>

</body>
</html>