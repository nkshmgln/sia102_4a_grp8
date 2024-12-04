<?php
include "mycon.php";

$db = mysqli_connect("localhost:3306", "root", "", "lending");
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffeenect Dashboard - Denied Loans</title>
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
    /* Navigation bar styling */
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
    /* Dashboard container styling */
    .dashboard-container {
      width: 85%;
      max-width: 1000px;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin-top: 80px; /* Offset for fixed navbar */
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
  <script>
    function confirmReassess(membershipId) {
      if (confirm("Are you sure you want to reassess this loan application?")) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'membership_id';
        input.value = membershipId;
        form.appendChild(input);

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'reassess';
        form.appendChild(actionInput);

        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar">
    <h1>Coffeenect - Denied Loans</h1>
    <div>
      <a href="login_admin.php">Log-out</a>
    </div>
  </nav>

  <!-- Dashboard Container -->
  <div class="dashboard-container">
    <h1>Denied Loan Applications</h1>
    <div class="filter-container">
      <label for="loanStatusFilter">Filter by Status:</label>
      <select id="loanStatusFilter" onchange="filterLoans()">
        <option value="denied" selected>Denied</option>
        <option value="pending">Pending</option>
        <option value="accepted">Accepted</option>
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
          // Fetch denied loan applications from the database
          $sql = "SELECT * FROM tblapplication WHERE status = 'denied'";
          $result = mysqli_query($db, $sql);

          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['membership_id']) . "</td>";
              echo "<td>" . htmlspecialchars($row['name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>" . htmlspecialchars($row['purpose']) . "</td>";
              echo "<td>$" . number_format($row['loan_amount'], 2) . "</td>";
              echo "<td>2% <button type='button' onclick=\"window.location.href='edit_interest.php?id=" . htmlspecialchars($row['membership_id']) . "'\">Edit</button></td>";
              echo "<td><button type='button' onclick='confirmReassess(" . htmlspecialchars($row['membership_id']) . ")'>Reassess</button></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='8'>No denied loans found.</td></tr>";
          }

          if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'reassess') {
            $membership_id = $_POST['membership_id'];
            $update_sql = "UPDATE tblapplication SET status = 'pending' WHERE membership_id = '$membership_id'";
            if (mysqli_query($db, $update_sql)) {
              echo "<script>window.location.href='manage_loans.php';</script>";
            } else {
              echo "<script>alert('Error updating loan status: " . mysqli_error($db) . "');</script>";
            }
          }

          mysqli_close($db);
        ?>
      </table>
    </div>
  </div>
</body>
</html>
