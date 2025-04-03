<?php
session_start();
$conn = new mysqli("localhost", "root", "", "students_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($name) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        // Insert into the HODs table
        $stmt = $conn->prepare("INSERT INTO hods (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            echo "HOD registered successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOD Registration</title>
    <style>
        /* Add your CSS styling here */
    </style>
</head>
<body>
    <h1>Register HOD</h1>
    <form action="hod_register.php" method="POST">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
