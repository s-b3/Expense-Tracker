<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "moneyminder";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// Fetching expenses month-wise for the logged-in user
$sql = "SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(amount) AS total_amount 
        FROM expenses 
        WHERE username = '$username' 
        GROUP BY DATE_FORMAT(date, '%Y-%m') 
        ORDER BY DATE_FORMAT(date, '%Y-%m') DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Expenses</title>
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 600px;
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

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th,
table td {
    padding: 8px;
    text-align: left;
}

table th {
    background-color: #3498db;
    color: #fff;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
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
/* CSS for Export to Excel button */
.export-container {
    text-align: center;
    margin-top: 20px;
}

.export-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.export-btn:hover {
    background-color: #45a049;
}


    </style>
</head>

<body>
    <div class="container">
        <h1>Expenses Summary - Month-wise</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['month'] . "</td>";
                        echo "<td>" . $row['total_amount'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No expenses found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add a link to go back to the dashboard -->
        <a href="dashboard.php">Go back to Dashboard</a>
        <div class="export-container">
                <a href="export2.php" class="export-btn">Export the detailed expenses to Excel</a>
            </div>
    </div>
   

</body>

</html>

<?php
$conn->close();
?>
