<!DOCTYPE html>
<html>

<head>
<title>Please Log In</title>
</head>
<body>

<h2>Please Log In</h2>

<p style="color:red"><?php echo $message ?></p>

<form method="get">

<table>
<tr><td><label for="username">Username</label></td>
    <td><input type="text" size="20" name="username" id="username"/></td></tr>
    
<tr><td><label for="password">Password</label></td>
    <td><input type="text" size="20" name="password" id="password"/></td></tr>
    
<tr><td colspan="2"><input type="submit" value="Submit"/></td></tr>
</table>

</form>

</body>
</html>
