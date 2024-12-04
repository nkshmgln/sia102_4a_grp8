<?php
session_start();

$db = mysqli_connect("localhost:3306", "root", "", "lending");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$membership_id = isset($_GET['membership_id']) ? $_GET['membership_id'] : null;

if ($membership_id) {
    $query = "SELECT loan_amount FROM loans WHERE membership_id = '$membership_id' LIMIT 1";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $loan_amount = $row['loan_amount'];
    } else {
        $loan_amount = 10000;  
    }
} else {
    $loan_amount = 10000;  
}

if (isset($_POST['update_loan'])) {
    $interestRate = $_POST['interestRate'];
    $months = $_POST['months'];
    $manualMonthlyPayment = $_POST['monthlyPayment'] ?? null;
    $manualDueDate = $_POST['dueDate'] ?? null;

    $_SESSION['interestRate'] = $interestRate;
    $_SESSION['months'] = $months;

    if ($manualMonthlyPayment) {
        $_SESSION['monthlyPayment'] = $manualMonthlyPayment;
    }

    if ($manualDueDate) {
        $_SESSION['next_due_date'] = $manualDueDate;
    }
} else {
    $interestRate = isset($_SESSION['interestRate']) ? $_SESSION['interestRate'] : 2;
    $months = isset($_SESSION['months']) ? $_SESSION['months'] : 6;
}

if (!isset($_SESSION['monthlyPayment'])) {
    $totalPayable = $loan_amount * (1 + ($interestRate / 100));
    $monthlyPayment = $totalPayable / $months;
    $_SESSION['monthlyPayment'] = $monthlyPayment;
} else {
    $monthlyPayment = $_SESSION['monthlyPayment'];
}

if (!isset($_SESSION['next_due_date'])) {
    $currentDate = date('Y-m-d');
    $next_due_date = date('Y-m-d', strtotime("+1 month", strtotime($currentDate)));
    $_SESSION['next_due_date'] = $next_due_date;
} else {
    $next_due_date = $_SESSION['next_due_date'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Loan Details</title>
  <style>
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
    .form-input {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-button {
      background-color: #6b4e31;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .form-button:hover {
      background-color: #5a3e27;
    }
  </style>
</head>
<body>

  <nav class="navbar">
    <h1>Coffeenect - Admin</h1>
    <div>
      <a href="apply_loan.php">Application</a>
      <a href="login_user.php">Log-out</a>
    </div>
  </nav>

  <div class="dashboard-container">
    <h1>Admin Loan Management</h1>

    <form method="POST" action="">
      <div class="card">
        <h2>Update Loan Details</h2>
        <label for="interestRate">Interest Rate (%)</label>
        <input type="number" name="interestRate" id="interestRate" class="form-input" value="<?php echo $interestRate; ?>" step="0.1" required>
        
        <label for="months">Loan Term (Months)</label>
        <input type="number" name="months" id="months" class="form-input" value="<?php echo $months; ?>" required>

        <label for="monthlyPayment">Monthly Payment (₱)</label>
        <input type="number" name="monthlyPayment" id="monthlyPayment" class="form-input" value="<?php echo number_format($monthlyPayment, 2); ?>" required>

        <label for="dueDate">Next Due Date</label>
        <input type="date" name="dueDate" id="dueDate" class="form-input" value="<?php echo $next_due_date; ?>" required>

        <button type="submit" name="update_loan" class="form-button">Update Loan Details</button>
      </div>
    </form>


    <div class="card">
      <h2>Updated Loan Details</h2>
      <p><strong>Loan Amount:</strong> ₱<?php echo number_format($loan_amount, 2); ?></p>
      <p><strong>Interest Rate:</strong> <?php echo $interestRate; ?>%</p>
      <p><strong>Monthly Payment:</strong> ₱<?php echo number_format($monthlyPayment, 2); ?></p>
      <p><strong>Next Due Date:</strong> <?php echo $next_due_date; ?></p>
    </div>
  </div>
  
</body>
</html>
