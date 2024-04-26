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
    <title>Income Page</title>
</head>
<body>
    <h1>Income Page</h1>
    <h2>Add Income</h2>
    <form action="add_income.php" method="post">
        <label for="amount">Amount:</label><br>
        <input type="text" id="amount" name="amount" required><br>
        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" required><br>
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" required><br>
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>
        <input type="submit" value="Add Income">
    </form>

    <h2>Income Records</h2>
    <table border="1">
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>$" . $row['amount'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td><a href='edit_income.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_income.php?id=" . $row['id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No income records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
