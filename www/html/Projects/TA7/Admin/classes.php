<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Displays all classes and their details

-->

<?php
	require_once '../Models/authentication.php';
	require_once 'Models/Class_Info.php';
	
	verifyLogin(2);	
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Class Overview Page</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>
  
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  	<script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script src="Models/assigned_tas.js"></script>
  <script>
  	$(function()
	{	
		$("#show_col").click(
		function()
		{
			if($(this).val() == "Hide Title")
			{
				$(this).val("Show Title");
				$(".c_title").attr("style", "display:none");
			}
			else
			{
				$(this).val("Hide Title");
				$(".c_title").attr("style", "display:block");
			}
		});
		$(".expand").click(
		function()
		{
			if($(this).attr("src") == "../Images/icon_small_plus.gif")
			{
				$(this).attr("src", "../Images/icon_small_minus.gif");
				$(this).parents("tr").next().attr("style", "display:table-row");
			}
			else
			{
				$(this).attr("src", "../Images/icon_small_plus.gif");
				$(this).parents("tr").next().attr("style", "display:none");
			}
		});
	});
  </script>

  <body>
  <div id="wrapper">
    
    <img id="headerbg" src="../Images/background_swirl.png" alt="headerbg"/>
    <p id="subtitle">Welcome to the Administrator View of the TA Application</p>

    <div id="rhs"></div>

    <header>
      <img id="icon" src="../Images/earth.png" alt="icon"/>
      <h1>Class Overview Page</h1>
    </header>

    <ul>
    	<a href='ad_home.php'><li>Home</li></a>
    	<a href='classes.php'><li>View Classes</li></a>
		<a href='applicants.php'><li>View Applicants</li></a>
        <a href='ta_evals.php'><li>View TA Evaluations</li></a>
        <a href='../logout.php'><li>Logged in as <?php echo $_SESSION['first_name'] ?> (Log Out)</li></a>
        <a href='../schema.html'><li>DB Schema</li></a>
      	<a href='../README.html'><li>README</li></a>
	</ul>

    <div id="main">
    	<div id="select_class">
      <h2>Please select a term and a year</h2>
      <form method="post">
    		<select name = "term">
  				<option value="Fall"<?php if($output->get_term() == 'Fall') echo 'selected' ?>>Fall</option>
				<option value="Spring"<?php if($output->get_term() == 'Spring') echo 'selected' ?>>Spring</option>
				<option value="Summer"<?php if($output->get_term() == 'Summer') echo 'selected' ?>>Summer</option>
			</select>
            <select name = "year">
  				<option value="2008"<?php if($output->get_year() == '2008') echo 'selected' ?>>2008</option>
				<option value="2009"<?php if($output->get_year() == '2009') echo 'selected' ?>>2009</option>
				<option value="2010"<?php if($output->get_year() == '2010') echo 'selected' ?>>2010</option>
				<option value="2011"<?php if($output->get_year() == '2011') echo 'selected' ?>>2011</option>
                <option value="2012"<?php if($output->get_year() == '2012') echo 'selected' ?>>2012</option>
                <option value="2013"<?php if($output->get_year() == '2013') echo 'selected' ?>>2013</option>
                <option value="2014"<?php if($output->get_year() == '2014') echo 'selected' ?>>2014</option>
                <option value="2015"<?php if($output->get_year() == '2015') echo 'selected' ?>>2015</option>
			</select>
    		<input type="submit" value="Get Selected Classes from Database" name="submit"><br><br>
            <input type="submit" value="Update Current Display from Catalog" name="fetch">
            <input type="submit" value="Reset Current Display Enrollments to Zero" name="reset">
		</form>
        </div>
        
        <div id="assignments">
    	<form>
        	<p>
            <h2>Applicant Status &nbsp;
        	<select name = "assign_class" id="assign_class" onchange="return find_ta_table()">
  				<option value="None" selected>None</option>
            	<?php foreach($output->get_class_names() as $value)
					{ echo "<option value=\"" . $value . "-" . $output->get_year() . $output->get_term() . "\">" . $value 
					. "</option>"; }?>
			</select>
            </h2>
            </p>
            <div id="header_ta"><?php echo "<label class='header_ta' id='lbl'>Select a course for " . $output->get_term() . " "
					. $output->get_year() . " from the menu above to view applicants and their status</label>" ?></div>
            <div id="content_ta"></div>
        </form>
        </div>
      <?php echo $output; ?>
    </div>
    
  </div>
  </body>
</html>