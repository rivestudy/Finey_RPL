<?php
include 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $income_id = $_GET['id'];

    // Fetch income record
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM incomes WHERE id = '$income_id' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $sql_delete = "DELETE FROM incomes WHERE id = '$income_id'";
        if ($conn->query($sql_delete) === TRUE) {
            header("Location: pemasukanpage.php");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Income record not found";
    }
} else {
    echo "Invalid request";
}
?>
