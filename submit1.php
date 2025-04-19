<?php
session_start();
include("database.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Check if the uploads directory exists, if not, create it
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create the directory with full permissions
    }

    $photo_path = $upload_dir . basename($photo_name);

    if (move_uploaded_file($photo_tmp, $photo_path)) {
        // Insert data into the database
        $query = "INSERT INTO hallticket_requests (
            admission_no, name, father_name, regulation, course, branch, semester, exam_type, supplementary_subjects, photo_path, status
        ) VALUES (
            '$admission_no', '$name', '$father_name', '$regulation', '$course', '$branch', '$semester', '$exam_type', '$supplementary_subjects', '$photo_path', 'pending'
        )";

        if ($conn->query($query)) {
            echo "<script>alert('Hallticket request submitted successfully. Please wait for admin approval.'); window.location.href = 'index.html';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading photo. Please check the uploads directory permissions.";
    }

    $conn->close();
}
?>