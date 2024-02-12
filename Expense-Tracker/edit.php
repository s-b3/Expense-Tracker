<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'moneyminder';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your database connection code here

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $expense_id = $_GET['id'];

    // Fetch expense data by ID
    $sql = "SELECT * FROM expenses WHERE id = '$expense_id' AND username = '{$_SESSION['username']}'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $expense_data = $result->fetch_assoc();
        // Store fetched data into variables
        $expense_name = $expense_data['expense_name'];
        $amount = $expense_data['amount'];
        // ... (other fields)
    } else {
        echo "Expense not found or unauthorized access!";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_id = $_POST['id'];
    $new_expense_name = $_POST['expense_name'];
    $new_amount = $_POST['amount'];
    // ... (other fields)

    // Update expense data in the database
    $update_sql = "UPDATE expenses SET expense_name = '$new_expense_name', amount = '$new_amount' WHERE id = '$expense_id'";
    if ($conn->query($update_sql) === TRUE) {
        // Redirect to the dashboard after updating
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating expense: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Expense</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
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
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Expense</h1>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $expense_id; ?>">
            <label for="expense_name">Expense Name:</label>
            <input type="text" id="expense_name" name="expense_name" value="<?php echo $expense_name; ?>" required>
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" required>
            <input type="submit" value="Update Expense">
        </form>
    </div>
</body>
</html>

