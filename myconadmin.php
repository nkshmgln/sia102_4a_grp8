<?php

$server = 'localhost:3306';
$user = 'root';
$pass = '';
$db = 'lending';

// Connect to database
$connection = mysqli_connect($server, $user, $pass);
if (!$connection) {
    die('Could not connect to server: ' . mysqli_connect_error());
}

// Select the database
if (!mysqli_select_db($connection, $db)) {
    die('Could not connect to database: ' . mysqli_error($connection));
}

?>