<?php
session_start();
$conn = new mysqli("localhost", "root", "", "students_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Please enter both email and password.";
    } else {
        // Query the tutors table
        $stmt = $conn->prepare("SELECT * FROM tutors WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $tutor = $result->fetch_assoc();

        if ($tutor && password_verify($password, $tutor['password'])) {
            // If credentials are correct, create a session and redirect
            $_SESSION['tutor_id'] = $tutor['tutor_id'];
            $_SESSION['email'] = $tutor['email'];
            $_SESSION['name'] = $tutor['name'];
            header("Location: tutor_dashboard.php");
        } else {
            echo "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Login</title>
    <style>
        body {
            text-align: center;
            font-family: sans-serif;
            font-size: 20px;
            color: #0a304a;
            padding: 250px 50px;
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
        input[type="email"], input[type="password"] {
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
    <h1>Tutor Login</h1>
    <form action="tutor_login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
