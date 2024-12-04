<?php
include "mycon.php";

$db = mysqli_connect("localhost:3306", "root", "", "lending");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $membership_id = mysqli_real_escape_string($db, $_POST['membership_id']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $purpose = mysqli_real_escape_string($db, $_POST['purpose']);
    $loan_amount = mysqli_real_escape_string($db, $_POST['loan_amount'] ?? '');  


    $qry = "INSERT INTO tblapplication (membership_id, name, email, purpose, loan_amount, status) 
        VALUES ('$membership_id', '$name', '$email', '$purpose', '$loan_amount', 'Pending')";

    $result = mysqli_query($db, $qry);

    if ($result) {
        echo '<script>alert("Your application was submitted successfully! \n Wait for the verification of your loan.");</script>';
        echo '<script>window.location.assign("loan_calculator.php");</script>';
    } else {
        echo '<script>alert("Error: ' . mysqli_error($db) . '");</script>';
    }
}

mysqli_close($db);
?>