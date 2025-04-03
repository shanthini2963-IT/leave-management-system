<?php
session_start();

// Check if the HOD is logged in
if (!isset($_SESSION['hod_id'])) {
    header("Location: hod_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "students_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch leave applications pending HOD approval
//$sql = "SELECT * FROM leave_applications WHERE hod_status = 'Pending'";
$sql = "SELECT * FROM leave_applications 
        WHERE tutor_status = 'Approved' 
        AND hod_status = 'Pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOD Dashboard</title>
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
    <h1>HOD Dashboard</h1>

    <table>
        <tr>
            <th>Leave ID</th>
            <th>Register Number</th>
            <th>Student Name</th>
            <th>Reason</th>
            <th>Leave From</th>
            <th>Leave To</th>
            <th>Applied Date</th>
            <th>Total days</th>
            <th>Tutor Comments</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['leave_id']}</td>
                    <td>{$row['register_number']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['reason']}</td>
                    <td>{$row['leave_from']}</td>
                    <td>{$row['leave_to']}</td>
                    <td>{$row['applied_date']}</td>
                    <td>{$row['number_of_days']}</td>
                    <td>{$row['tutor_comments']}</td>
                    <td>
                        <form action='hod_approve.php' method='POST'>
                            <input type='hidden' name='leave_id' value='{$row['leave_id']}'>
                            <label>
                                <input type='radio' name='hod_status' value='Approved' required> Approve
                            </label>
                            <label>
                                <input type='radio' name='hod_status' value='Rejected' required> Reject
                            </label>
                            <textarea name='hod_comments' placeholder='Enter comments here...'></textarea><br><br>
                            <input type='submit' value='Submit'>
                        </form>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No leave applications found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
