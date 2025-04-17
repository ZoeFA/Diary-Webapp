<?php
#this file handles the deletion of a specific journal entry
#based on the JournalID and UserID.
#The user is then redirected to the home page again
#Links to connection_db.php, home.php

require_once('connection_db.php');
session_start();

if(isset($_SESSION['User'])){

}
else{
  #cant do this action unless logged in(redirect to login page)
  header('location:login.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['journal_id'])){

  $journalID = $_POST['journal_id'];

  #fetch userID of the sessioned user
  $username = $_SESSION['User'];
  $query = "SELECT UserID FROM users WHERE Username =?";
  $stat = $con->prepare($query);
  $stat->bind_param("s", $username);
  $stat->execute();
  $result = $stat->get_result();


  if($result->num_rows ==1){
    $row = $result->fetch_assoc();
    $userID = $row['UserID'];

    #Delete journal entry only if it is that specific user's
    #Extra protection
    $deleteQuery = "DELETE FROM journaldb.journalentries WHERE journalID = ? AND UserID = ?";
    $delstat = $con->prepare($deleteQuery);
    $delstat->bind_param("ii", $journalID, $userID);
    $delstat->execute();


    #after deleting, redirect to home page
    header('Location: home.php');
    exit();

  }
  else{
    echo "User not found";
    exit();
  }
}
else{
  echo "Invalid request";
  exit();
}
?>