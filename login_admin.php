<?php
session_start();

$admin_username = "admin";
$admin_password = "password";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['loggedin'] = true;
        header("Location: admin.html");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden;
    }

    .navbar {
      background-color: #6b4e31;
      color: #ffffff;
      padding: 15px;
      font-size: 1.5em;
      font-weight: bold;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f4f4f4;
    }

    .login-box {
      width: 300px;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      text-align: center;
    }

    .login-box h2 {
      color: #6b4e31;
      margin-bottom: 20px;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #6b4e31;
      border-radius: 4px;
      outline: none;
    }

    .login-box input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #6b4e31;
      color: #ffffff;
      border: none;
      border-radius: 4px;
      font-size: 1em;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .login-box input[type="submit"]:hover {
      background-color: #573d29;
    }

    .error {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="navbar">
    Admin
  </div>

  <div class="container">
    <div class="login-box">
      <h2>Login</h2>
      <form action="" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
      </form>
      <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>