<?php
include 'functions.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
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

$sql_transaction_history = "SELECT description, amount, date, 'expense' AS type FROM expenses WHERE user_id = '$user_id'
                            UNION ALL
                            SELECT description, amount, date, 'income' AS type FROM incomes WHERE user_id = '$user_id'
                            ORDER BY date DESC";
$result_transaction_history = $conn->query($sql_transaction_history);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile">
                <img src="images/flogo.png" alt="Profile Picture" class="profile-pic">
                <span class="profile-name">Finey</span>
            </div>
            <nav class="nav">
            <ul>
                    <li><a href="dashboard.php" class="active">Home</a></li>
                    <li><a href="#">Pemasukan</a></li>
                    <li><a href="pengeluaranpage.php" >Pengeluaran</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="laporanpage.php" >Laporan Keuangan</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <div class="overview">
                <div class="balance-card">
                    <h3>Total Saldo</h3>
                    <p>Rp. <?php echo $balance; ?></p>
                </div>
                <div class="income-card">
                    <h3>Pemasukan</h3>
                    <p>Rp. <?php echo $total_income; ?></p>
                </div>
                <div class="expense-card">
                    <h3>Pengeluaran</h3>
                    <p>Rp. <?php echo $total_expense; ?></p>
                </div>
            </div>
            <div class="transaction-history">
                <h2>Transaction History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result_transaction_history->fetch_assoc()) {
                            $amount_class = $row['type'] == 'expense' ? 'expense' : 'income';
                            echo "<tr>
                                    <td>{$row['description']}</td>
                                    <td class='$amount_class'>" . ($row['type'] == 'expense' ? '-' : '+') . "Rp " . number_format(abs($row['amount']), 0, ',', '.') . "</td>
                                    <td>" . date('d M g:iA', strtotime($row['date'])) . "</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
