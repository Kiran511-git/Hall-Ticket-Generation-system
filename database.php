<?php
$servername = "localhost"; // Change if using a different host
$dbusername = "root"; // Change to your database username
$dbpassword = ""; // Set your database password if any
$dbname = "hallticket"; // Change to your actual database name

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
