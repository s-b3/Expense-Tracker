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

$response = ""; // Initialize the response variable

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $expense_id = $_GET['id'];

    // Delete the expense record from the database
    $delete_sql = "DELETE FROM expenses WHERE id = '$expense_id' AND username = '{$_SESSION['username']}'";
    if ($conn->query($delete_sql) === TRUE) {
        $response = "Expense deleted successfully!";
    } else {
        $response = "Error deleting expense: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Expense</title>
    
    <script>
        window.onload = function() {
            var response = "<?php echo $response; ?>";
            alert(response);
            window.location = "dashboard.php"; 
        }
    </script>
</head>
<body>
</body>
</html>
