<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Expense</title>
</head>
<body>
  <?php
  include 'functions.php';

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id'])) {
      // Redirect to expense list or appropriate page
      header("Location: expense_list.php");
      exit();
    }

    $expense_id = $_GET['id'];

    // Fetch expense record
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM expenses WHERE id = '$expense_id' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $amount = $row['amount'];
      $description = $row['description'];
      $category = $row['category'];
      $date = $row['date'];
    } else {
      echo "Expense record not found";
      exit();
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['expense_id'])) {
    $expense_id = $_POST['expense_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];

    // Validate user input (example)
    if (!is_numeric($amount) || strlen($description) < 5) {
      // Display error message and re-populate form with existing data
      echo "Invalid input. Please check amount and description.";
      include 'edit_expense_form.php'; // Include a separate form template
      exit();
    }

    $sql = "UPDATE expenses SET amount='$amount', description='$description', category='$category', date='$date' WHERE id='$expense_id'";
    if ($conn->query($sql) === TRUE) {
      header("Location: expense_page.php");
    } else {
      echo "Error updating record: " . $conn->error;
    }
  }
  ?>

  <h1>Edit Expense</h1>
  <form action="" method="post">
    <input type="hidden" name="expense_id" value="<?php echo $expense_id; ?>">
    <label for="amount">Amount:</label><br>
    <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" required><br>
    <label for="description">Description:</label><br>
    <input type="text" id="description" name="description" value="<?php echo $description; ?>" required><br>
    <label for="category">Category:</label><br>
    <input type="text" id="category" name="category" value="<?php echo $category; ?>" required><br>
    <label for="date">Date:</label><br>
    <input type="date" id="date" name="date" value="<?php echo $date; ?>" required><br><br>
    <input type="submit" value="Save Changes">
  </form>
</body>
</html>
