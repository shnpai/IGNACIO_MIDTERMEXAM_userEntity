<?php require_once 'core/dbConfig.php'; ?> 
<?php require_once 'core/models.php'; ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Delete Borrower Confirmation</title> 
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        h1 {
            color: #4CAF50;
        }

        .confirmation {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php 
    $getBorrowerByID = getBorrowerByID($pdo, $_GET['borrower_id']); 
    ?>
    
    <div class="confirmation">
        <h1>Are you sure you want to delete this Borrower?</h1> 
        <h2>Borrower Name: <?php echo $getBorrowerByID['borrower_name']; ?></h2>
        <h2>Loan Amount: <?php echo $getBorrowerByID['loan_amount']; ?></h2>
        <h2>Interest Rate: <?php echo $getBorrowerByID['interest_rate']; ?></h2>
        <h2>Lender: <?php echo $getBorrowerByID['lender']; ?></h2>
        <h2>Repayment Schedule: <?php echo $getBorrowerByID['repayment_schedule']; ?></h2>
        <h2>Date Added: <?php echo $getBorrowerByID['date_added']; ?></h2>

        <div>
            <form action="core/handleForms.php?borrower_id=<?php echo $_GET['borrower_id']; ?>&lender_id=<?php echo $_GET['lender_id']; ?>" method="POST">
                <input type="submit" name="deleteBorrowerBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this borrower?');" style="padding: 10px; border-radius: 5px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            </form>			
        </div>	
    </div>
</body>
</html>
