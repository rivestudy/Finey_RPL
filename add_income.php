<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    
    if (addIncome($amount, $description, $category, $date)) {
        header("Location: pemasukanpage.php");
    } else {
        echo "Error adding income";
    }
}
?>
