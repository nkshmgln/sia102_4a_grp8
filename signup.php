<?php
session_start();

$db = mysqli_connect("localhost:3306", "root", "", "lending");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['signup_btn'])) {
    $membership_id = mysqli_real_escape_string($db, $_POST['membership_id']);
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $qry = "INSERT INTO tblregistration (membership_id, firstname, lastname, email, password) 
            VALUES ('$membership_id', '$firstname', '$lastname', '$email', '$password')";
    
    if (mysqli_query($db, $qry)) {
        echo '<script>alert("Registration successful! Please login.");</script>';
        echo '<script>window.location.href = "login_user.php";</script>';
        exit();
    } else {
        echo "Error: " . mysqli_error($db);
    }
}

mysqli_close($db);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffeenect Register</title>
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

        .register-container {
            width: 360px;
            background: #F5E8D0;
            padding: 20px;
            border-radius: 8px;
            color: #5C4033; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-container input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #8A7B52;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .register-container input:focus {
            outline: none;
            border-color: #D2A679;
            box-shadow: 0 0 3px rgba(210, 166, 121, 0.5);
        }

        .register-container .btn-register {
            background-color: #5C4033;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .register-container .btn-register:hover {
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
        <div class="register-container">
            <h1>Sign Up</h1>
            <form method="POST" >
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="membership_id" placeholder="Enter Membership ID" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn-register" name="signup_btn">Register</button>
            </form>
            <div class="link">
            <p>Already have an account? <a href="login_user.php">Log In</p>
        </div>
        </div>
    </div>
</body>
</html>
