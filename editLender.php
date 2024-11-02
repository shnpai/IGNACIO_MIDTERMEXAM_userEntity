<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Lender</title>
	<link rel="stylesheet" href="styles.css">
</head>
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

        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1.1em;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
<body>
	<a href="index.php" class="return-home-btn">Return to home</a>
	<?php 
		$getLenderByID = getLenderByID($pdo, $_GET['lender_id']); 
		if (!$getLenderByID) {
			echo "<p>Error: Lender not found.</p>";
			exit;
		}
	?>
	<h1>Modify Lender Details</h1>
	<form action="core/handleForms.php?lender_id=<?php echo $_GET['lender_id']; ?>" method="POST">
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="firstName" value="<?php echo htmlspecialchars($getLenderByID['first_name']); ?>" required>
		</p>
		<p>
			<label for="lastName">Last Name</label> 
			<input type="text" name="lastName" value="<?php echo htmlspecialchars($getLenderByID['last_name']); ?>" required>
		</p>
		<p>
			<label for="ContactInfo">Contact Information</label> 
			<input type="text" name="ContactInfo" value="<?php echo htmlspecialchars($getLenderByID['contact_info']); ?>" required>
		</p>
		<p>
			<label for="homeAddress">Home Address</label> 
			<input type="text" name="homeAddress" value="<?php echo htmlspecialchars($getLenderByID['home_address']); ?>" required>
		</p>
		<p>
			<label for="maxBorrowers">Max Borrowers</label> 
			<input type="number" name="maxBorrowers" value="<?php echo htmlspecialchars($getLenderByID['max_borrowers']); ?>" required>
		</p>
		<p>
			<input type="submit" name="editLenderBtn">
		</p>
	</form>
</body>
</html>
