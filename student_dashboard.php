<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Check if the user has already requested a hall ticket
$query = "SELECT * FROM hallticket_requests WHERE user_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}
$result = $stmt->get_result();
$hall_ticket = $result->fetch_assoc();
$stmt->close();

// Handle hall ticket request submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_ticket'])) {
    if (!$hall_ticket) {
        $insertQuery = "INSERT INTO hallticket_requests (user_id, status) VALUES (?, 'Pending')";
        $insertStmt = $conn->prepare($insertQuery);
        if (!$insertStmt) {
            die("Error preparing insert query: " . $conn->error);
        }
        $insertStmt->bind_param("i", $user_id);
        if ($insertStmt->execute()) {
            header("Location: student_dashboard.php");
            exit();
        } else {
            echo "Error requesting hall ticket: " . $insertStmt->error;
        }
        $insertStmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="/HallTicket(NEW v2)/css/student_dashboard.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="jntua-logo"><img id="jnt-logo" src="jntuacea-logo.png" alt="jntuacea-logo"></div>
            <div class="jntua-name">
                <h2 id="jntu-name">JNTUA College of Engineering (Autonomous) Ananthapuramu</h2>
                <p id="jntu-address">Sri Mokshagundam Vishveshwaraiah Road,Ananthapuram,Andhra Pradesh-515002, India.</p>
                <p id="jntu-iso">An ISO 9001:2015 Certified Institution</p>
            </div>
            <div class="naac-logo"><img id="jnt-naac" src="jntuacea-naac.png" alt="NAAC-logo"></div>
        </div>
    </header>
    <h2 id="dashboard">Student Dashboard</h2>
    <p>Logged in as: <strong><?php echo htmlspecialchars($username); ?></strong></p>

    <?php if (!$hall_ticket): ?>
        <form method="POST">
            <a href="hallticket-dashboard.html" name="request_ticket" class="btn">Request Hall Ticket</a>
        </form>
    <?php else: ?>
        <p>Hall Ticket Status: <span class="status"><?php echo htmlspecialchars($hall_ticket['status']); ?></span></p>
        <?php if (strtolower(trim($hall_ticket['status'])) === 'approved'): ?>
            <a href="download_hallticket.php?id=<?php echo $hall_ticket['id']; ?>" class="btn" target="_self">Download Hall Ticket</a>
        <?php elseif (strtolower(trim($hall_ticket['status'])) === 'rejected'): ?>
            <p>Your hall ticket request has been <span class="status" style="color:red;">Rejected</span>.</p>
        <?php else: ?>
            <p>Your request is still <span class="status" style="color:orange;">Pending</span>.</p>
        <?php endif; ?>
    <?php endif; ?>

    <p><a href="logout.php" class="logout-link">Logout</a></p>
</body>
</html>

<?php
$conn->close();
?>