<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'moneyminder';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];
    $expenseName = $_POST['expense_name'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $category = $_POST['category'];

    // Insert expense into database
    $sql = "INSERT INTO expenses (username, expense_name, amount, date, category) VALUES ('$username', '$expenseName', '$amount', '$date', '$category')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the dashboard after adding the expense
        header("Location: dashboard.php");
        exit();
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
    <title>Add Expense</title>
    <!-- Add your CSS styles here if needed -->
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 500px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 8px;
}

input[type="text"],
input[type="number"],
input[type="date"] {
    width: calc(100% - 12px);
    padding: 8px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #2980b9;
}

a {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
}

a:hover {
    color: #2980b9;
}

    </style>
</head>

<body>
    <div class="container">
        <h1>Add Expense</h1>
        <form action="" method="POST">
            <label for="expense_name">Expense Name:</label>
            <input type="text" id="expense_name" name="expense_name" required><br><br>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required><br><br>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br><br>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required><br><br>

            <input type="submit" value="Add Expense">
        </form>

        <!-- Add a link to go back to the dashboard -->
        <a href="dashboard.php">Go back to Dashboard</a>
    </div>
</body>

</html>
