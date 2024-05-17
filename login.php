<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (authenticateUser($username, $password)) {
        header("Location: dashboard.php");
    } else {
        echo "Invalid username or password";
    }
}
?>
