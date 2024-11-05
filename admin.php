<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffeenect Lending Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f1f8f6;
            display: flex;
            flex-direction: column;
            padding: 20px;
            align-items: center;
        }

        /* Navigation bar styles */
        .navbar {
            width: 100%;
            background-color: #00704a;
            padding: 10px;
            display: flex;
            justify-content: flex-start;
            margin-bottom: 10px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .navbar a {
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin: 0 10px;
        }

        .navbar a.active {
            background-color: #1e3932;
        }

        .container {
            width: 60%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-top: 120px;lay: none; /* Hidden by default */
        }

        h1 {
            text-align: center;
            color: #1e3932;
            margin-bottom: 15px;
        }

        .card {
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 15px;
        }

        .info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #2c2c2c;
            margin-bottom: 3px;
            display: block;
        }

        .editable-input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .checkbox-container input {
            margin-right: 5px;
            transform: scale(1.1);
        }

        .actions {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .actions button {
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            background-color: #d4e9e2;
            color: #1e3932;
        }

        /* Status buttons styles */
        .status-buttons {
            width: 100%;
            display: flex;
            justify-content: flex-start; /* Move Pending Applicants button to the left */
            margin-top: 80px;margin-top: 80px;in
        }

        .status-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #00704a;
            color: white;
            font-weight: bold;
        }

        .status-buttons button.active {
            background-color: #1e3932;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="/">Coffeenect Admin </a>
    </div>

    <!-- Status Buttons -->
    <div class="status-buttons">
        <button onclick="window.location.href='?status=pending'" class="<?php echo ($_GET['status'] ?? '') == 'pending' ? 'active' : ''; ?>">Pending Applications</button>
        <button onclick="window.location.href='approved_applications.html'">Approved Applications</button>
        <button onclick="window.location.href='denied_applications.html'">Denied Applications</button>
    </div>

    <?php
    // Get the selected applicant from the form submission
    $status = $_GET['status'] ?? '';

    // Display the dashboard based on the selected status
    if ($status == 'pending') {
        // Pending Applicant - Sample Applicant
    ?>
        <div class="container" style="display: block;">
            <h1>Mr. Sample </h1>
            <div class="card">
                <div class="info">
                    <div>
                        <label class="info-label" for="dob-3">Date of Birth:</label>
                        <input type="date" id="dob-3" class="editable-input" value="1992-07-15">
                    </div>
                    <div>
                        <label class="info-label" for="email-3">Email:</label>
                        <input type="email" id="email-3" class="editable-input" value="Sample@example.com">
                    </div>
                    <div>
                        <label class="info-label" for="phone-3">Phone Number:</label>
                        <input type="tel" id="phone-3" class="editable-input" value="+1234509876">
                    </div>
                    <div>
                        <label class="info-label" for="loan-amount-3">Loan Amount (Max: ₱5000):</label>
                        <input type="number" id="loan-amount-3" class="editable-input" value="4000" min="0" max="5000">
                    </div>
                    <div>
                        <label class="info-label" for="purpose-3">Purpose of Loan:</label>
                        <input type="text" id="purpose-3" class="editable-input" value="Crops">
                    </div>
                    <div>
    <label class="info-label" for="membership-card-status">Membership Card Submitted:</label>
    <select id="membership-card-status" class="editable-input">
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>
</div>
                    <div>
                        <label class="info-label" for="status-3">Membership Status:</label>
                        <select id="status-3" class="editable-input">
                            <option value="active">Active</option>
                            <option value="inactive" selected>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="actions">
                    <button>Approve</button>
                    <button>Deny</button>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</body>
</html>
