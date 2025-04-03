<?php
session_start();

if (!isset($_SESSION['hod_id'])) {
    die("Error: Not logged in.");
}

$conn = new mysqli("localhost", "root", "", "students_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leave_id = $_POST['leave_id'];
    $hod_status = $_POST['hod_status'];
    $hod_comments = $_POST['hod_comments'];

    // Update the leave application status
    $stmt = $conn->prepare("UPDATE leave_applications SET hod_status = ?, hod_comments = ? WHERE leave_id = ?");
    $stmt->bind_param("ssi", $hod_status, $hod_comments, $leave_id);

    if ($stmt->execute()) {
        echo "Leave application {$hod_status} successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
header("Location: hod_dashboard.php");
$conn->close();
?>