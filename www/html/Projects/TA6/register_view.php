<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The view component of registering

-->

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
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
      <h2>Please use the form below to register</h2>
      
      <form method="POST" action="register.php" onsubmit="return checkForm(this);">
      	<p><label for="first">First Name</label> 
      	<input type="text" name="first" size=50 maxlength=20 required/></p>
      	<span name="firsterror" style="color:red"><?php echo $firstNameError ?></span></p>

		<p><label for="last">Last Name</label>
		<input type="text" name="last" size=50 maxlength=20 required/></p>
		<span name="lasterror" style="color:red"><?php echo $lastNameError ?></span></p>

		<p><label for="email">Email</label> 
		<input type="email" name="email" size=30  maxlength=20 required/></p>
		<span name="emailerror" style="color:red"><?php echo $loginError ?></span></p>
	  
		<p><label for="pass">Password</label>
		<input type="password" name="pass" size=30 maxlength=20 required/></p>
		<span name="passerror1" style="color:red"><?php echo $passwordError ?></span></p>
        
        <p><label for="pass2">Confirm Password</label>
		<input type="password" name="pass2" size=30 maxlength=20 required/></p>
        <span name="passerror2" style="color:red"></span></p>

		<p><input type="submit" value="Register"/></p>
	  </form>
    </div>
  
  </div>
  </body>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script type="text/javascript">
  function checkForm(form) 
{
	if(form.first.value == "") 
    {
      document.getElementsByName("firsterror")[0].innerHTML = "First name cannot be blank";
      form.first.focus();
      return false;
    
    }
	
	if(form.last.value == "") 
    {
      document.getElementsByName("lasterror")[0].innerHTML = "Last name cannot be blank";
      form.last.focus();
      return false;
    
    }
	
	if(form.email.value == "") 
    {
      document.getElementsByName("emailerror")[0].innerHTML = "Email cannot be blank";
      form.email.focus();
      return false;
    }
	
  if (form.pass.value == "")
    {
      document.getElementsByName("passerror1")[0].innerHTML = "Must have a password";
      form.pass.focus();
      return false;
    }

  if (form.pass.value != form.pass2.value)
    {
	  document.getElementsByName("passerror1")[0].innerHTML = "Passwords don't match";
	  form.pass.focus();
	  return false;
    }

  if(form.pass.value.length < 6)
    {
      document.getElementsByName("passerror1")[0].innerHTML = "Password must contain at least six characters";
      form.pass.focus();
      return false; 
    }
  
  if(form.pass.value == form.email.value || form.pass.value == form.first.value || form.pass.value == form.last.value) 
    {
      document.getElementsByName("passerror1")[0].innerHTML = "Password must be different from name or email";
      form.pass.focus();
      return false; 
    }
	
  return true; 
}
  </script>
</html>