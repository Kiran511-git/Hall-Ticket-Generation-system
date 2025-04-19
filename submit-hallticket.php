<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php';

// Ensure student is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: Student not logged in.");
}
$student_id = $_SESSION['user_id'];

// Check if form is submitted
if (isset($_POST['submit_request'])) {
    // Retrieve form data
    $admission_no = $_POST['s-admi'];
    $name = $_POST['s-name'];
    $father_name = $_POST['f-name'];
    $regulation = $_POST['exam-reg'];
    $course = $_POST['s-course'];
    $branch = $_POST['s-branch'];
    $semester = $_POST['s-sem'];
    $exam_type = $_POST['exam-type'];
    $supplementary_subjects = isset($_POST['supplementary-subjects']) ? implode(", ", $_POST['supplementary-subjects']) : "";

    // Handle file upload
    $photo_name = $_FILES['s-photo']['name'];
    $photo_tmp = $_FILES['s-photo']['tmp_name'];
    $upload_dir = "uploads/";

    // Create uploads directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $photo_path = $upload_dir . basename($photo_name);

    if (move_uploaded_file($photo_tmp, $photo_path)) {
        // Prepare the INSERT query including the student_id
        $query = "INSERT INTO hallticket_requests (
            user_id, admission_no, name, father_name, regulation, course, branch, semester, exam_type, supplementary_subjects, photo_path, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($query)) {
            $status = 'pending';
            // Bind parameters:
            // "i" for integer (student_id), "s" for strings.
            $stmt->bind_param("issssssissss", 
                $student_id, 
                $admission_no, 
                $name, 
                $father_name, 
                $regulation, 
                $course, 
                $branch, 
                $semester, 
                $exam_type, 
                $supplementary_subjects, 
                $photo_path, 
                $status
            );
            
            if ($stmt->execute()) {
                echo "<script>alert('Hallticket request submitted successfully. Please wait for admin approval.'); window.location.href = 'student_dashboard.php';</script>";
            } else {
                echo "Error executing statement: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Error uploading photo. Please check the uploads directory permissions.";
    }
}

$conn->close();
?>
