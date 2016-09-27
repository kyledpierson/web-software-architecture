<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

Shows the status of this instructors classes

-->

<?php
	require_once '../authentication.php';

	verifyLogin(1);
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Instructor Class View</title>
    <link href="../style.css" rel="stylesheet" type="text/css">
  </head>

  <body>
  <div id="wrapper">
    
    <img id="headerbg" src="../Images/background_swirl.png" alt="headerbg"/>
    <p id="subtitle">Welcome to the Instructor View of the TA Application</p>

    <div id="rhs"></div>

    <header>
      <img id="icon" src="../Images/earth.png" alt="icon"/>
      <h1>Instructor Class View</h1>
    </header>

    <ul>
      <a href="inst_home.php"><li>Home</li></a>
      <a href="get_class_tas.php"><li>View Possible TAs For Your Classes</li></a>
      <a href="get_evals.php"><li>TA Evaluations</li></a>
      <?php
        if(isset($_SESSION['user_id'])) {echo "<a href=\"../logout.php\"><li>You are logged in as " . $_SESSION['first_name'] . " (Log Out)</li></a>";}
      ?>
    </ul>

    <div id="main">
    	<h2>Here is an overview of all your classes for Fall of 2015</h2>
    		<?php echo $output; ?>
    </div>
    
  </div>
  </body>
</html>