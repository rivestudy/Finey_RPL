<?php
  include 'functions.php';

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id'])) {
      // Redirect to income list or appropriate page
      header("Location: income_list.php");
      exit();
    }

    $income_id = $_GET['id'];

    // Fetch income record
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM incomes WHERE id = '$income_id' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $amount = $row['amount'];
      $description = $row['description'];
      $category = $row['category'];
      $date = $row['date'];
    } else {
      echo "Income record not found";
      exit();
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['income_id'])) {
    $income_id = $_POST['income_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];

    // Validate user input (example)
    if (!is_numeric($amount) || strlen($description) < 5) {
      // Display error message and re-populate form with existing data
      echo "Invalid input. Please check amount and description.";
      include 'edit_income_form.php'; // Include a separate form template
      exit();
    }

    $sql = "UPDATE incomes SET amount='$amount', description='$description', category='$category', date='$date' WHERE id='$income_id'";
    if ($conn->query($sql) === TRUE) {
      header("Location: pemasukanpage.php");
    } else {
      echo "Error updating record: " . $conn->error;
    }
  }
  ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemasukan</title>
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
        float: right;
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
                    <li><a href="pemasukanpage.php" class="active">Pemasukan</a></li>
                    <li><a href="pengeluaranpage.php">Pengeluaran</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="laporanpage.php">Laporan Keuangan</a></li>
                </ul>
            </nav>
        </div>
        <div>
            <div class="input-form">
                <h2>Edit Data Pemasukan</h2>
                <form action="" method="post">
                    <input type="hidden" name="income_id" value="<?php echo $income_id; ?>">
                    <label for="amount">Amount:</label><br>
                    <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" required><br>
                    <label for="description">Description:</label><br>
                    <input type="text" id="description" name="description" value="<?php echo $description; ?>" required><br>
                    <label for="category">Category:</label><br>
                    <input type="text" id="category" name="category" value="<?php echo $category; ?>" required><br>
                    <label for="date">Date:</label><br>
                    <input type="date" id="date" name="date" value="<?php echo $date; ?>" required><br><br>
                    <button type="submit">Ubah Pemasukan</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>