<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The view component of displaying the applications

-->

<?php
  require_once "../authentication.php";
  
  verifyLogin(0);
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>View Applications</title>
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
      <form method="POST">
        <label for="choose_class">Which of your applications would you like to view?</label>
        <select name="choose_class">
        <?php
		
		foreach($classAppsBig as $key => $value)
		{
			echo "<option value=\"" . $key . "\">" . $key . "</option>";
		}
		
		?>
		</select>
        <p>
        	<input type="submit" name="SubmitButton" value="Submit" />
      	</p>
      </form>
    <?php echo $output; ?>
      
    </div>
    
  </div>
  </body>
</html>
