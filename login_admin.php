<?php
session_start(); 

$db = mysqli_connect("localhost:3306", "root", "", "lending");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['log_btn'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $qry = "SELECT * FROM tbladminlogin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $qry);

    if (mysqli_num_rows($result) == 1) {

        echo '<script>window.location.href = "manage_loans.php";</script>';
        exit();
    } else {
        echo '<script>alert("Invalid Username or Password!");</script>';
    }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffeenect Admin Login</title>
    <link rel="stylesheet" href="styles2.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <div class="logo-title">
            <h1>Coffeenect</h1>
        </div>
    </header>

    <main class="main-content">
        <div class="wrapper">
            <form id="login-form" method="POST">
                <h1>Admin Login</h1>
                <div class="input-box">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn" name="log_btn">Login</button>

                <div class="register-link">
                    <p>Log In as User <a href="login_user.php">Login</a></p>
                </div>
            </form>
        </div>
    </main>
</body> 
</html>
