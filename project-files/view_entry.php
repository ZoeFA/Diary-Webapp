<?php
#This file displays the information of the specific journal entry

require_once('connection_db.php');
session_start();

$journalID = intval($_GET['id']);

#fetch journal entries
$query = "SELECT Title, Entry_Date, Entry_Text, Entry_Image FROM journaldb.journalentries WHERE JournalID = ?";
$stat = $con->prepare($query);
$stat->bind_param("i", $journalID);
$stat->execute();
$result = $stat->get_result();

if($result->num_rows == 1){
  $entry = $result->fetch_assoc();

}
else{
  echo "Entry not found";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Journal Entry Details</title>
  <link rel="stylesheet" href="view_style.css">
</head>
<body>
  
  <header>
    <a href="home.php">Back to Home</a>
    <h1><strong></strong> <?php echo htmlspecialchars($entry['Entry_Date']); ?></h1>
    <h2><strong>Tile:</strong> <?php echo htmlspecialchars($entry['Title']); ?></h2>
  </header><br>
  
  
  <p><strong>Today...</strong> <?php echo nl2br(htmlspecialchars($entry['Entry_Text'])); ?></p><br>

  <?php if (!empty($entry['Entry_Image'])): ?>
    
    <img src="view_image.php?id=<?php echo $journalID; ?>" alt="Journale Image" style="max-width: 500px; height: auto;">
  <?php else: ?>
    <p>No image available</p>
  <?php endif; ?>
  
  <footer>
    
    <p>
        All cursor, logo, font assets used in this website are copyright free.
        Website created by Zoe Fabre-Anderson 2024
    </p>
  </footer>
  
</body>
</html>