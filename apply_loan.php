<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Loan - Coffeenect</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        .form-container {
            max-width: 900px;
            margin: 3rem auto;
            padding: 3rem;
            border: none;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 2.5rem;
            color: #6b4e31;
            font-weight: bold;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            max-width: 100%;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1.1rem;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6b4e31;
            box-shadow: 0 0 5px rgba(107, 78, 49, 0.3);
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            gap: 1.5rem;
        }

        .form-actions button,
        .form-actions a {
            padding: 1rem 3rem;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s;
        }

        .form-actions button {
            background-color: #6b4e31;
            font-weight: bold;
        }

        .form-actions button:hover {
            background-color: #5a3f27;
        }

        .form-actions .cancel-button {
            background-color: #888;
        }

        .form-actions .cancel-button:hover {
            background-color: #555;
        }

        @media (max-width: 768px) {
            .form-container {
                max-width: 90%;
                padding: 2rem;
                margin: 2rem auto;
            }
            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Apply for a Loan</h2>
        <form action="application.php" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="membership-id">Membership ID Number</label>
                <input type="text" id="membership_id" name="membership_id" required>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose of Loan</label>
                <textarea id="purpose" name="purpose" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="loan-amount">Loan Amount</label>
                <input type="number" id="loan_amount" name="loan_amount" min="1000" max="5000" step="500" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block" name="submit">Submit</button>
                <a href="loan_calculator.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
