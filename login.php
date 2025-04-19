<?php
ob_start(); // Start output buffering
session_start();
include 'database.php'; // Ensure correct DB connection

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.html");
    exit();
}

$username = trim($_POST['admission_number']);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Username or Password cannot be empty!';
    header("Location: index.html");
    die();
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($user && $user['password'] === $password) {  
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = trim(strtolower($user['role']));


    if ($_SESSION['role'] === 'student') {
        header("Location: student_dashboard.php");
        exit();
    }elseif ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    }
    
} else {
    echo "<script>alert('Invalid Username or Password!...Try again..')</script>";
    header("Location: index.html");
    exit();
}

$conn->close();
ob_end_flush(); // Flush output buffer
?>