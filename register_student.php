<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $register_number = $_POST['register_number'];
    $student_name = $_POST['student_name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $department = $_POST['department'];
    $year = $_POST['year'];

    if (empty($register_number)) {
        die("Error: Register number cannot be empty.");
    }

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "students_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Create a table name based on class, department, and year
    $table_name = $class . "_" . $department . "_" . $year;
    $table_name = str_replace(" ", "_", strtolower($table_name)); // Replace spaces with underscores and lowercase the name

    // Create the table if it doesn't exist
    $create_table_sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        register_number VARCHAR(50) NOT NULL,
        student_name VARCHAR(100) NOT NULL,
        dob DATE NOT NULL,
        email VARCHAR(100) NOT NULL
    )";
    
    if ($conn->query($create_table_sql) === TRUE) {
        // Insert the student into the dynamically created table
        $insert_sql = "INSERT INTO `$table_name` (register_number, student_name, dob, email) 
                       VALUES ('$register_number', '$student_name', '$dob', '$email')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "New student registered successfully in $table_name.";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Check if the student already exists
    $check_sql = "SELECT * FROM $table_name WHERE register_number = '$register_number'";
    $check_result = $conn->query($check_sql);

    //if ($check_result->num_rows > 0) {
        //die("Error: Register number already exists.");
    //}

    

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
</head>
<style>
        /* Basic styles for login form */
        body
        {
        text-align: center;
        //padding: 400px 300px;
        font-family: sans-serif;
        font-size: 30px;
        color: #0a304a;
        background-image: url("pics/pagenonamebg.jpg");
        background-size: cover;
        background-position: center; 
        background-attachment: fixed;
        background-repeat: no-repeat;
        //margin: 0;
        //padding: 0;
        }
        form {
            max-width: 450px;
            margin: auto;
        }
        input[type="text"], input[type="password"], input[type="date"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            font-size: 30px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 30px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            text-align: center;
        }
        label {
            font-family: Arial, sans-serif; 
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
            font-size: 30px;                
            color: #333;                    
            box-sizing: border-box;         
        }
        select:focus {
            border-color: #4CAF50;         
            outline: none;                  
        }
        select:hover {
            background-color: #f1f1f1;      
        }
        h1{
            font-size: 70px;
            color: darkblue;
        }
    </style>
<body>
    <h1>ADHIYAMAAN COLLEGE OF ENGINEERING</h1>
    <h2>Student Registration</h2>
    <form action="register_student.php" method="POST">
        <label for="register_number">Register Number:</label>
        <input type="text" id="register_number" name="register_number" required><br><br>

        <label for="student_name">Name:</label>
        <input type="text" id="student_name" name="student_name" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

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

        <input type="submit" value="Register"><br>
    </form>
</body>
</html>
