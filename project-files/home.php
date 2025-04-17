<?php
#This is the home page of th user. It is unique to each user as the
#journal entries of the specific logged in user are displayed
#Links to viewentry.php
#echo 'welcome to home';
require_once('connection_db.php');
session_start();
#can only access this if logged in
if(isset($_SESSION['User'])){

}
else{
  #cant access this page unless logged in(redirect to login page)
  header('location:login.php');
  #add popup message explaing to user***
}


#get username from session
if(isset($_SESSION['User']))
{
  // obtaining username if user logged in or user registered
  if(isset($_SESSION['Username']))
  {
    $username = $_SESSION['Username'];
  }
  elseif(isset($_SESSION['User']))
  {
    $username = $_SESSION['User'];
  }

}

#fetch userID from the database useing session username
$query = "SELECT UserID FROM users WHERE Username = ?";
$stat = $con->prepare($query);
$stat->bind_param("s", $username);
$stat->execute();
$result = $stat->get_result();

if($result->num_rows == 1){
  #get userID from the result
  $row = $result->fetch_assoc();
  $userID = $row['UserID'];

}
else{
  echo "User not found";
  exit;
}

#fetching journal entries for the user
$jquery = "SELECT JournalID, Title, Entry_Date, Entry_Text, Entry_Image FROM journaldb.journalentries
            WHERE UserID = ?";

$stat = $con->prepare($jquery);
$stat->bind_param("i", $userID);
$stat->execute();
$jentries = $stat->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($username); ?>'s Journal</title>
  <link rel="stylesheet" href="home_style.css">

</head>
<body>
      
  <header>
    <h1><?php echo htmlspecialchars($username); ?>'s Journal</h1><br>

    <div>
      <a href="logout.php?logout" class="logout-link">Logout</a>
      <a href="add_entry.php" class="floating-button">Add a new entry</a>
    
    </div>
  </header><br>


  <div class="card-container">

    <?php
      if ($jentries->num_rows > 0){

        #loop through each journal entry and display it as a card
        while($entry = $jentries->fetch_assoc()){
          ?>
          <div class="card" onclick="window.location.href='view_entry.php?id=<?php echo htmlspecialchars($entry['JournalID']); ?>'">

            <img src="view_image.php?id=<?php echo htmlspecialchars($entry['JournalID']); ?>" alt="Journal Image">
            <div class="card-content">
              <p class="card-title">
                <?php echo htmlspecialchars($entry['Title']); ?>
              </p>
              <p class="card-date">
                <?php echo htmlspecialchars($entry['Entry_Date']); ?>
              </p>
            </div>

            <form method="post" action="delete_entry.php" onsubmit="return confirm('Are you sure you want to delete this entry?');">
              <input type="hidden" name="journal_id" value="<?php echo htmlspecialchars($entry['JournalID']); ?>">
              <button type="submit" class="delete-button">Delete</button>
            </form>
          </div>

          <?php
        }
      }
      else{
        echo "<p>No journal entries found</p>";
      }
      ?>

  </div>

  <footer>
      <p>
        All cursor, logo, font assets used in this website are copyright free.
        Website created by Zoe Fabre-Anderson 2024
      </p>
  </footer>
  

</body>
</html>