<?php
  require_once("connection_db.php");
  session_start();

  if(isset($_SESSION['User'])){

  }
  else{
    header('location:login.php');
  }

  $username = $_SESSION['User'];

  #fetch userID from the database using sessioned username
  $query = "SELECT UserID FROM users WHERE Username =?";
  $stat = $con->prepare($query);
  $stat->bind_param("s", $username);
  $stat->execute();
  $result = $stat->get_result();

  if($result->num_rows ==1){
    $row = $result->fetch_assoc();
    $userID = $row['UserID'];
  }
  else{
    echo "User not found";
    exit;
  }

  if($_SERVER['REQUEST_METHOD'] =='POST'){

    if(isset($_POST['title'], $_POST['entry_date'], $_POST['entry_text'])){

      $title = $_POST['title'];
      $entry_date = $_POST['entry_date'];
      $entry_text = $_POST['entry_text'];
      $image = $_FILES['image'];


      #validate data
      if(empty($title) || empty($entry_date) || empty($entry_text)) {
        echo "All fields are required.";
      }
      elseif(strlen($entry_text) > 1000){
        echo "Cannot exceed 1000 characters!";
      }
      else{
        $imageData = null;
        $imageExtension = null;
        if($image['error'] == UPLOAD_ERR_OK){
          $imageData = file_get_contents($image['tmp_name']);
          #to get file extension
          $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        }
        

      #insert new entry into the database
      $query = "INSERT INTO journaldb.journalentries (UserID, Title, Entry_Date, Entry_Text, Entry_Image, Image_Extension) VALUES (?, ?, ?, ?, ?, ?)";
      $stat = $con->prepare($query);
      $stat->bind_param("isssss", $userID, $title, $entry_date, $entry_text, $imageData, $imageExtension);
      $stat->execute();


      #redirect to home.php if successful insertion
      header('Location: home.php');
      exit;
      }
    }
    else{
      echo "Missing form data";
    } 
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Journal Entry</title>
  <link rel="stylesheet" href="add_style.css">
</head>
<body>
  

  <form action="add_entry.php" method="post" enctype="multipart/form-data">

    <p>
      <label for="title"><strong>Title:</strong></label>
      <input type="text" id="title" name="title" required>
    </p>

    <p>
      <label for="entry_date"><strong>Date:</strong></label>
      <input type="date" id="entry_date" name="entry_date" required>
    </p>

    <p>
      <label for="entry_text">Dear Journal, Today...</label>
      <textarea name="entry_text" id="entry_text" cols="50" rows="5" maxlength="1000" required></textarea>
    </p>

    <p>
      <label for="image"><strong>Image (Optional):</strong></label>
      <input type="file" id="image" name="image" accept="image/*">
    </p><br>

    <button type="submit" class="custom-post-button">Post</button>

  </form>

  <a href="home.php">Back to Home</a>

  <footer>
    
    <p>
        All cursor, logo, font assets used in this website are copyright free.
        Website created by Zoe Fabre-Anderson 2024
    </p>
  </footer>

</body>
</html>