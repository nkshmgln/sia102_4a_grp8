<?php
session_start();


if (!isset($_SESSION['membership_id'])) {
    echo '<script>window.location.href = "login_user.php";</script>';  
    exit();
}

$membership_id = $_SESSION['membership_id']; 

$db = mysqli_connect("localhost:3306", "root", "", "lending");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT interest_rate, loan_amount FROM tblapplication WHERE membership_id = '$membership_id'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $interestRate = $row['interest_rate'];
    $loan_amount = $row['loan_amount'];
} else {
    $interestRate = 2; 
    $loan_amount = 0; 
}

$months = 6; 

if ($loan_amount > 0) {
    $totalPayable = $loan_amount * (1 + ($interestRate / 100));
    $monthlyPayment = $totalPayable / $months;
} else {
    $monthlyPayment = 0;
}

$penalty = 0;
$currentDate = date('Y-m-d'); 
$next_due_date = date('Y-m-d', strtotime("+1 month", strtotime($currentDate))); 
if (strtotime($currentDate) > strtotime($next_due_date)) { 
    $penalty = ($loan_amount * ($interestRate / 100)) * 0.05;  
    $loan_amount += $penalty;  
}

$_SESSION['penalty'] = $penalty;

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loan Calculator</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      color: #333;
      display: flex;
      flex-direction: column;
      align-items: center;
      height: 100vh;
    }
    .navbar {
      width: 100%;
      background-color: #6b4e31;
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      position: fixed;
      top: 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .navbar h1 {
      font-size: 1.5rem;
      color: #fff;
    }
    .navbar a {
      color: #fff;
      text-decoration: none;
      margin: 0 15px;
      font-size: 1rem;
      font-weight: bold;
    }
    .navbar a:hover {
      color: #c8e6c9;
    }
    .dashboard-container {
      width: 90%;
      max-width: 400px;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-top: 80px; 
    }
    .dashboard-container h1 {
      font-size: 1.5rem;
      color: #333;
      margin-bottom: 20px;
    }
    .card {
      background-color: #f9f9f9;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 15px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .card h2 {
      font-size: 1.2rem;
      color: #333;
      margin-bottom: 10px;
    }
    .card p {
      font-size: 1.2rem;
      color: #555;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <h1>Coffeenect</h1>
    <div>
      <a href="apply_loan.php">Application</a>
      <a href="login_user.php">Log-out</a>
    </div>
  </nav>
  <div class="dashboard-container">
    <h1>Loan Details</h1>
    <div class="card">
      <h2>Loan Amount</h2>
      <p>₱<?php echo number_format($loan_amount, 2); ?></p> 
    </div>
    <div class="card">
      <h2>Interest Rate</h2>
      <p><?php echo $interestRate; ?>%</p> 
    </div>
    <div class="card">
      <h2>Monthly Payment</h2>
      <p>₱<?php echo number_format($monthlyPayment, 2); ?></p> 
    </div>
    <div class="card">
      <h2>Penalty (if overdue)</h2>
      <p>₱<?php echo number_format($penalty, 2); ?></p> 
    </div>
  </div>
</body>
</html>
