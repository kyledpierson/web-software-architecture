<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Stub page - will display all TA evaluations

-->
<?php
	require_once '../Models/authentication.php';
	require_once 'Models/TA_Eval_Info.php';
	
	verifyLogin(2);
	session_start();
	$output = new TA_Eval_Info();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Class Overview Page</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
    
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script src="Models/comments.js"></script>
    
  </head>

  <body>
  
  <script>
  		$(document).ready(function() 
    	{ 
			// Sorting code from http://jsfiddle.net/Zhd2X/20/
			$('th').click(function()
			{
    			var table = $(this).parents('table').eq(0);
    			var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    			this.asc = !this.asc;
    			if (!this.asc)
				{
					rows = rows.reverse();
				}
    			for (var i = 0; i < rows.length; i++)
				{
					table.append(rows[i]);
				}
			})
			
			function comparer(index)
			{
    			return function(a, b)
				{
        			var valA = getCellValue(a, index), valB = getCellValue(b, index);
        			return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
    			}
			}
			
			function getCellValue(row, index)
			{
				return $(row).children('td').eq(index).html()
			}
    	});
	</script>
  
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
      <h2>Evaluation Overview for All Semesters Prior to Fall 2015</h2>
      <label id="lbl">Click on a table header to sort by that column</label>
      <?php echo $output; ?>
    </div>
    
  </div>
  </body>
</html>