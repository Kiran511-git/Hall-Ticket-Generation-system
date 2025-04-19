<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("database.php");

// Get request parameters
$regulation = $_REQUEST['regulation'] ?? '';
$course = $_REQUEST['course'] ?? '';
$branch = $_REQUEST['branch'] ?? '';
$semester = $_REQUEST['semester'] ?? '';

// Validate input
if (empty($regulation) || empty($course) || empty($branch) || empty($semester)) {
    echo json_encode(["error" => "Missing required parameters"]);
    exit;
}

// Prepare SQL query
$sql = "SELECT subject_name FROM subjects 
        WHERE regulation = ? AND course = ? AND branch = ? AND semester = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare SQL statement: " . $conn->error]);
    exit;
}

// Bind parameters and execute query
$stmt->bind_param("ssss", $regulation, $course, $branch, $semester);
if (!$stmt->execute()) {
    echo json_encode(["error" => "Failed to execute SQL statement: " . $stmt->error]);
    exit;
}

// Fetch results
$result = $stmt->get_result();
$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row['subject_name'];
}

// Close statement and connection
$stmt->close();
$conn->close();

// Return subjects as JSON
echo json_encode(["subjects" => $subjects]);
?>
