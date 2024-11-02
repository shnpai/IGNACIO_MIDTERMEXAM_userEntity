<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P2P Lending Management System</title>

</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            margin-top: 20px;
        }
        form p {
            margin-bottom: 15px;
        }
        input {
            font-size: 1.5em;
            height: 50px;
            width: 200px;
        }
            .navbar {
            display: flex;
            justify-content: space-around;
            background: #4CAF50; 
            padding: 10px 0;
            position: fixed; 
            top: 0; 
            width: 100%;
            z-index: 1000; 
        }
        .container {
            margin-bottom: 20px;
            padding: 20px;
            background-color: white;
            border: 2px solid lightgreen; /* Your specified border */
            max-width: 700px; /* Set a max width to control size */
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Optional shadow */
        }
        .action a {
            margin-right: 10px;
        }
    </style>
<body>
    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
    <?php } unset($_SESSION['message']); ?>

    <?php if (isset($_SESSION['username'])) { ?>
        <h1>Hello there! <?php echo $_SESSION['username']; ?></h1>
        <?php include 'navbar.php'; ?>
    <?php } else { echo "<h1>No user logged in</h1>"; } ?>

    <h1>Welcome to P2P Money Lending Management System. Add a Lender here.</h1>
    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="firstName">First Name:</label> 
            <input type="text" name="firstName" required>
        </p>
        <p>
            <label for="lastName">Last Name:</label> 
            <input type="text" name="lastName" required>
        </p>
        <p>
            <label for="ContactInfo">Contact Information:</label> 
            <input type="text" name="ContactInfo" required>
        </p>
        <p>
            <label for="homeAddress">Home Address:</label> 
            <input type="text" name="homeAddress" required>
        </p>
        <p>
            <label for="maxBorrowers">Max Borrowers:</label>
            <input type="text" name="maxBorrowers" required>
        </p>
        <p>
            <input type="submit" name="insertLenderBtn">
        </p>
    </form>

    <?php $getAllLenders = getAllLenders($pdo); ?>
<?php foreach ($getAllLenders as $row) { ?>
    <div class="container">
        <h3>Lender's ID: <?php echo $row['lender_id']; ?></h3>
        <h3>First Name: <?php echo $row['first_name']; ?></h3>
        <h3>Last Name: <?php echo $row['last_name']; ?></h3>
        <h3>Contact Information: <?php echo $row['contact_info']; ?></h3>
        <h3>Home Address: <?php echo $row['home_address']; ?></h3>
        <h3>Max Borrowers: <?php echo $row['max_borrowers']; ?></h3>
        <h3>Date Added: <?php echo htmlspecialchars($row['date_added']); ?></h3>
        <h3>Added By: <?php echo htmlspecialchars($row['added_by']); ?></h3>
        <h3>Updated By: <?php echo htmlspecialchars($row['updated_by']); ?></h3>
        <h3>Last Updated: <?php echo htmlspecialchars($row['last_updated']); ?></h3>

        <div class="action">
            <a href="viewBorrowers.php?lender_id=<?php echo $row['lender_id']; ?>">View Borrowers</a>
            <a href="editLender.php?lender_id=<?php echo $row['lender_id']; ?>">Edit</a>
            <a href="deleteLender.php?lender_id=<?php echo $row['lender_id']; ?>">Delete</a>
        </div>
    </div> 
<?php } ?>

</body>
</html>
