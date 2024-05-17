<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
}

// Fetch user's income
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM incomes WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengeluaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .main-content {
        flex: 1;
        display: flex;
    }

    .input-form {
        padding: 40px;
        text-align: left;
        width: 700px;
    }

    .input-form h2 {
        margin-bottom: 20px;
        font-size: 24px;
    }

    .input-form input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .input-form button {
        width: 200px;
        padding: 10px;
        background-color: #4a90e2;
        border: none;
        color: #fff;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        float: right    ;
    }

    .input-form button:hover {
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
        <div>
            <div class="input-form">
                <h2>Tambah Data Pengeluaran</h2>
                <form action="add_expense.php" method="post">
                    <label for="amount">Jumlah:</label><br>
                    <input type="text" id="amount" name="amount" required><br>
                    <label for="description">Nama:</label><br>
                    <input type="text" id="description" name="description" required><br>
                    <label for="category">Kategori:</label><br>
                    <input type="text" id="category" name="category" required><br>
                    <label for="date">Tanggal:</label><br>
                    <input type="date" id="date" name="date" required><br><br>
                    <button type="submit">Tambah Pengeluaran</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>