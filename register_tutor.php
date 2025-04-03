<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tutor_id = $_POST['tutor_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $class = $_POST['class'];
    $department = $_POST['department'];
    $year = $_POST['year'];

    if (empty($tutor_id) || empty($name) || empty($email) || empty($password)) {
        die("Error: All fields are required.");
    }

    $conn = new mysqli("localhost", "root", "", "students_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password before saving
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO tutors (tutor_id, name, email, password, class, department, year) 
            VALUES ('$tutor_id', '$name', '$email', '$hashed_password', '$class', '$department', '$year')";

    if ($conn->query($sql) === TRUE) {
        echo "New tutor registered successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Registration</title>
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
    <h2>Tutor Registration</h2>
    <form action="register_tutor.php" method="POST">
        <label for="tutor_id">Tutor ID:</label><br>
        <input type="text" id="tutor_id" name="tutor_id" required><br><br>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="class">Class:</label><br>
        <select id="class" name="class" required>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        </select><br><br>

        <label for="department">Department:</label><br>
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

        <label for="year">Year:</label><br>
        <select id="year" name="year" required>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
        </select><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>