<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Represents the actual TA application

-->

<?php
  require_once "../authentication.php";
  
  verifyLogin(0);
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Application Page</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>

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
      <a href="app_home.php"><li>Home</li></a>
      <a href="application.php"><li>Apply Here</li></a>
      <a href="get_apps.php"><li>View Your Applications</li></a>
      <?php
        if(isset($_SESSION['user_id'])) { echo "<a href=\"../logout.php\"><li>Logged in as " . $_SESSION['first_name'] . " (Log Out)</li></a>"; }
      ?>
    </ul>

    <div id="main">
  <h2>Please fill out the form below</h2>
	
	<form method="post" action="process.php" enctype="multipart/form-data">
      <fieldset>
	  
	  <p>
	  <label for="Major" class="aligned_box">Major</label> 
      <input type="text" value="CS" id="Major" name="Major" class="aligned_box"/>
	  
	  <label for="GPA" class="aligned_box">GPA</label>
      <input type="text" value="4.0" id="GPA" name="GPA" class="aligned_box"/></p>
      
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
	  <br></p>
	  
	  <p>
      <label>Select the CS classes you have taken</label><br>
        <input type="checkbox" name="taken[]" value="1400">CS 1400 &nbsp; &nbsp; &nbsp; &nbsp;
			<label for="grade1400">Grade&nbsp; &nbsp;</label><input type="text" id="grade1400" name="grade1400" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term1400" id="term1400">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year1400" id="year1400">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="1410">CS 1410 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade1410">Grade&nbsp; &nbsp;</label><input type="text" id="grade1410" name="grade1410" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term1410" id="term1410">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year1410" id="year1410">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="2100">CS 2100 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade2100">Grade&nbsp; &nbsp;</label><input type="text" id="grade2100" name="grade2100" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term2100" id="term2100">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year2100" id="year2100">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="2420">CS 2420 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade2420">Grade&nbsp; &nbsp;</label><input type="text" id="grade2420" name="grade2420" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term2420" id="term2420">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year2420" id="year2420">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="3100">CS 3100 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade3100">Grade&nbsp; &nbsp;</label><input type="text" id="grade3100" name="grade3100" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term3100" id="term3100">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year3100" id="year3100">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="3200">CS 3200 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade3200">Grade&nbsp; &nbsp;</label><input type="text" id="grade3200" name="grade3200" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term3200" id="term3200">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year3200" id="year3200">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="3500">CS 3500 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade3500">Grade&nbsp; &nbsp;</label><input type="text" id="grade3500" name="grade3500" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term3500" id="term3500">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year3500" id="year3500">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="3505">CS 3505 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade3505">Grade&nbsp; &nbsp;</label><input type="text" id="grade3505" name="grade3505" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term3505" id="term3505">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year3505" id="year3505">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="3810">CS 3810 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade3810">Grade&nbsp; &nbsp;</label><input type="text" id="grade3810" name="grade3810" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term3505" id="term3505">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year3505" id="year3505">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="4000">CS 4000 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade4000">Grade&nbsp; &nbsp;</label><input type="text" id="grade4000" name="grade4000" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term4000" id="term4000">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year4000" id="year4000">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="4150">CS 4150 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade4150">Grade&nbsp; &nbsp;</label><input type="text" id="grade4150" name="grade4150" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term4150" id="term4150">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year4150" id="year4150">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="4400">CS 4400 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade4400">Grade&nbsp; &nbsp;</label><input type="text" id="grade4400" name="grade4400" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term4400" id="term4400">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year4400" id="year4400">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="4500">CS 4500 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade4500">Grade&nbsp; &nbsp;</label><input type="text" id="grade4500" name="grade4500" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term4500" id="term4500">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year4500" id="year4500">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="4940">CS 4940 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade4940">&nbsp; &nbsp;Grade</label><input type="text" id="grade4940" name="grade4940" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term4940" id="term4940">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year4940" id="year4940">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
        <input type="checkbox" name="taken[]" value="4970">CS 4970 &nbsp; &nbsp; &nbsp; &nbsp;
		<label for="grade4970">Grade&nbsp; &nbsp;</label><input type="text" id="grade4970" name="grade4970" size="2" maxlength="2"/>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="term4970" id="term4970">
					<option value="Fall" selected="selected">Fall</option>
					<option value="Spring">Spring</option>
					<option value="Summer">Summer</option>
				</select>&nbsp; &nbsp; &nbsp; &nbsp;
				<select name="year4970" id="year4970">
					<option value="2010" selected="selected">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
				</select><br>
      </p>
	  
	  <p>
      <label>Select the CS class for which you wish to TA</label><br>
        <input type="checkbox" name="apply[]" value="1400">CS 1400<br>
        <input type="checkbox" name="apply[]" value="1410">CS 1410<br>
        <input type="checkbox" name="apply[]" value="2100">CS 2100<br>
        <input type="checkbox" name="apply[]" value="2420">CS 2420<br>
        <input type="checkbox" name="apply[]" value="3100">CS 3100<br>
        <input type="checkbox" name="apply[]" value="3200">CS 3200<br>
        <input type="checkbox" name="apply[]" value="3500">CS 3500<br>
        <input type="checkbox" name="apply[]" value="3505">CS 3505<br>
        <input type="checkbox" name="apply[]" value="3810">CS 3810<br>
        <input type="checkbox" name="apply[]" value="4000">CS 4000<br>
        <input type="checkbox" name="apply[]" value="4150">CS 4150<br>
        <input type="checkbox" name="apply[]" value="4400">CS 4400<br>
        <input type="checkbox" name="apply[]" value="4500">CS 4500<br>
        <input type="checkbox" name="apply[]" value="4940">CS 4940<br>
        <input type="checkbox" name="apply[]" value="4970">CS 4970<br>
	  </p>
      
	  <p>
        <label for="Essay" id="Essay">Why do you think you would be a good teaching assistant?</label>
        <br />
        <textarea id="Essay" value="This is my essay for why I would make a great TA!" name="Essay" rows="5" cols="30"></textarea>
      </p>
      
	  <p>
        <input type="submit" name="SubmitButton" value="Submit" />
      </p></fieldset>
    </form>
</div>

</div>

</body>
</html>