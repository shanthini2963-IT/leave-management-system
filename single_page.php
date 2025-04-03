<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            background-image: url("pics/pagenonamebg.jpg");
            background-size: cover;
            background-position: center; 
            background-repeat: no-repeat;
            }
        .container {
            text-align: center;
        }
        .login-button {
            display: block;
            margin: 30px auto;
            padding: 20px 30px;
            font-size: 25px;
            background-color: #3a4c66;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 400px;
            text-align: center;
        }
        .login-button:hover {
            background-color: #526682;
        }
        h1 {
            color: darkblue;
            font-size: 50px;
        }
        h2{
            //color: darkgreen;
            font-size: 40px;
        }
        h3{
            //color: darkgreen;
            font-size: 35px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ADHIYAMAAN COLLEGE OF ENGINEERING</h1><br><br><br><br>
        <h2>Login As</h2>
        <button class="login-button" onclick="location.href='student_login.php'">Student</button>
        <button class="login-button" onclick="location.href='tutor_login.php'">Tutor</button>
        <button class="login-button" onclick="location.href='hod_login.php'">HOD</button>
        <h3>or</h3>
        <button class="login-button" onclick="location.href='single_reg.php'">Register</button>
    </div>
</body>
</html>
