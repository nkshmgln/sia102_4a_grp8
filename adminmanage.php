<?php
include "myconadmin.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $membership_id = mysqli_real_escape_string($connection, $_POST['membership_id']);

    if (isset($_POST['accept'])) {
        $qryAcc = "UPDATE tblapplication SET status = 'accepted' WHERE membership_id = ?";
    } elseif (isset($_POST['deny'])) {
        $qryDec = "UPDATE tblapplication SET status = 'denied' WHERE membership_id = ?";
    }

    if (isset($qryAcc) || isset($qryDec)) {
        $query = isset($qryAcc) ? $qryAcc : $qryDec;
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $membership_id); // Changed to "s" for string type
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Status updated successfully!")</script>';
        } else {
            echo 'Error updating status: ' . mysqli_error($connection);
        }
        mysqli_stmt_close($stmt);
    }

    echo '<script>window.location.assign("manage_loans.php")</script>';
} else {
    echo 'No action selected!';
}

mysqli_close($connection);
?>