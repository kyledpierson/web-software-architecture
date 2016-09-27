<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Stub page - will be used to get TA evaluations

-->

<?php
	require_once '../Models/authentication.php';
	verifyLogin(1);
	session_start();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Instructor Evaluation Page</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>

  <body>
  <div id="wrapper">
    
    <img id="headerbg" src="../Images/background_swirl.png" alt="headerbg"/>
    <p id="subtitle">Welcome to the Instructor View of the TA Application</p>

    <div id="rhs"></div>

    <header>
      <img id="icon" src="../Images/earth.png" alt="icon"/>
      <h1>TA Evaluations</h1>
    </header>

    <ul>
    	<a href='inst_home.php'><li>Home</li></a>
    	<a href='class_view.php'><li>View Possible TAs For Your Classes</li></a>
		<a href='evaluations.php'><li>TA Evaluations</li></a>
        <a href='../logout.php'><li>Logged in as <?php echo $_SESSION['first_name'] ?> (Log Out)</li></a>
		<a href='../schema.html'><li>DB Schema</li></a>
    	<a href='../README.html'><li>README</li></a>
	</ul>

    <div id="main">
    	<h2>Stub - Here you can evaluate your TAs</h2>
    </div>
    
  </div>
  </body>
</html>