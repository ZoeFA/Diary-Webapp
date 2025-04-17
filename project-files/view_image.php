<?php
#to display the BLOB image from the database for each journal entry
require_once('connection_db.php');

if (isset($_GET['id'])) {
    $journalID = $_GET['id'];

    #fetch image data
    $query = "SELECT Entry_Image, Image_Extension FROM journaldb.journalentries WHERE JournalID = ?";
    $stat = $con->prepare($query);
    $stat->bind_param("i", $journalID);
    $stat->execute();
    $result = $stat->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $imageData = $row['Entry_Image'];
        $imageExtension = $row['Image_Extension'];

        if ($imageData) {
            #determine the mime type based on the file content
            $mimeType = '';

            switch(strtolower($imageExtension)){

                case 'jpg':
                case 'jpeg':
                    $mimeType = 'image/jpeg';
                    break;
                case 'png':
                    $mimeType ='image/png';
                    break;
                case 'gif':
                    $mimeType = 'image/gif';
                    break;
                default:
                    #default to binary stream if extension is unknown
                    $mimeType = 'application/octet-stream';
            }

            header("Content-Type: $mimeType");
            echo $imageData;
        } else {
            echo "No image available";
        }
    } else {
        echo "Image not found";
    }
} else {
    echo "No ID specified";
}
?>
