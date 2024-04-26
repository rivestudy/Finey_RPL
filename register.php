
<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if the username already exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different one.";
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert the user data into the users table
        $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        
        if ($conn->query($sql_insert) === TRUE) {
            echo "Registration successful. You can now <a href='login.html'>login</a>.";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }
}
?>
