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
  <title>Manage Loans - Coffeenect</title>
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
  position: relative;
  overflow: hidden; 
}

.background-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: url('coffee.png') no-repeat center center;
  background-size: cover;
  filter: blur(3px);
  z-index: -1;
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
  z-index: 2;
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
  width: 95%;
  max-width: 1200px;
  background-color: #fff;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  text-align: center;
  margin-top: 120px; 
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

.table-scroll {
  max-height: 400px; 
  overflow-y: auto; 
  margin-top: 20px; 
  border: 1px solid #ddd; 
}

table {
  width: 100%;
  border-collapse: collapse;
}

table th, table td {
  padding: 15px;
  border: 1px solid #ddd;
  text-align: center;
}

table th {
  background-color: #6b4e31;
  color: white;
  position: sticky; 
  top: 0; 
  z-index: 1; 
}

table td {
  background-color: #fff;
}

.accept-btn, .deny-btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  color: white;
  margin: 5px;
}

.accept-btn {
  background-color: #28a745;
}

.deny-btn {
  background-color: #dc3545;
}

.accept-btn:hover {
  background-color: #218838;
}

.deny-btn:hover {
  background-color: #c82333;
}

.status-dropdown {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  width: 100%;
}
</style>
  <script>
    function filterLoans() {
      const filterValue = document.getElementById('loanStatusFilter').value;
      if (filterValue === 'accepted') {
        window.location.href = 'accepted_loans.php';
      } else if (filterValue === 'denied') {
        window.location.href = 'denied_loans.php';
      } else if (filterValue === 'pending') {
        window.location.href = 'manage_loans.php';
      } else {
        alert('Unexpected filter value');
      }
    }
  </script>
</head>
<body>
  <div class="background-image"></div>
  <nav class="navbar">
    <h1>Coffeenect - Manage Loans</h1>
    <div>
      <a href="login_admin.php">Log-out</a>
    </div>
  </nav>

  <div class="dashboard-container">
    <h1>Manage Loan Applications</h1>
    <div class="filter-container">
      <label for="loanStatusFilter">Filter by Status:</label>
      <select id="loanStatusFilter" onchange="filterLoans()">
        <option value="pending" selected>Pending</option>
        <option value="accepted">Accepted</option>
        <option value="denied">Denied</option>
      </select>
    </div>
    <div class="table-scroll">
    <table>
      <thead>
        <tr>
          <th>Membership ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Purpose</th>
          <th>Loan Amount</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM tblapplication WHERE status = 'pending'";
          $result = $db->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['membership_id'] . "</td>";
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>" . $row['email'] . "</td>";
              echo "<td>" . $row['purpose'] . "</td>";
              echo "<td>$" . number_format($row['loan_amount'], 2) . "</td>";
              echo "<td>" . $row['status'] . "</td>";
              echo "<td>";
              echo "<form action='' method='post' style='display: inline;'>";
              echo "<input type='hidden' name='membership_id' value='" . $row['membership_id'] . "'>";
              echo "<button type='submit' name='action' value='accept' class='accept-btn'>Accept</button>";
              echo "<button type='submit' name='action' value='deny' class='deny-btn'>Deny</button>";
              echo "</form>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo '<tr><td colspan="8">No loan applications found.</td></tr>';
          }

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $membership_id = $_POST['membership_id'];
            $action = $_POST['action'];

            if ($action == 'accept') {
              $new_status = 'accepted';
            } elseif ($action == 'deny') {
              $new_status = 'denied';
            }

            $update_sql = "UPDATE tblapplication SET status = '$new_status' WHERE membership_id = '$membership_id'";
            if ($db->query($update_sql) === TRUE) {
              echo "<script>window.location.href='manage_loans.php';</script>";
            } else {
              echo "<script>alert('Error updating loan status: " . $db->error . "');</script>";
            }
          }

          $db->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
