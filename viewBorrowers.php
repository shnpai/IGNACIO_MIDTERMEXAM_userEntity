<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>View Borrowers</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f7f7f7;
    }
    h1, h3 {
        color: #333;
    }
    .return-home-btn {
        text-decoration: none;
        color: white;
        background-color: #4CAF50;
        padding: 10px 15px;
        border-radius: 5px;
        display: inline-block;
        margin-bottom: 20px;
    }
    form {
        margin-bottom: 30px;
    }
    label {
        font-weight: bold;
    }
    input[type="text"], input[type="number"], input[type="date"] {
        width: 40%;
        padding: 10px;
        margin-top: 5px;
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
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .action-links a {
        text-decoration: none;
        color: #4CAF50;
        margin-right: 10px;
    }
    .action-links a:hover {
        text-decoration: underline;
    }
</style>
<body>
	<a href="index.php" class="return-home-btn">Return to home</a>
	<?php $getAllInfoByLenderID = getAllInfoByLenderID($pdo, $_GET['lender_id']); ?>
	<h1>Lender ID: <?php echo htmlspecialchars($getAllInfoByLenderID['lender_id']); ?></h1>
	<h3>Add a new Borrower to <?php echo htmlspecialchars($getAllInfoByLenderID['first_name']); ?></h3>
	<form action="core/handleForms.php?lender_id=<?php echo $_GET['lender_id']; ?>" method="POST">
		<p>
			<label for="borrowerName">Borrower Name</label> 
			<input type="text" name="borrowerName" required>
		</p>
		<p>
		    <label for="loanAmount">Loan Amount</label> 
            <input type="number" name="loanAmount" required>
		</p>
		<p>
		    <label for="interestRate">Interest Rate</label> 
            <input type="number" step="0.01" name="interestRate" required>
		</p>
		<p>
			<label for="repaymentSchedule">Repayment Schedule</label> 
			<input type="date" name="repaymentSchedule" required>
		</p>
		<p>
			<input type="submit" name="insertNewBorrowerBtn">
		</p>
	</form>

	<table style="width:100%; margin-top: 50px;">
	  <tr>
	    <th>Borrower ID</th>
	    <th>Borrower Name</th>
	    <th>Loan Amount</th>
	    <th>Interest Rate</th>
	    <th>Lender</th>
	    <th>Repayment Schedule</th>
	    <th>Date Added</th>
		<th>Added By</th>
        <th>Updated By</th>
        <th>Last Updated</th>
	    <th>Action</th>
	  </tr>
	  <?php $getBorrowersByLender = getBorrowersByLender($pdo, $_GET['lender_id']); ?>
	  <?php if (empty($getBorrowersByLender)) { ?>
	    <tr><td colspan='11'>No Borrowers found for this Lender.</td></tr>
	  <?php } else { ?>
		<?php foreach ($getBorrowersByLender as $row) { ?>
		<tr>
	  		<td><?php echo htmlspecialchars($row['borrower_id']); ?></td>	  	
	  		<td><?php echo htmlspecialchars($row['borrower_name']); ?></td>	  	
	  		<td><?php echo htmlspecialchars($row['loan_amount']); ?></td>	  	
	  		<td><?php echo htmlspecialchars($row['interest_rate']); ?></td>	  	
	  		<td><?php echo htmlspecialchars($row['lender']); ?></td>	  	
	  		<td><?php echo htmlspecialchars($row['repayment_schedule']); ?></td>	  	
	  		<td><?php echo htmlspecialchars($row['date_added']); ?></td>
			<td><?php echo htmlspecialchars($row['added_by']); ?></td>
			<td><?php echo htmlspecialchars($row['updated_by']); ?></td>
			<td><?php echo htmlspecialchars($row['last_updated']); ?></td>
	  		<td>
	  			<a href="editBorrower.php?borrower_id=<?php echo $row['borrower_id']; ?>&lender_id=<?php echo $_GET['lender_id']; ?>">Edit</a>
	  			<a href="deleteBorrower.php?borrower_id=<?php echo $row['borrower_id']; ?>&lender_id=<?php echo $_GET['lender_id']; ?>">Delete</a>
	  		</td>	  	
		</tr>
		<?php } ?>
	  <?php } ?>
	</table>
</body>
</html>
