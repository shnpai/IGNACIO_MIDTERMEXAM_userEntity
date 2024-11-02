<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Borrower</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f7f7f7;
    }
    h1 {
        color: #333;
    }
    .return-link {
        text-decoration: none;
        color: white;
        background-color: #4CAF50;
        padding: 10px 15px;
        border-radius: 5px;
        display: inline-block;
        margin-bottom: 20px;
    }
    form {
        margin-top: 20px;
        padding: 20px;
        background-color: #fff;
        border: 2px solid lightgreen;
        border-radius: 8px;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"], input[type="number"], input[type="date"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
<body>
	<a href="viewBorrowers.php?lender_id=<?php echo $_GET['lender_id']; ?>" class="return-link">View the borrowers</a>
	<h1>Modify Borrower Details</h1>
	<?php 
		$getBorrowerByID = getBorrowerByID($pdo, $_GET['borrower_id']); 
		if (!$getBorrowerByID) {
			echo "<p>Error: Borrower not found.</p>";
			exit;
		}
	?>
	<form action="core/handleForms.php?borrower_id=<?php echo $_GET['borrower_id']; ?>&lender_id=<?php echo $_GET['lender_id']; ?>" method="POST">
		<p>
			<label for="borrowerName">Borrower Name</label> 
			<input type="text" name="borrowerName" value="<?php echo htmlspecialchars($getBorrowerByID['borrower_name']); ?>" required>
		</p>
		<p>
			<label for="loanAmount">Loan Amount</label> 
			<input type="number" name="loanAmount" value="<?php echo htmlspecialchars($getBorrowerByID['loan_amount']); ?>" required>
		</p>
		<p>
			<label for="interestRate">Interest Rate</label> 
			<input type="number" step="0.01" name="interestRate" value="<?php echo htmlspecialchars($getBorrowerByID['interest_rate']); ?>" required>
		</p>
		<p>
			<label for="repaymentSchedule">Repayment Schedule</label> 
			<input type="date" name="repaymentSchedule" value="<?php echo htmlspecialchars($getBorrowerByID['repayment_schedule']); ?>" required>
		</p>
		<p>
			<input type="submit" name="editBorrowerBtn" value="Save Changes">
		</p>
	</form>
</body>
</html>
