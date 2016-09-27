<!--

Author: Kyle Pierson
Assignment: TA3
Date: 12 February 2015

The view component of logging in

-->

<!doctype html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>Log in</title>
    <link href='style.css' rel='stylesheet' type='text/css'>
  </head>

  <body>
  <div id='wrapper'>
    
    <img id='headerbg' src='Images/background_swirl.png' alt='headerbg'/>
    <p id='subtitle'>Welcome to the TA Application Home Page</p>

    <div id='rhs'></div>

    <header>
      <img id='icon' src='Images/earth.png' alt='icon'/>
      <h1>TA Application Home Page</h1>
    </header>

    <ul>
        <a href="ta_index.php"><li>Home</li></a>
        <?php
        session_start();
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

    <div id='main'>
      <h2>Please log in</h2>
      <p style='color:red' id="message"> <?php echo $message ?> </p>

      <form method='POST' action='login.php'>
        <table>
          <tr><td><label for='log_email'>Email</label></td>
          <td><input type='text' size='20' name='log_email' id='log_email'/></td></tr>

          <tr><td><label for='log_pass'>Password</label></td>
          <td><input type='password' size='20' name='log_pass' id='log_pass'/></td></tr>

          <tr><td colspan='2'><input type='submit' value='Log In' id="submit"/></td></tr>
        </table>
      </form>
      
      <p>To login as Admin, use username "theboss" and password "theboss".<br><br>
      To login as an Instructor, use username "(teacher full name)" where the teacher full
      name is any teacher name from a class on the class list (which can be viewed by logging
      in as Admin) and password "temp".<br><br>
      To login as an applicant, just register a new user.</p>
    </div>

  </div>
  </body>
</html>
