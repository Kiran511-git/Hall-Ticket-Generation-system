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

// Get the hall ticket ID from the query parameter
if (!isset($_GET['id'])) {
    die("Invalid request.");
}
$hall_ticket_id = $_GET['id'];

// Fetch hall ticket details
$query = "SELECT * FROM hallticket_requests WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}
$stmt->bind_param("ii", $hall_ticket_id, $_SESSION['user_id']);
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}
$result = $stmt->get_result();
$hall_ticket = $result->fetch_assoc();
$stmt->close();

if (!$hall_ticket || strtolower(trim($hall_ticket['status'])) !== 'approved') {
    die("Hall ticket not found or not approved.");
}

// Fetch student details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error preparing query: " . $conn->error);
}
$stmt->bind_param("i", $_SESSION['user_id']);
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    die("Student details not found.");
}

// Fetch subjects based on exam type
$subjects = [];
if ($hall_ticket['exam_type'] === 'Regular') {
    $query = "SELECT subject_name FROM subjects WHERE regulation = ? AND course = ? AND branch = ? AND semester = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi",  $hall_ticket['regulation'],$hall_ticket['course'],$hall_ticket['branch'], $hall_ticket['semester']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row['subject_name'];
    }
    $stmt->close();
} else {
    // Fetch supplementary subjects from the hall_ticket_requests table
    $subjects = explode(",", $hall_ticket['supplementary_subjects']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall Ticket</title>
    <link rel="stylesheet" href="/HallTicket(NEW v2)/css/submit-style.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="jntua-logo"><img id="jnt-logo" src="jntuacea-logo.png" alt="jntuacea-logo"></div>
            <div class="jntua-name">
                <h2 id="jntu-name">JNTUA College of Engineering (Autonomous) Ananthapuramu</h2>
                <p id="jntu-address">Sri Mokshagundam Vishveshwariah Road,Ananthapuram,Andhra Pradesh-515002, India.</p>
                <p id="jntu-iso">An ISO 9001:2015 Certified Institution</p>
            </div>
            <div class="naac-logo"><img id="jnt-naac" src="jntuacea-naac.png" alt="NAAC-logo"></div>
        </div>
    </header>
    <div class="main-container" id="section-to-be-printed">
        <div class="container" style='background-image:url("jntuacea-opacity.png"); background-repeat:no-repeat; background-position:center'>
            <div class="name">
                <div class="clg-name">
                    <p style="font-size:1.3rem"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JAWAHARLAL NEHRU TECHNOLOGICAL UNIVERSITY <br>COLLEGE OF ENGINEERING (AUTONOMOUS), ANANTHAPURAMU</strong></p>
                </div>
                <div class="hall-ticket">
                    <p>HALL TICKET</p>
                    <p>(ORIGINAL)</p>
                </div>
            </div>
            <div class="course-exam">
                <div class="branch text-size">
                    <strong>Registration form for</strong><br>
                    <p value=""><strong>Course : </strong><?php echo htmlspecialchars($hall_ticket['course'] ?? 'N/A'); ?></p>
                </div>
                <div class="exam-details text-size">
                    <div class="sem"><strong>Semester :</strong> <?php echo htmlspecialchars($hall_ticket['semester'] ?? 'N/A'); ?></div>
                    <div class="admissionNo"><strong>H.T NO :</strong><?php echo htmlspecialchars($hall_ticket['admission_no'] ?? 'N/A'); ?></div>
                </div>
            </div>
            <div class="hallTicket-info text-size">
                <div class="details">
                    <table>
                        <tr><td><strong>Name:</strong> <?php echo htmlspecialchars($hall_ticket['name'] ?? 'N/A'); ?></td></tr>
                        <tr><td><strong>Father's Name:</strong> <?php echo htmlspecialchars($hall_ticket['father_name'] ?? 'N/A'); ?></td></tr>
                        <tr><td><strong>Regulation:</strong> <?php echo htmlspecialchars($hall_ticket['regulation'] ?? 'N/A'); ?></td></tr>
                        <tr><td><strong>Branch:</strong> <?php echo htmlspecialchars($hall_ticket['branch'] ?? 'N/A'); ?></td></tr>
                        <tr><td><strong>Exam Type:</strong> <?php echo htmlspecialchars($hall_ticket['exam_type'] ?? 'N/A'); ?></td></tr>
                    </table>
                </div>
                <div class="photo">
                    <img src="<?php echo htmlspecialchars($hall_ticket['photo_path'] ?? ''); ?>" width="150px" height="180px" alt="Candidate Photo">
                </div>
            </div>

            <div class="subjects text-size">
                <p><strong>Subjects:</strong></p>
                <ul>
                    <?php foreach ($subjects as $subject) { ?>
                        <li><?php echo htmlspecialchars($subject); ?></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="signatures text-size">
                <div class="OAS">O.A.S</div>
                <div class="viceP">Vice Principal</div>
                <div class="princ">Principal</div>
            </div>
        </div>
    </div>

    <div class="btn">
        <button type="submit" onclick="window.print()">Download</button>
        <a href="student_dashboard.php" class="back-btn">Back</a>
    </div>
</body>
</html>