<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bitescan";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>