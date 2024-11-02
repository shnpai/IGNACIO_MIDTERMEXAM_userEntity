<?php 
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        h1, h2, h3 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            margin: 10px 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background: #e7f3fe;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
	<?php if (isset($_SESSION['message'])) { ?>
		<h1 class="error-message"><?php echo $_SESSION['message']; ?></h1>
	<?php } unset($_SESSION['message']); ?>

	<?php if (isset($_SESSION['username'])) { ?>
		<h1>Hello there! <?php echo $_SESSION['username']; ?></h1>
		<?php include 'navbar.php'; ?>
	<?php } else { echo "<h1>No user logged in</h1>";} ?>

	<h3>Users List</h3>
	<ul>
		<?php $getAllUsers = getAllUsers($pdo); ?>
		<?php foreach ($getAllUsers as $row) { ?>
			<li>
				<?php echo $row['username']; ?></a>
			</li>
		<?php } ?>
	</ul>
</body>
</html>
