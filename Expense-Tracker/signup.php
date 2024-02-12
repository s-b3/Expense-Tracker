<?php
session_start();
if (isset($_SESSION['employeeId'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    $cpwd = $_POST['cpwd'];

    $servername = "localhost";
    $usersname = "root";
    $password_db = "";
    $dbname = "moneyminder";

    
    $conn = new mysqli($servername, $usersname, $password_db, $dbname);

   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    if ($password !== $cpwd) {
        $error = "Passwords do not match";
        echo $error;
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['username']=$username;
            header("Location: index.html");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>