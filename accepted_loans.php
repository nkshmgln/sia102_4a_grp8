<?php
include "mycon.php";


$db = mysqli_connect("localhost:3306", "root", "", "lending");
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

// Update interest rate logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_interest'])) {
  $membership_id = $_POST['membership_id'];
  $interest_rate = $_POST['interest_rate'];

  
  if (empty($interest_rate)) {
    $interest_rate = 2;  
  }

  
  $update_sql = "UPDATE tblapplication SET interest_rate = '$interest_rate' WHERE membership_id = '$membership_id'";
  if (mysqli_query($db, $update_sql)) {
    echo "<script>alert('Interest rate updated successfully!');</script>";
  } else {
    echo "<script>alert('Error updating interest rate: " . mysqli_error($db) . "');</script>";
  }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reassess'])) {
  $membership_id = $_POST['membership_id'];

  
  $reassess_sql = "UPDATE tblapplication SET status = 'pending' WHERE membership_id = '$membership_id'";
  if (mysqli_query($db, $reassess_sql)) {
    
    echo "<script>
            alert('Loan reassessed and status updated to pending!');
            window.location.href = 'manage_loans.php';
          </script>";
  } else {
    echo "<script>alert('Error reassessing loan: " . mysqli_error($db) . "');</script>";
  }
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffeenect Dashboard - Accepted Loans</title>
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
    .background-image {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('coffee.png') no-repeat center center fixed;
      background-size: cover;
      filter: blur(5px);
      z-index: 1;
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
      width: 85%;
      max-width: 1000px;
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
    .filter-container {
      margin-bottom: 30px;
      display: flex;
      justify-content: flex-start;
      width: 100%;
    }
    .filter-container label {
      margin-right: 15px;
      font-weight: bold;
      font-size: 1.1rem;
    }
    .filter-container select {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f0e1d2;
    }
    .table-responsive {
      width: 100%;
      overflow-x: auto;
    }
  </style>
</head>
<body>

  <nav class="navbar">
    <h1>Coffeenect - Accepted Loans</h1>
    <div>
      <a href="login_admin.php">Log-out</a>
    </div>
  </nav>

 
  <div class="dashboard-container">
    <h1>Accepted Loan Applications</h1>
    <div class="filter-container">
      <label for="loanStatusFilter">Filter by Status:</label>
      <select id="loanStatusFilter" onchange="filterLoans()">
        <option value="accepted" selected>Accepted</option>
        <option value="denied">Denied</option>
        <option value="pending">Pending</option>
      </select>
    </div>
    <script>
      function filterLoans() {
        const filterValue = document.getElementById('loanStatusFilter').value;
        if (filterValue === 'accepted') {
          window.location.href = 'accepted_loans.php';
        } else if (filterValue === 'denied') {
          window.location.href = 'denied_loans.php';
        } else if (filterValue === 'pending') {
          window.location.href = 'manage_loans.php';
        }
      }
    </script>
    <div class="table-responsive">
      <table border="1">
        <tr>
          <th>Membership ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Purpose</th>
          <th>Loan Amount</th>
          <th>Interest Rate</th>
          <th>Action</th>
        </tr>
        <?php
          // Fetch accepted loan applications from the database
          $sql = "SELECT * FROM tblapplication WHERE status = 'accepted'";
          $result = mysqli_query($db, $sql);

          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // If interest rate is not set, set it to 2% by default
              $interest_rate = $row['interest_rate'] ? $row['interest_rate'] : 2;
              echo "<form method='POST' action=''>";
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['membership_id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>" . htmlspecialchars($row['purpose']) . "</td>";
              echo "<td>$" . number_format($row['loan_amount'], 2) . "</td>";
              echo "<td>
                      <input type='number' name='interest_rate' value='" . htmlspecialchars($interest_rate) . "' step='0.01' min='0' required />
                      <button type='submit' name='update_interest' value='1'>Update</button>
                    </td>";
              echo "<td>
                      <button type='submit' name='reassess' value='1'>Reassess</button>
                    </td>";
              echo "<input type='hidden' name='membership_id' value='" . htmlspecialchars($row['membership_id']) . "' />";
              echo "</tr>";
              echo "</form>";
            }
          } else {
            echo "<tr><td colspan='7'>No accepted loans found.</td></tr>";
          }

          mysqli_close($db);
        ?>
      </table>
    </div>
  </div>
</body>
</html>
