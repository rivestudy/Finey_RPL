<?php
include 'functions.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$balance = calculateBalance();
$user_id = $_SESSION['user_id'];


$sql_user_data = "SELECT username FROM users WHERE id = '$user_id'";
$result_user_data = $conn->query($sql_user_data);
$row_user_data = $result_user_data->fetch_assoc();
$name = $row_user_data['username']; 


$sql_total_income = "SELECT COALESCE(SUM(amount), 0) AS total_income FROM incomes WHERE user_id = '$user_id'";
$result_total_income = $conn->query($sql_total_income);
$row_total_income = $result_total_income->fetch_assoc();
$total_income = $row_total_income['total_income'];

// Fetch total expenses
$sql_total_expense = "SELECT COALESCE(SUM(amount), 0) AS total_expense FROM expenses WHERE user_id = '$user_id'";
$result_total_expense = $conn->query($sql_total_expense);
$row_total_expense = $result_total_expense->fetch_assoc();
$total_expense = $row_total_expense['total_expense'];

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
                    <li><a href="pemasukanpage.php">Pemasukan</a></li>
                    <li><a href="pengeluaranpage.php">Pengeluaran</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="laporanpage.php">Laporan Keuangan</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">

            <h2>Halo, <?php echo $name ?>!</h2>
            <div class="overview">
                <div class="balance-card">
                    <h3>Total Saldo</h3>
                    <p>Rp. <?php echo number_format($balance, 0, ',', '.'); ?></p>
                </div>
                <div class="income-card">
                    <h3>Pemasukan</h3>
                    <p>Rp. <?php echo number_format($total_income, 0, ',', '.'); ?></p>
                </div>
                <div class="expense-card">
                    <h3>Pengeluaran</h3>
                    <p>Rp. <?php echo number_format($total_expense, 0, ',', '.'); ?></p>
                </div>
            </div>
            <div class="transaction-history">
                <h2>Riwayat Transaksi</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Transaksi</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result_transaction_history->fetch_assoc()) {
                            $amount_class = $row['type'] == 'expense' ? 'expense' : 'income';
                            echo "<tr>
                                    <td>{$row['description']}</td>
                                    <td class='$amount_class'>" . ($row['type'] == 'expense' ? '-' : '+') . "Rp " . number_format(abs($row['amount']), 0, ',', '.') . "</td>
                                    <td>" . date('D, d M Y', strtotime($row['date'])) . "</td>
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
