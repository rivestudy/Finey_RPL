<?php
include 'functions.php';

$message = '';
$redirect_url = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $message = "Username already exists. Please choose a different one.";
        $redirect_url = "registerpage.html";
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert the user data into the users table
        $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        
        if ($conn->query($sql_insert) === TRUE) {
            $message = "Registration successful. You can now login.";
            $redirect_url = "loginpage.html";
        } else {
            $message = "Error: " . $sql_insert . "<br>" . $conn->error;
            $redirect_url = "registerpage.html";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
