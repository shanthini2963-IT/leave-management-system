<?php
session_start();

if (!isset($_POST['leave_id']) || !isset($_POST['tutor_status']) || !isset($_POST['tutor_comments'])) {
    header("Location: tutor_dashboard.php");
    exit;
}

$leave_id = $_POST['leave_id'];
$tutor_status = $_POST['tutor_status'];
$tutor_comments = $_POST['tutor_comments'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "students_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the leave application status and comments
$sql = "UPDATE leave_applications 
        SET tutor_status = ?, tutor_comments = ? 
        WHERE leave_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $tutor_status, $tutor_comments, $leave_id);

if ($stmt->execute()) {
    echo "Leave application updated successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: tutor_dashboard.php");
exit;
?>