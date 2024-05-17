<?php
include 'functions.php';

$message = '';
$redirect_url = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (authenticateUser($username, $password)) {
        $message = "Login successful.";
        $redirect_url = "dashboard.php";
    } else {
        $message = "Invalid username or password.";
        $redirect_url = "loginpage.html";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .message-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px auto;
            width: 300px;
            text-align: center;
        }
        .message-box p {
            margin: 10px 0;
        }
        .message-box button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php if ($message): ?>
        <div class="message-box">
            <p><?php echo $message; ?></p>
            <button onclick="window.location.href='<?php echo $redirect_url; ?>'">Go Back</button>
        </div>
    <?php endif; ?>
</body>
</html>
