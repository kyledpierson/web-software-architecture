<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The landing page for anyone visiting the site who is not logged in

-->

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>TA Application Home</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="wrapper">

  <img id="headerbg" src="Images/background_swirl.png" alt="headerbg"/>

	<p id="subtitle">Welcome to the TA Application Home Page</p>

  <div id="rhs"></div>

  <header>
    <img id="icon" src="Images/earth.png" alt="icon"/>
    <h1>TA Application Home Page</h1>
  </header>

  <ul>
    <a href="ta_index.php"><li>Home</li></a>
    <?php
	if(isset($_SESSION['user_id']))
	{
		if($_SESSION['role'] == 0)
			echo "<a href=\"Applicant/app_home.php\"><li>Applicant Home Page</li></a>";
		else if($_SESSION['role'] == 1)
			echo "<a href=\"Instructor/inst_home.php\"><li>Instructor Home Page</li></a>";
		else if($_SESSION['role'] == 2)
			echo "<a href=\"Admin/ad_home.php\"><li>Admin Home Page</li></a>";
		echo "<a href=\"logout.php\"><li>You are logged in as " . $_SESSION['first_name'] . " (Log Out)</li></a>";
	}
	else
	{
		echo "<a href=\"login.php\"><li>Log In</li></a>
		<a href=\"register.php\"><li>Set Up An Account</li></a>";
	}
	?>
    <a href="../../index.html"><li>My Website</li></a>
    <a href="schema.html"><li>DB Schema</li></a>
    <a href="README.html"><li>README</li></a>
  </ul>

<div id="main">
  <p>  <?php if(isset($registered)){echo $registered; unset($registered);} ?> </p>
  <p>This is the home page for the TA Application website.  Please login in or create an account to continue</p>
</div>

</div>

</body>
</html>