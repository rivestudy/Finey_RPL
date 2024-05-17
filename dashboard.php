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

        <h2>Hello, <?php echo $name?> !</h2>
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
