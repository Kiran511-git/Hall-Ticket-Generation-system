<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'database.php';

// 1. Check if the user is logged in (and is admin)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// 2. Handle Approve button
if (isset($_POST['approve'])) {
    $request_id = $_POST['request_id'];

    // Update the status to 'Approved'
    $updateQuery = "UPDATE hallticket_requests SET status = 'Approved' WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    if (!$stmt) {
        die("Error preparing query: " . $conn->error);
    }
    $stmt->bind_param("i", $request_id);

    if (!$stmt->execute()) {
        echo "Error approving request: " . $stmt->error;
    }
    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}

// 3. Handle Reject button
if (isset($_POST['reject'])) {
    $request_id = $_POST['request_id'];

    // Update the status to 'Rejected'
    $updateQuery = "UPDATE hallticket_requests SET status = 'Rejected' WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    if (!$stmt) {
        die("Error preparing query: " . $conn->error);
    }
    $stmt->bind_param("i", $request_id);

    if (!$stmt->execute()) {
        echo "Error rejecting request: " . $stmt->error;
    }
    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}

// 4. Fetch all requests with status 'Pending' from hallticket_requests
$query = "
    SELECT 
        id, 
        admission_no, 
        name, 
        course, 
        branch, 
        semester, 
        photo_path, 
        status 
    FROM 
        hallticket_requests 
    WHERE 
        status = 'Pending'
";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Error fetching result: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/HallTicket(NEW v2)/css/admin_dashboard.css">
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
    <div class="admin-dashboard">
    <h2>Admin Dashboard</h2>
    <h2>Admin Panel - Approve/Reject Hall Ticket Requests</h2>

    <div class="requests-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="request-container">
                    <form method="POST">
                        <!-- Display student details -->
                        <p><strong>Admission Number:</strong> <?php echo htmlspecialchars($row['admission_no']); ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                        <p><strong>Course:</strong> <?php echo htmlspecialchars($row['course']); ?></p>
                        <p><strong>Branch:</strong> <?php echo htmlspecialchars($row['branch']); ?></p>
                        <p><strong>Semester:</strong> <?php echo htmlspecialchars($row['semester']); ?></p>
                        <p><strong>Photo:</strong> <img src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="Student Photo"></p>

                        <!-- Hidden field to identify which request is being approved/rejected -->
                        <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">

                        <button type="submit" name="approve">Approve</button>
                        <button type="submit" name="reject">Reject</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-requests">No pending hall ticket requests.</p>
        <?php endif; ?>
    </div>

    <a href="logout.php" class="logout-link">Logout</a>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>