<?php
session_start();

$db = mysqli_connect("localhost:3306", "root", "", "lending");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['log_btn'])) {
    $membership_id = mysqli_real_escape_string($db, $_POST['membership_id']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $qry = "SELECT * FROM tblregistration WHERE membership_id='$membership_id' AND password='$password'";
    $result = mysqli_query($db, $qry);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['membership_id'] = $membership_id;  
        header("Location: loan_calculator.php");  
        exit();  
    } else {
        echo '<script>alert("Invalid Membership ID or Password!");</script>';
        echo '<script>window.location.href = "login_user.php";</script>';
    }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffeenect Login</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #EFEDE8; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            align-items: center;
            width: 90%;
            max-width: 900px;
            gap: 20px;
        }

        .info {
            max-width: 300px;
            text-align: right;
        }

        .info h1 {
            font-size: 36px;
            color: #5C4033; 
            margin-bottom: 10px;
        }

        .login-container {
            width: 360px;
            background: #F5E8D0; 
            padding: 20px;
            border-radius: 8px;
            color: #5C4033;   
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #8A7B52; 
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .login-container input:focus {
            outline: none;
            border-color: #D2A679; 
            box-shadow: 0 0 3px rgba(210, 166, 121, 0.5);
        }

        .login-container .btn-login {
            background-color: #5C4033; 
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .login-container .btn-login:hover {
            background-color: #8A7B52; 
        }

        .divider {
            height: 1px;
            background: #8A7B52; 
            margin: 20px 0;
            width: 100%;
        }

        .login-container .btn-register {
            background-color: #D2A679; 
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .login-container .btn-register:hover {
            background-color: #8A7B52; 
        }
        .link {
            text-align: center;
            margin-top: 15px;
            font-size: 14.5px;
        }

        .link p a {
            color: #5C4033;
            font-weight: 600;
            text-decoration: none;
        }

        .link p a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="info">
            <h1>Coffeenect</h1>
        </div>
        <div class="login-container">
        <h1>LOGIN</h1>
            <form method="POST">
                <input type="text" name="membership_id" placeholder="Enter Membership ID">
                <input type="password" name="password" placeholder="Enter Password">
                <button type="submit" class="btn-login"name="log_btn">Login</button>
            </form>
            <div class="link">
                    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                    <p>Login in as Admin? <a href="login_admin.php">Login</a>
            </div>
        </div>
    </div>
</body>
</html>
