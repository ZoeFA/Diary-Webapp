<?php
#logs the user out
#Links to login.php

session_start();

if(isset($_GET['logout'])){
  session_destroy();
  header('location:login.php');
}
?>