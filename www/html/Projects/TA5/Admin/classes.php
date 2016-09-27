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
	session_start();
	$output = new Class_Info();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Class Overview Page</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>

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
      <h2>Class Overview for Fall of 2015</h2>
      <?php echo $output; ?>
    </div>
    
  </div>
  </body>
</html>