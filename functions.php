<?php
session_start();
include 'db_config.php';

function authenticateUser($username, $password) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);

    // Retrieve hashed password from the database
    $sql = "SELECT id, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the password using password_verify function
        if (password_verify($password, $hashed_password)) {
            // Password is correct
            $_SESSION['user_id'] = $row['id'];
            return true;
        } else {
            // Password is incorrect
            return false;
        }
    } else {
        // User not found
        return false;
    }
}

function addIncome($amount, $description, $category, $date) {
    global $conn;
    $amount = mysqli_real_escape_string($conn, $amount);
    $description = mysqli_real_escape_string($conn, $description);
    $category = mysqli_real_escape_string($conn, $category);
    $date = mysqli_real_escape_string($conn, $date);
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO incomes (user_id, amount, description, category, date) VALUES ('$user_id', '$amount', '$description', '$category', '$date')";
    return $conn->query($sql);
}

function addExpense($amount, $description, $category, $date) {
    global $conn;
    $amount = mysqli_real_escape_string($conn, $amount);
    $description = mysqli_real_escape_string($conn, $description);
    $category = mysqli_real_escape_string($conn, $category);
    $date = mysqli_real_escape_string($conn, $date);
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO expenses (user_id, amount, description, category, date) VALUES ('$user_id', '$amount', '$description', '$category', '$date')";
    return $conn->query($sql);
}

function calculateBalance() {
    global $conn;
    $user_id = $_SESSION['user_id'];
    
    $sql_total_income = "SELECT COALESCE(SUM(amount), 0) AS total_income FROM incomes WHERE user_id = '$user_id'";
    $result_total_income = $conn->query($sql_total_income);
    $row_total_income = $result_total_income->fetch_assoc();
    $total_income = $row_total_income['total_income'];

    $sql_total_expense = "SELECT COALESCE(SUM(amount), 0) AS total_expense FROM expenses WHERE user_id = '$user_id'";
    $result_total_expense = $conn->query($sql_total_expense);
    $row_total_expense = $result_total_expense->fetch_assoc();
    $total_expense = $row_total_expense['total_expense'];
    
    return $total_income - $total_expense;
}
?>
