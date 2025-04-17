<?php
# This page processes the user input upon clicking the signup button
# It checks if fields are empty and if the passwords match.
# Linked to: connection_db.php, home.php

require_once('connection_db.php');
session_start();

if(isset($_POST['Register'])){
    $send_username = $_POST['Username'];
    $send_password = $_POST['Password'];
    $re_password = $_POST['Re_Password'];

    # Store the username in session to persist form data
    $_SESSION['Username'] = $send_username;

    # Check if any fields are empty
    if (empty($send_username) || empty($send_password) || empty($re_password)) {
        header('location:signup_input.php?Empty=Please fill all the fields');
    } 
    else {
        # Check if passwords match
        if ($send_password === $re_password) {
            # Check if the user already exists
            $query = mysqli_query($con, "SELECT * FROM journaldb.users WHERE Username='$send_username'");

            if (mysqli_num_rows($query) > 0) {
                header('location:signup_input.php?User=That username is already taken!');
            } 
            else {
                # Prepare and execute the SQL statement to insert the new user
                $sql = "INSERT INTO journaldb.users (Username, Password) VALUES ('$send_username', '$send_password')";

                # Check if the query was successful
                if ($con->query($sql) === TRUE) {
                    $_SESSION['User'] = $send_username;
                    header('location:home.php');  # Redirect to home page after successful registration
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $con->error;
                }
            }
        } 
        else {
            # If passwords don't match
            header('location:signup_input.php?Invalid=Re-typed password does not match');
        }
    }
} 
else {
    echo 'Error: Not Working';
}
?>
