<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['register_number'])) {
    header("Location: student_login.php");
    exit();
}

$register_number = $_SESSION['register_number'];
$class = $_SESSION['class']; // Ensure these session variables are set correctly after login
$department = $_SESSION['department'];
$year = $_SESSION['year'];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "students_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dynamically select the table based on class, department, and year
$table_name = strtolower($class) . "_" . strtolower($department) . "_" . $year;

// Fetch student details
$sql = "SELECT * FROM $table_name WHERE register_number = '$register_number'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Error: No student records found.");
}

$student = $result->fetch_assoc();

// Fetch leave applications
$leave_sql = "SELECT * FROM leave_applications WHERE register_number = '$register_number'";
$leave_result = $conn->query($leave_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <style>
        body {
            text-align: center;
            font-family: sans-serif;
            color: #0a304a;
            font-size: 25;
            background-image: url("pics/pagenonamebg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 200px;
            //background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
        }
        h1 {
            color: darkblue;
            font-size: 50px;
        }
        h2 {
            font-size: 30px;
        }
        p {
            font-size: 45px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 25px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($student['student_name']); ?></p>
        
        <h2>Apply for Leave</h2>
        <a href="apply_leave.php" class="btn">Apply Leave</a>
        
        <h2>View Leave Status</h2>
        <a href="view_leave_status.php" class="btn">View Status</a>
    </div>
</body>
</html>
