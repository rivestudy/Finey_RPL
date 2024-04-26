<?php
include 'functions.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Rincian Pengeluaran Tiap Kategori
$sql_expenses = "SELECT category, COUNT(*) AS transaction_count, SUM(amount) AS total_amount
                 FROM expenses
                 WHERE user_id = '$user_id'
                 GROUP BY category
                 ORDER BY transaction_count DESC";
$result_expenses = $conn->query($sql_expenses);

// Rincian Pemasukan Tiap Kategori
$sql_incomes = "SELECT category, COUNT(*) AS transaction_count, SUM(amount) AS total_amount
                FROM incomes
                WHERE user_id = '$user_id'
                GROUP BY category
                ORDER BY transaction_count DESC";
$result_incomes = $conn->query($sql_incomes);

// Kategori dengan Transaksi Terbanyak
$sql_top_category = "SELECT category, COUNT(*) AS transaction_count
                     FROM (
                         SELECT category FROM expenses WHERE user_id = '$user_id'
                         UNION ALL
                         SELECT category FROM incomes WHERE user_id = '$user_id'
                     ) AS transactions
                     GROUP BY category
                     ORDER BY transaction_count DESC
                     LIMIT 1";
$result_top_category = $conn->query($sql_top_category);
$row_top_category = $result_top_category->fetch_assoc();
$top_category = $row_top_category ? $row_top_category['category'] : '';

// Persentase Pengeluaran Dibanding Pemasukan
$sql_percentage = "SELECT 
                        expenses.category,
                        SUM(expenses.amount) AS total_expenses,
                        SUM(incomes.amount) AS total_incomes,
                        (SUM(expenses.amount) / SUM(incomes.amount)) * 100 AS expense_percentage
                    FROM expenses
                    LEFT JOIN incomes ON expenses.category = incomes.category
                    WHERE expenses.user_id = '$user_id' AND incomes.user_id = '$user_id'
                    GROUP BY expenses.category";
$result_percentage = $conn->query($sql_percentage);

// Nominal Transaksi Tertinggi
$sql_max_expense = "SELECT * FROM expenses WHERE amount = (SELECT MAX(amount) FROM expenses WHERE user_id = '$user_id')";
$result_max_expense = $conn->query($sql_max_expense);
$max_expense = $result_max_expense->fetch_assoc();

$sql_max_income = "SELECT * FROM incomes WHERE amount = (SELECT MAX(amount) FROM incomes WHERE user_id = '$user_id')";
$result_max_income = $conn->query($sql_max_income);
$max_income = $result_max_income->fetch_assoc();

// Rata-rata Nilai Transaksi per Hari
$sql_avg_expense_per_day = "SELECT AVG(amount) AS average_expense_per_day FROM expenses WHERE user_id = '$user_id'";
$result_avg_expense_per_day = $conn->query($sql_avg_expense_per_day);
$avg_expense_per_day = $result_avg_expense_per_day->fetch_assoc();

$sql_avg_income_per_day = "SELECT AVG(amount) AS average_income_per_day FROM incomes WHERE user_id = '$user_id'";
$result_avg_income_per_day = $conn->query($sql_avg_income_per_day);
$avg_income_per_day = $result_avg_income_per_day->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Summary</title>
    <!-- Tambahkan gaya CSS Anda atau tautan ke file CSS eksternal di sini -->
</head>
<body>
    <h2>Financial Summary</h2>

    <h3>Expense Details</h3>
    <table>
        <tr>
            <th>Category</th>
            <th>Transaction Count</th>
            <th>Total Amount</th>
        </tr>
        <?php
        while ($row = $result_expenses->fetch_assoc()) {
            echo "<tr><td>" . $row['category'] . "</td><td>" . $row['transaction_count'] . "</td><td>" . $row['total_amount'] . "</td></tr>";
        }
        ?>
    </table>

    <h3>Income Details</h3>
    <table>
        <tr>
            <th>Category</th>
            <th>Transaction Count</th>
            <th>Total Amount</th>
        </tr>
        <?php
        while ($row = $result_incomes->fetch_assoc()) {
            echo "<tr><td>" . $row['category'] . "</td><td>" . $row['transaction_count'] . "</td><td>" . $row['total_amount'] . "</td></tr>";
        }
        ?>
    </table>

    <h3>Top Category with Most Transactions: <?php echo $top_category; ?></h3>

    <h3>Expense Percentage Compared to Income</h3>
    <table>
        <tr>
            <th>Category</th>
            <th>Total Expenses</th>
            <th>Total Incomes</th>
            <th>Expense Percentage</th>
        </tr>
        <?php
        while ($row = $result_percentage->fetch_assoc()) {
            echo "<tr><td>" . $row['category'] . "</td><td>" . $row['total_expenses'] . "</td><td>" . $row['total_incomes'] . "</td><td>" . $row['expense_percentage'] . "%</td></tr>";
        }
        ?>
    </table>

    <h3>Highest Expense Transaction</h3>
    <?php
    if ($max_expense) {
        echo "<p>Category: " . $max_expense['category'] . ", Amount: " . $max_expense['amount'] . "</p>";
    } else {
        echo "<p>No expense transactions found.</p>";
    }
    ?>

    <h3>Highest Income Transaction</h3>
    <?php
    if ($max_income) {
        echo "<p>Category: " . $max_income['category'] . ", Amount: " . $max_income['amount'] . "</p>";
    } else {
        echo "<p>No income transactions found.</p>";
    }
    ?>

    <h3>Average Transaction Amount per Day</h3>
    <p>Average Expense per Day: <?php echo $avg_expense_per_day['average_expense_per_day']; ?></p>
    <p>Average Income per Day: <?php echo $avg_income_per_day['average_income_per_day']; ?></p>
</body>
</html>
