<?php
# Connecting Database to website
$con = mysqli_connect("localhost", "root", "", "journaldb");
  if ($con-> connect_error)
    {
      die("Connection failed:" . $con-> connection_error);
    }
?>