<?php
session_start();
include("database.php");

// Ensure only admins can access this page
if ($_SESSION["role"] != "admin") {
    header("Location: index.html");
    exit();
}

$id = $_GET['id']; // Get the request ID from the URL

// Update the status to 'approved'
$query = "UPDATE hallticket_requests SET status = 'approved' WHERE id = $id";
if ($conn->query($query)) {
    echo "<script>alert('Request approved successfully.'); window.location.href = 'admin_dashboard.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>