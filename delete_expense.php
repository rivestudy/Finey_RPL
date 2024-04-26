<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $expense_id = $_GET['id'];

    // Fetch expense record
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM expenses WHERE id = '$expense_id' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $sql_delete = "DELETE FROM expenses WHERE id = '$expense_id'";
        if ($conn->query($sql_delete) === TRUE) {
            header("Location: expense_page.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Expense record not found";
    }
} else {
    echo "Invalid request";
}
?>
