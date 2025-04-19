<?php
session_start();
include("database.php");

// Ensure only admins can access this page
if ($_SESSION["role"] != "admin") {
    header("Location: index.html");
    exit();
}

$id = $_GET['id']; // Get the request ID from the URL

// Update the status to 'rejected'
$query = "UPDATE hallticket_requests SET status = 'rejected' WHERE id = $id";
if ($conn->query($query)) {
    echo "<script>alert('Request rejected successfully.'); window.location.href = 'admin_dashboard.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>