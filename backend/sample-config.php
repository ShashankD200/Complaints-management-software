<?php
    // This file is a sample config file for github deployment
    // real config file name must be config.php and it must be in the same location
    date_default_timezone_set('Asia/Kolkata');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "";
    
    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);
   
    // Die if connection was not successful
   
    if (!$conn){
        die("Sorry we failed to connect: ". mysqli_connect_error());
    }
?>