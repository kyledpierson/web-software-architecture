<!DOCTYPE html>
<html>

<head>
<title>Register</title>
</head>

<body>

<h2>Register</h2>

<p>Please use the form below to register for this site.</p>

<!-- SECURITY MISAKE.  Credentials will be in the URL. -->

<form method="get" action="">

<p><label for="name">Name</label> 
<input type="text" name="name" value="<?php sticky('name') ?>"size=100/>
<span style="color:red"><?php echo $nameError ?></span></p>

<p><label for="login">Login name</label> 
<input type="text" name="login" value="<?php sticky('login') ?>"size=30/>
<span style="color:red"><?php echo $loginError ?></span></p>

<!-- SECURITY MISTAKE.  Passwords are visible "over the shoulder" -->
  
<p><label for="password">Password</label>
<input type="text" name="password" size="30"/>
<span style="color:red"><?php echo $passwordError?></span></p>

<p><label for="admin">Administrator?</label>
<input type="checkbox" name="admin" id="admin"/></p>

<p><input type="submit" value="Register"/></p>

</form>

</body>

</html>