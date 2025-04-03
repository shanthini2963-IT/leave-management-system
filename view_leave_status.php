<?php
session_start();

if (!isset($_SESSION['register_number'])) {
    die("Error: Not logged in.");
}

$register_number = $_SESSION['register_number'];

$conn = new mysqli("localhost", "root", "", "students_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch leave applications for the student
$sql = "SELECT * FROM leave_applications WHERE register_number = '$register_number'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Leave Status</title>
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
    <h2>View Leave Status</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Leave ID</th>
                    <th>Register Number</th>
                    <th>Reason</th>
                    <th>Leave From</th>
                    <th>Leave To</th>
                    <th>Applied Date</th>
                    <th>Number of Days</th>
                    <th>Tutor Comments</th>
                    <th>HOD Comments</th>
                    <th>Tutor status</th>
                    <th>HOD status</th>
                </tr>";

        while($row = $result->fetch_assoc()) {
            // Format the applied_date
            $applied_date = date("Y-m-d", strtotime($row["applied_date"]));
            // Assign class based on tutor_status
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

/*
reason
attendance_percentage
leave_from
leave_to
number_of_days
applied_date
tutor_comments
hod_comments
tutor_status
hod_status
status*/
            echo "<tr>
                    <td>" . $row["leave_id"] . "</td>
                    <td>" . $row["register_number"] . "</td>
                    <td>" . $row["reason"] . "</td>
                    <td>" . $row["leave_from"] . "</td>
                    <td>" . $row["leave_to"] . "</td>
                    <td>" . $applied_date . "</td>
                    <td>" . $row["number_of_days"] . "</td>
                    <td>" . $row["tutor_comments"] . "</td>
                    <td>" . $row["hod_comments"] . "</td>
                    <td class='$tutor_status_class'>" . $row["tutor_status"] . "</td>
                    <td class='$hod_status_class'>" . $row["hod_status"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No leave applications found.";
    }

    $conn->close();
    ?>

</body>
</html>