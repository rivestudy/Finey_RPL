<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
}

$balance = calculateBalance();
$user_id = $_SESSION['user_id'];

// Fetch total income
$sql_total_income = "SELECT COALESCE(SUM(amount), 0) AS total_income FROM incomes WHERE user_id = '$user_id'";
$result_total_income = $conn->query($sql_total_income);
$row_total_income = $result_total_income->fetch_assoc();
$total_income = $row_total_income['total_income'];

// Fetch total expenses
$sql_total_expense = "SELECT COALESCE(SUM(amount), 0) AS total_expense FROM expenses WHERE user_id = '$user_id'";
$result_total_expense = $conn->query($sql_total_expense);
$row_total_expense = $result_total_expense->fetch_assoc();
$total_expense = $row_total_expense['total_expense'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <h1>Welcome to Money Management</h1>
    <h2>Total Income: $<?php echo $total_income; ?></h2>
    <h2>Total Expenses: $<?php echo $total_expense; ?></h2>
    <h2>Balance: $<?php echo $balance; ?></h2>
    <a href="income_page.php">Add Income</a>
    <a href="expense_page.php">Add Expense</a>
</body>
</html>
