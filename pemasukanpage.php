<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengeluaran</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
        
.body {
    font-family: Arial, sans-serif;
    margin: 0;
    display: flex;
    height: 100vh;
}

.container {
    display: flex;
    width: 100%;
}

.sidebar {
    width: 250px;
    background-color: #f0f4ff;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.profile {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.profile-pic {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.profile-name {
    font-size: 20px;
    font-weight: bold;
}

.nav ul {
    list-style-type: none;
    padding: 0;
}

.nav li {
    margin: 15px 0;
}

.nav a {
    text-decoration: none;
    color: #000;
    display: flex;
    align-items: center;
    font-size: 16px;
}

.nav a:hover, .nav a.active {
    color: #4a90e2;
}

.main-content {
    flex: 1;
    padding: 20px;
    background-color: #fff;
}

.transaction-history {
    margin-bottom: 20px;
}

.transaction-history h2 {
    margin-bottom: 10px;
    font-size: 22px;
}

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
}

.add-data:hover {
    background-color: #357ab8;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f0f4ff;
}

.expense {
    color: red;
}

.income {
    color: green;
}

.icon {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    vertical-align: middle;
}

.edit-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
}

.card-info {
    margin-bottom: 20px;
}

.card-info h2 {
    margin-bottom: 10px;
    font-size: 22px;
}

.card {
    color: #4a90e2;
}

.card-details {
    display: flex;
    align-items: center;
}

.card-img {
    width: 200px;
    height: 120px;
    margin-right: 20px;
}

.card-text p {
    margin: 5px 0;
}

.active {
    color: green;
}

.add-card {
    text-decoration: none;
    color: #4a90e2;
    font-size: 18px;
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
                    <li><a href="pemasukanpage.php" class="active">Pemasukan</a></li>
                    <li><a href="pengeluaranpage.php">Pengeluaran</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="laporanpage.php" >Laporan Keuangan</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <div class="transaction-history">
                <h2>Data Pemasukan</h2>
                <button class="add-data">+ Tambah Data</button>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Nama Pemasukan</th>
                            <th>Jumlah</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>16 Jan 2:30pm</td>
                            <td><img src="spotify.png" alt="🗑Spotify" class="icon"> Bayar Spotify</td>
                            <td class="income">+Rp 20.000</td>
                            <td><button class="edit-btn">✏️</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>15 Jan 3:30pm</td>
                            <td><img src="starbucks.png" alt="Starbucks" class="icon"> Jajan Starbucks</td>
                            <td class="income">+Rp 2.500.000</td>
                            <td><button class="edit-btn">✏️</button></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>14 Jan 2:30pm</td>
                            <td><img src="upwork.png" alt="Upwork" class="icon"> Investasi</td>
                            <td class="income">+Rp 2.500.000</td>
                            <td><button class="edit-btn">✏️</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
