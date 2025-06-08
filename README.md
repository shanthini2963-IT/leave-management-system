Leave Management System (LMS) - PHP & MySQL

📌 Description

This is a web-based Leave Management System built using PHP, MySQL, HTML, CSS, and JavaScript. It allows students to apply for leave, tutors to approve/reject applications, and HODs to review final approvals.

🎯 Features

✅ Student Login (Register Number & DOB)
✅ Tutor & HOD Login (Staff ID & Password)
✅ Students can apply for leave with details like reason, start & end date, and attendance percentage
✅ Tutors can review, approve, or reject student leave applications
✅ HODs can approve or reject tutor-approved applications
✅ Students can track their leave status

🛠 Tech Stack
➡️Backend: PHP
➡️Database: MySQL
➡️Frontend: HTML, CSS, JavaScript
➡️Local Server: XAMPP

🧪 Testing
✅ Selenium tests are included to verify login functionality.
✅ Test file: selenium_tests/test_login.py

📌 Installation Guide

1️⃣ Clone the Repository:
----------------------
git clone https://github.com/shanthini29636-IT/leave-management-system.git

2️⃣ Move to Project Directory:
-----------------------
cd leave-management-system

3️⃣ Set Up Database:
-----------------------
➡️Open phpMyAdmin in your browser.
➡️Create a new database (e.g., leave_db).
➡️Import database.sql file (if available).

4️⃣ Configure Database in db_connect.php:
-----------------------
$host = "localhost";
$username = "root";
$password = "";
$database = "leave_db";
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

5️⃣ Start the Server:
----------------------
➡️Open XAMPP Control Panel
➡️Start Apache and MySQL
➡️Access the project at:
http://localhost/leave-management-system/

🚀 Usage
➡️Student Login: Register Number & Date of Birth
➡️Tutor & HOD Login: Staff ID & Password
➡️Students apply for leave, and tutors approve/reject requests
➡️HODs review tutor-approved leave requests

👨‍💻 Contributing
Feel free to fork this repository, create a new branch, and submit pull requests!

📜 License
This project is open-source and free to use.
