<?php
session_start();

// Check if the tutor is logged in
if (!isset($_SESSION['email'])) {
    header("Location: tutor_login.php");
    exit;
}

$email = $_SESSION['email'];
$conn = new mysqli("localhost", "root", "", "students_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the tutor's class, department, and year from the session
$class = $_SESSION['class'];  // Example: "a"
$department = $_SESSION['department'];  // Example: "it"
$year = $_SESSION['year'];  // Example: "4"

// Build the table name dynamically based on class, department, and year
$tutor_class = strtolower($class) . "_" . strtolower($department) . "_" . $year;
$table_name = strtolower($tutor_class); // Example: a_it_4

// Fetch leave applications and join with the relevant student table to get the student name
$sql = "SELECT la.*, s.student_name AS student_name 
        FROM leave_applications la
        JOIN $table_name s ON la.register_number = s.register_number
        WHERE la.class = '$class'
        AND la.department = '$department'
        AND la.year = '$year'
        ORDER BY la.applied_date DESC";

$result = $conn->query($sql);

// Error handling for the query
if (!$result) {
    die("Error retrieving leave applications: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Dashboard</title>
    <style>
        body {
            text-align: center;
            font-family: sans-serif;
            color: #0a304a;
            font-size: 25;
            padding: 100px;
            background-image: url("pics/pagenonamebg.jpg");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 25px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        h2 {
            font-size: 45px;
        }
        img {
            width: 100px; /* Adjust as needed */
        }
        /* Default size of the image */
    .hover-image {
        width: 100px; /* Adjust the default size */
        transition: transform 0.3s ease; /* Smooth transition effect */
    }

    /* Enlarge the image on hover */
    .hover-image:hover {
        transform: scale(15); /* Enlarge to 200% */
        z-index: 999; /* Ensure the image is on top of other elements */
    }
        .approved {
            background-color: #68de5b;
            font-weight: bold;
        }
        .rejected {
            background-color: #de5b62;
            font-weight: bold;
        }
        .pending {
            background-color: #e08a4c;
            font-weight: bold;
        }



    </style>
</head>
<body>
    <h1>Tutor Dashboard</h1>
    <table>
        <tr>
            <th>Leave ID</th>
            <th>Register Number</th>
            <th>Student Name</th>
            <th>Reason for Leave</th>
            <th>Attendance percentage</th>
            <th>Leave From</th>
            <th>Leave To</th>
            <th>Applied Date</th>
            <th>Number of Days</th>
            <th>Image</th>
            <th>Tutor Comments</th>
            <th>Tutor Status</th>
            <th>Action</th>
            <th>HOD Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tutor_status_class = "";
            if ($row["tutor_status"] == "Approved") {
                $tutor_status_class = "approved";
            } elseif ($row["tutor_status"] == "Rejected") {
                $tutor_status_class = "rejected";
            } else {
                $tutor_status_class = "pending"; // If it's pending
            }

            // Assign class based on hod_status
            $hod_status_class = "";
            if ($row["hod_status"] == "Approved") {
                $hod_status_class = "approved";
            } elseif ($row["hod_status"] == "Rejected") {
                $hod_status_class = "rejected";
            } else {
                $hod_status_class = "pending"; // If it's pending
            }
                $image_path = isset($row['image_path']) ? $row['image_path'] : 'default_image.png';
                echo "<tr>
                        <td>{$row['leave_id']}</td>
                        <td>{$row['register_number']}</td>
                        <td>{$row['student_name']}</td>
                        <td>{$row['reason']}</td>
                        <td>{$row['attendance_percentage']}</td>
                        <td>{$row['leave_from']}</td>
                        <td>{$row['leave_to']}</td>
                        <td>{$row['applied_date']}</td>
                        <td>{$row['number_of_days']}</td>
                        <td><img src='$image_path' alt='Leave Image' class='hover-image'></td>
                        <td>{$row['tutor_comments']}</td>
                        <td class='$tutor_status_class'>{$row['tutor_status']}</td>
                        <td>
                            <form action='process_leave_action.php' method='POST'>
                                <input type='hidden' name='leave_id' value='{$row['leave_id']}'>
                                
                                <label>
                                    <input type='radio' name='tutor_status' value='Approved' required> Approve
                                </label>
                                <label>
                                    <input type='radio' name='tutor_status' value='Rejected' required> Reject
                                </label>

                                <br><br>
                                <textarea name='tutor_comments' placeholder='Enter comments here...'></textarea><br><br>
                                <input type='submit' value='Submit'>
                            </form>
                        </td>
                        <td class='$hod_status_class'>{$row['hod_status']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='13'>No leave applications found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>