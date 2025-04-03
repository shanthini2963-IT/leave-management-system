<?php
session_start();
$conn = new mysqli("localhost", "root", "", "students_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['register_number'])) {
    echo "<script>alert('Please log in first.'); window.location.href='student_login.php';</script>";
    exit;
}

$register_number = $_SESSION['register_number'];
$class = $_SESSION['class']; // You should set this during login
$department = $_SESSION['department']; // You should set this during login
$year = $_SESSION['year']; // Assuming you also save the year in session

// Define the table name based on the class and department
$table_name = strtolower($class) . "_" . strtolower($department) . "_" . $year;

// Fetch student name from the dynamically created student table
$student_query = "SELECT student_name FROM $table_name WHERE register_number = '$register_number'";
$result = $conn->query($student_query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $student_name = $row['student_name'];
} else {
    echo "<script>alert('Student not found.'); window.location.href='student_dashboard.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $leave_from = $_POST['leave_from'];
    $leave_to = $_POST['leave_to'];
    $reason = $_POST['reason'];
    $attendance_percentage = $_POST['attendance_percentage'];
    $applied_date = date("Y-m-d H:i:s");

    // Date validation
    $start_date = new DateTime($leave_from);
    $end_date = new DateTime($leave_to);

    if ($end_date < $start_date) {
        echo "<script>alert('End date must be after start date.'); window.location.href='apply_leave.php';</script>";
        exit;
    }

    // Calculate number of days
    $interval = $start_date->diff($end_date);
    $number_of_days = $interval->days + 1; // Including the end date

    // Attendance validation
    if ($attendance_percentage < 75) {
        echo "<script>alert('Attendance percentage must be 75 or above to apply for leave.'); window.location.href='apply_leave.php';</script>";
        exit;
    }

    // Handle image upload
    $image_name = $_FILES['leave_image']['name'];
    $image_tmp_name = $_FILES['leave_image']['tmp_name'];
    $image_path = 'uploads/' . $image_name;

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true); // Create the 'uploads' directory if it doesn't exist
    }

    if (!move_uploaded_file($image_tmp_name, $image_path)) {
        echo "<script>alert('Failed to upload image.'); window.location.href='apply_leave.php';</script>";
        exit;
    }

    // Insert leave application data into the database
    $insert_query = "INSERT INTO leave_applications (register_number, student_name, class, department, year, reason, attendance_percentage, leave_from, leave_to, number_of_days, applied_date, status, image_path) 
                     VALUES ('$register_number', 
                             '$student_name', 
                             '$class', 
                             '$department', 
                             '$year',
                             '$reason',
                             '$attendance_percentage', 
                             '$leave_from', 
                             '$leave_to', 
                             '$number_of_days', 
                             '$applied_date', 
                             'Pending', 
                             '$image_path')";

    if ($conn->query($insert_query) === TRUE) {
        echo "<script>alert('Leave application submitted successfully!'); window.location.href='student_dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply Leave</title>
    <style>
        body {
            text-align: center;
            font-family: sans-serif;
            color: #0a304a;
            font-size: 25px;
            padding: 100px;
            background-image: url("pics/pagenonamebg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        form {
            max-width: 500px;
            margin: auto;
            padding: 16px;
            border-radius: 8px;
            font-size: 35px;
        }
        input[type="text"], input[type="date"], input[type="number"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 30px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 30px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        #number_of_days {
            font-weight: bold;
            color: #333;
        }
        h2 {
            font-size: 45px;
        }
        .form-textarea {
            width: 100%;
            padding: 12px;
            font-size: 10px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-sizing: border-box;
            margin-bottom: 16px;
            transition: border-color 0.3s;
        }
    </style>
</head>
<body>
    <h2>Apply for Leave</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="leave_from">Leave From:</label>
        <input type="date" id="leave_from" name="leave_from" required><br><br>

        <label for="leave_to">Leave To:</label>
        <input type="date" id="leave_to" name="leave_to" required><br><br>

        <p id="days_display"></p> <!-- To display the number of leave days -->

        <label for="attendance_percentage">Attendance Percentage:</label>
        <input type="number" id="attendance_percentage" name="attendance_percentage" min="0" max="100" required><br><br>

        <label for="reason">Reason for Leave:</label><br>
        <textarea id="reason" name="reason" rows="4" required></textarea><br><br>

        <label for="leave_image">Upload Leave Image:</label>
        <input type="file" id="leave_image" name="leave_image" accept="image/*" required><br><br>

        <input type="submit" value="Submit Leave Application">
    </form>
    <script>
        const leaveFromInput = document.getElementById('leave_from');
        const leaveToInput = document.getElementById('leave_to');
        const daysDisplay = document.getElementById('days_display');

        leaveFromInput.addEventListener('change', calculateDays);
        leaveToInput.addEventListener('change', calculateDays);

        function calculateDays() {
            const startDate = new Date(leaveFromInput.value);
            const endDate = new Date(leaveToInput.value);

            if (startDate && endDate && endDate >= startDate) {
                const timeDiff = endDate - startDate;
                const daysDiff = timeDiff / (1000 * 60 * 60 * 24) + 1; // Including the end date
                daysDisplay.textContent = 'Number of days: ' + daysDiff;
            } else {
                daysDisplay.textContent = '';
            }
        }
    </script>
</body>
</html>
