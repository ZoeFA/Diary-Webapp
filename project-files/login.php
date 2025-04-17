<?php
#User can log in if they already have an account

#Connecting to database
$con = mysqli_connect("localhost", "root", "", "journaldb");

  if($con-> connect_error){

    die("Connection failed:" . $con-> connection_error);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login_style.css">
  
</head>
<body>

  <div id="content">

    <!--logo image-->
    <img id="logo" src="logo.png" alt="site logo, image of a key with the words Secret Journal on top">

    <h1>Login To Unlock Your Secret Journal!</h1>

    <top></top>
    <form method="post" action="processing_input.php">
      <label>Username</label><br>
      <input type="text" name="Username"><br>
      <label>Password</label><br>
      <input type="password" name="Password"><br>
      <button id="button" name="Login">Login</button><br><br>


      <?php
        if (isset($_GET['Empty'])) {
          echo "<p style='color:red'>" . $_GET['Empty'] . "</p>";

        } elseif (isset($_GET['Invalid'])) {
          echo "<p style='color:red'>" . $_GET['Invalid'] . "</p>";
        }
      ?>

        <a href="signup_input.php">Don't have an account? Click here to Sign up today</a><br>

    </form>
    <bottom></bottom>

    <footer>
      <p>
        All cursor, logo, font assets used in this website are copyright free.
        Website created by Zoe Fabre-Anderson 2024
      </p>
    </footer>

  </div>
  
</body>
</html>