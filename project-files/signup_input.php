<?php
# This file collects the user's sign-up information and sends it
# to the signup.php page for error checking and user creation.
# Linked with: signup.php, connection_db.php, login.php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="login_style.css">
  
</head>
<body>
  <div id="content">
  
  <img id="logo" src="logo.png" alt="site logo, image of a key with the words Secret Journal on top">
  <h1>Sign Up</h1>



  <form method="post" action="signup.php">
    <!-- Error handling for empty fields -->
    <?php if(isset($_GET['Empty'])): ?>
      <p style="color:red"><?php echo $_GET['Empty']; ?></p>
    <?php endif; ?>

    <!-- Error handling for password mismatch -->
    <?php if(isset($_GET['Invalid'])): ?>
      <p style="color:red"><?php echo $_GET['Invalid']; ?></p>
    <?php endif; ?>

    <!-- Error handling for existing username -->
    <?php if(isset($_GET['User'])): ?>
      <p style="color:red"><?php echo $_GET['User']; ?></p>
    <?php endif; ?>

    <!-- Form Fields -->
    <label>Username</label><br>
    <input type="text" name="Username" value="<?php echo isset($_SESSION['Username']) ? $_SESSION['Username'] : ''; ?>"><br>

    <label>Password</label><br>
    <input type="password" name="Password"><br>

    <label>Re-Type Password</label><br>
    <input type="password" name="Re_Password"><br>

    <button id="button" type="submit" name="Register">Create Account</button><br><br>

    <a href="login.php">Already have an account? Login here!</a><br>
  </form>


  <footer>
      <p>
        All cursor, logo, font assets used in this website are copyright free.
        Website created by Zoe Fabre-Anderson 2024
      </p>
  </footer>
  </div>

  
</body>
</html>
