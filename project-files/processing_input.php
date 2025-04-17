<?php

#This file processes the login information that the user inputs
#links to connection_db.php and home.php

require_once('connection_db.php');
session_start();

  if(isset($_POST['Login'])){

    if(empty($_POST['Username']) || empty($_POST['Password'])){

      header("location:login.php?Empty=Username and or Password is empty");

    }
    else{
      $query = "SELECT * FROM journaldb.users WHERE Username='".$_POST['Username']."' AND Password='".$_POST['Password']."'";
      $result = mysqli_query($con, $query);

      #if credientials are correct, make a session
      if(mysqli_fetch_assoc($result)){
        $_SESSION['User'] = $_POST['Username'];
        header('location:home.php');
      }
      else{
        #if credentials are incorrect
        header("location:login.php?Invalid= Please enter correct username and password");

      }
    }
  }
  else{
    echo 'Error: processing_input.php not working';
  }

?>