<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The view component of displaying the applications

-->

<?php
  require_once "../Models/authentication.php";
  require_once 'Models/App_Info.php';
  verifyLogin(0);
  
  session_start();
  $app_info = new App_Info($_SESSION['user_id'], $_SESSION['first_name'], $_SESSION['last_name'], $_SESSION['email']);
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
    	<a href='app_home.php'><li>Home</li></a>
    	<a href='application.php'><li>Apply Here</li></a>
		<a href='app_view.php'><li>View Your Applications</li></a>
        <a href='../logout.php'><li>Logged in as <?php echo $_SESSION['first_name']; ?> (Log Out)</li></a>
		<a href='../schema.html'><li>DB Schema</li></a>
      	<a href='../README.html'><li>README</li></a>
	</ul>

    <div id="main">
      <form method="POST">
        <label for="choose_class">Which of your applications would you like to view?</label>
        <select name="choose_class">
        <?php  echo $app_info->show_class_options(); ?>
		</select>
        <p>
        	<input type="submit" name="SubmitButton" value="Submit" />
      	</p>
      </form>
      	
    <?php
		if(isset($_REQUEST['choose_class']))
		{
			$app_info->update_visible_class($_REQUEST['choose_class']);
			echo $app_info;
		}
	?>
      
    </div>
    
  </div>
  </body>
</html>
