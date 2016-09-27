<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The landing page for the applicant

-->


<?php
	require_once '../Models/authentication.php';
	verifyLogin(0);
	session_start();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Applicant Home Page</title>
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
    	<a href='app_home.php'><li>Home</li></a>
    	<a href='application.php'><li>Apply Here</li></a>
		<a href='app_view.php'><li>View Your Applications</li></a>
        <a href='../logout.php'><li>Logged in as <?php echo $_SESSION['first_name']; ?> (Log Out)</li></a>
		<a href='../schema.html'><li>DB Schema</li></a>
      	<a href='../README.html'><li>README</li></a>
	</ul>

    <div id="main">
      <h2 id="app_header">Hello Applicant!</h2>
      <p>So you want to be a teaching assistant eh?  Well, first you should know that the University of Utah is home to some of the greatest computer science students in the nation.  Luckily, you have the chance to be a part of that.  If you think you have what it takes to become a TA here at the U, click on "Apply Here" on the menu located above to get started.</p>
    </div>
    
  </div>
  </body>
</html>