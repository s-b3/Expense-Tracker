<?php
session_start();
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

$sql = "SELECT * FROM expenses WHERE username = '$username' ORDER BY date ";
$result = $conn->query($sql);
$html='<table><tr><td>Expense name</td><td>Amount</td><td>Date</td><td>Category</td></tr>';
while ($row = $result->fetch_assoc()) {
    $html.='<tr><td>'.$row['expense_name'] .'</td><td>'. $row['amount'] .'</td>
    <td>'. $row['date'] .'</td>
    <td>'. $row['category'] .'</td>
    </tr><table>';
header('Content-Type:application/xls');
header('Content-Disposition:attachment;filename=expense.xls');

}
echo $html;
?>