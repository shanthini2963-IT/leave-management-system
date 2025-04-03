<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $register_number = $_POST['register_number'];
    $dob = $_POST['dob'];
    $class = $_POST['class'];
    $department = $_POST['department'];
    $year = $_POST['year'];

    if (empty($register_number) || empty($dob) || empty($class) || empty($department) || empty($year)) {
        die("Error: All fields are required.");
    }

    // Determine the correct table based on class, department, and year
    $table_name = strtolower($class) . "_" . strtolower($department) . "_" . $year;

    $conn = new mysqli("localhost", "root", "", "students_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the table exists
    $table_check = $conn->query("SHOW TABLES LIKE '$table_name'");
    if ($table_check->num_rows == 0) {
        die("Error: No student records found for this class.");
    }

    // Check credentials from the dynamically selected table
    $sql = "SELECT * FROM $table_name WHERE register_number = '$register_number' AND dob = '$dob'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['register_number'] = $register_number;
        $_SESSION['class'] = $_POST['class'];
        $_SESSION['department'] = $_POST['department'];
        $_SESSION['year'] = $_POST['year'];

        header("Location: student_dashboard.php");
    } else {
        echo "Invalid register number or DOB.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <style>
        body {
            text-align: center;
            font-family: sans-serif;
            font-size: 20px;
            color: #0a304a;
            background-image: url("pics/pagenonamebg.jpg");
            background-size: cover;
            background-position: center; 
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        form {
            max-width: 450px;
            margin: auto;
            padding: 20px;
            //background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }
        input[type="text"], input[type="date"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            font-size: 25px;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 25px;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        label {
            font-size: 30px;                
            color: #333;                   
            margin-bottom: 8px;             
            display: inline-block;         
        }
        select {
            width: 100%;                    
            padding: 12px 20px;             
            margin: 8px 0;                  
            border: 2px solid #ccc;         
            border-radius: 4px;             
            background-color: #f9f9f9;      
            font-size: 25px;                
            color: #333;                    
            box-sizing: border-box;         
        }
        select:focus {
            border-color: #4CAF50;         
            outline: none;                  
        }
        h1 {
            font-size: 45px;
            color: darkblue;
        }
        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 25px;
            border-radius: 5px;
        }
        .login-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Student Login</h1>
    <form action="student_login.php" method="POST">
        <label for="register_number">Register Number:</label><br>
        <input type="text" id="register_number" name="register_number" required><br><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="class">Class:</label>
        <select id="class" name="class" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        </select><br><br>

        <label for="department">Department:</label>
        <select id="department" name="department" required>
            <option value="ARCH">Architecture</option>
            <option value="AERO">Aeronautical Engineering</option>
            <option value="BME">Bio-Medical Engineering</option>
            <option value="BIO-TECH">Bio-Technology</option>
            <option value="CHEM">Chemical Engineering</option>
            <option value="CSE">Computer Science Engineering</option>
            <option value="ECE">Electronics and Communication Engineering</option>
            <option value="EEE">Electrical and Electronics Engineering</option>
            <option value="EIE">Electronics and Instrumentation Engineering</option>
            <option value="IT">Information Technology</option>
            <option value="ME">Mechanical Engineering</option>
            <option value="MBA">Master of Business Administration</option>
            <option value="MCA">Master of Computer Applications</option>
        </select><br><br>

        <label for="year">Year:</label>
        <select id="year" name="year" required>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
        </select><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
