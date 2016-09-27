<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The landing page for the Admin

-->

<?php
	require_once '../authentication.php';

	verifyLogin(2);
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Home Page</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>

  <body>
  <div id="wrapper">
    
    <img id="headerbg" src="../Images/background_swirl.png" alt="headerbg"/>
    <p id="subtitle">Welcome to the Administrator View of the TA Application</p>

    <div id="rhs"></div>

    <header>
      <img id="icon" src="../Images/earth.png" alt="icon"/>
      <h1>TA Administrator Page</h1>
    </header>

    <ul>
      <a href="ad_home.php"><li>Home</li></a>
      <a href="get_classes.php"><li>View Classes</li></a>
      <a href="get_applicants.php"><li>View Applicants</li></a>
      <a href="get_ta_evals.php"><li>View TA Evaluations</li></a>
      <?php
        if(isset($_SESSION['user_id'])) {echo "<a href=\"../logout.php\"><li>You are logged in as " . $_SESSION['first_name'] . " (Log Out)</li></a>";}
      ?>
      <a href="../schema.html"><li>DB Schema</li></a>
      <a href="../README.html"><li>README</li></a>
    </ul>

    <div id="main">
      <h2>Hello Administrator!</h2>
      <p>Here you can view the status of all classes and TAs.</p>
    </div>
    
  </div>
  </body>
</html>