<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
}

// Fetch user's expenses
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM expenses WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>

    .add-data {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4a90e2;
        border: none;
        color: #fff;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        float: right;
        margin: 20px;
    }

    .add-data:hover {
        background-color: #357ab8;
    }

</style>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile">
                <img src="images/flogo.png" alt="Profile Picture" class="profile-pic">
                <span class="profile-name">Finey</span>
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="pemasukanpage.php">Pemasukan</a></li>
                    <li><a href="pengeluaranpage.php" class="active">Pengeluaran</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="laporanpage.php">Laporan Keuangan</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <div class="transaction-history">
                <h2>Data Pengeluaran</h2>
                <a href="addpengeluaran.php"><button class="add-data">+ Tambah Data</button></a>
                <table>
                    <tr>
                    <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Kategori</th>
                        <th>Ubah</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>$" . $row['amount'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td><a href='editpengeluaran.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_expense.php?id=" . $row['id'] . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data pengeluaran yang ditemukan.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>