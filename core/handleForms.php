<?php 

// Include database configuration and models for database operations
require_once 'dbConfig.php'; 
require_once 'models.php';
require_once 'validate.php';

if (isset($_POST['registerUserBtn'])) {

	$username = sanitizeInput($_POST['username']);
	$first_name = sanitizeInput($_POST['first_name']);
	$last_name = sanitizeInput($_POST['last_name']);
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	if (!empty($username) && !empty($first_name) && !empty($last_name) 
		&& !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (validatePassword($password)) {

				$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, sha1($password));

				if ($insertQuery) {
					header("Location: ../login.php");
				}
				else {
					header("Location: ../register.php");
				}
			}

			else {
				$_SESSION['message'] = "The password must be at least 8 characters long and include uppercase letters, lowercase letters, and numbers.";
				header("Location: ../register.php");
			}
		}

		else {
			$_SESSION['message'] = "Verify that both passwords match.";
			header("Location: ../register.php");
		}
	
	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty!";

		header("Location: ../register.php");
	}

}




if (isset($_POST['loginUserBtn'])) {

	$username = sanitizeInput($_POST['username']);
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = loginUser($pdo, $username, $password);

		if ($loginQuery) {
			header("Location: ../index.php");
		}
		
		else {
			header("Location: ../login.php");
		}
	
	}

	else {
		$_SESSION['message'] = "Please make sure the input fields 
		are not empty!";
		header("Location: ../login.php");
	}
 
}


if (isset($_GET['logoutAUser'])) {
	unset($_SESSION['username']);
	header('Location: ../login.php');
}


// Insert new lender
if (isset($_POST['insertLenderBtn'])) {
    $user_id = $_SESSION['user_id']; // Get logged-in user's ID
    $query = insertLender($pdo, $_POST['firstName'], $_POST['lastName'], $_POST['ContactInfo'], $_POST['homeAddress'], $_POST['maxBorrowers'], $user_id);
    header("Location: ../index.php");
}

// Insert new borrower
if (isset($_POST['insertNewBorrowerBtn'])) {
    $user_id = $_SESSION['user_id']; // Get logged-in user's ID
    $query = insertBorrower($pdo, $_POST['borrowerName'], $_POST['loanAmount'], $_POST['interestRate'], $_POST['repaymentSchedule'], $_GET['lender_id'], $user_id);
    header("Location: ../viewBorrowers.php?lender_id=" . $_GET['lender_id']);
}
// Edit an existing lender
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editLenderBtn'])) {
    $lender_id = $_GET['lender_id']; // Get lender ID from the URL
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $contact_info = $_POST['ContactInfo'];
    $home_address = $_POST['homeAddress'];
    $max_borrowers = $_POST['maxBorrowers'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
    
    // Call the update function
    if (updateLender($pdo, $lender_id, $first_name, $last_name, $contact_info, $home_address, $max_borrowers, $user_id)) {
        $_SESSION['message'] = "Lender updated successfully!";
    } else {
        $_SESSION['message'] = "Failed to update lender.";
    }
    
    // Redirect back to the index page
    header("Location: ../index.php");
    exit;
}

// Delete a lender
if (isset($_POST['deleteLenderBtn'])) {
	$query = deleteLender($pdo, $_GET['lender_id']);

	if ($query) {
		header("Location: ../index.php"); // Redirect on success
	} else {
		echo "Deletion failed"; // Error message
	}
}



// Edit an existing borrower
if (isset($_POST['editBorrowerBtn'])) {
    $user_id = $_SESSION['user_id']; // Get logged-in user's ID
    $query = updateBorrower($pdo, $_POST['borrowerName'], $_POST['loanAmount'], $_POST['interestRate'], $_POST['repaymentSchedule'], $_GET['borrower_id'], $user_id);

	if ($query) {
		header("Location: ../viewBorrowers.php?lender_id=" .$_GET['lender_id']); // Redirect on success
	} else {
		echo "Update failed"; // Error message
	}
}

// Delete a borrower
if (isset($_POST['deleteBorrowerBtn'])) {
	$query = deleteBorrower($pdo, $_GET['borrower_id']);

	if ($query) {
		header("Location: ../viewBorrowers.php?lender_id=" .$_GET['lender_id']); // Redirect on success
	} else {
		echo "Deletion failed"; // Error message
	}
}

