<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        .return-home-btn {
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
        }

        .return-home-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <a href="index.php" class="return-home-btn">Return to home</a>
    <div class="confirmation">
        <h1>Are you sure you want to delete this Lender?</h1>
        <?php $getLenderByID = getLenderByID($pdo, $_GET['lender_id']); ?>
        <h2>First Name: <?php echo $getLenderByID['first_name']; ?></h2>
        <h2>Last Name: <?php echo $getLenderByID['last_name']; ?></h2>
        <h2>Contact Information: <?php echo $getLenderByID['contact_info']; ?></h2>
        <h2>Home Address: <?php echo $getLenderByID['home_address']; ?></h2>
        <h2>Max Borrowers: <?php echo $getLenderByID['max_borrowers']; ?></h2>
        <h2>Date Added: <?php echo $getLenderByID['date_added']; ?></h2>

        <div>
            <form action="core/handleForms.php?lender_id=<?php echo $_GET['lender_id']; ?>" method="POST">
                <input type="submit" name="deleteLenderBtn" value="Delete" style="padding: 10px; border-radius: 5px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">
            </form>			
        </div>	
    </div>
</body>
</html>
