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

$username = $_SESSION['username'];

// Fetch expenses for the logged-in user
$sql = "SELECT * FROM expenses WHERE username = '$username' ORDER BY date DESC";
$result = $conn->query($sql);
// if($result->num_rows>0)
// {
//     echo "<table border='1'>";
//     echo "<theader>gtfhgh</theader>";
//     while($row=$result->fetch_assoc()){
//         echo "<tr>";
//         echo "<td>".$row['expense_name']."</td>";
//         echo "<td>".$row['amount']."</td>";
//         echo"</tr>";
//     }
//     echo"</table>";
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Expense Tracker - Dashboard</title>
    <style>
       /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 900px;
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

h2 {
    margin-top: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
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

.dashboard-btn {
    display: block;
    width: 200px;
    padding: 15px;
    margin: 10px auto;
    text-align: center;
    background-color: #3498db;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

.dashboard-btn:hover {
    background-color: #2980b9;
}

.logout-link {
    display: block;
    margin-top: 20px;
    text-align: center;
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
}

.logout-link:hover {
    color: #2980b9;
}

    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <!-- Your existing expense table -->
        <h2>Your Expenses:</h2>
        <table border="1">
            <!-- Table headers -->
            <!-- ... -->
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        // echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['expense_name'] . "</td>";
                        echo "<td>" . $row['amount'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a></td>";
                        echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No expenses found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Links for various actions -->
        <a href="add.php" class="dashboard-btn">Add Expense</a>
        <a href="view.php" class="dashboard-btn">View Monthly Expenses</a>
        <!-- You can create separate PHP files for these actions and link them accordingly -->

        <!-- Logout link -->
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>

</html>
