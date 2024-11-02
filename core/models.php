<?php  

require_once 'dbConfig.php';

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {

	$checkUserSql = "SELECT * FROM user_accounts WHERE username = ?";
	$checkUserSqlStmt = $pdo->prepare($checkUserSql);
	$checkUserSqlStmt->execute([$username]);

	if ($checkUserSqlStmt->rowCount() == 0) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) VALUES(?,?,?,?)";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$username, $first_name, $last_name, $password]);

		if ($executeQuery) {
			$_SESSION['message'] = "User successfully inserted";
			return true;
		}

		else {
			$_SESSION['message'] = "An error occured from the query";
		}

	}
	else {
		$_SESSION['message'] = "User already exists";
	}

	
}



function loginUser($pdo, $username, $password) {
	$sql = "SELECT * FROM user_accounts WHERE username=?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$username]); 

	if ($stmt->rowCount() == 1) {
		$userInfoRow = $stmt->fetch();
		$userIDFromDB = $userInfoRow['user_id']; 
		$usernameFromDB = $userInfoRow['username']; 
		$passwordFromDB = $userInfoRow['password'];

		if ($password == $passwordFromDB) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			$_SESSION['message'] = "Login successful!";
			return true;
		}

		else {
			$_SESSION['message'] = "The password is incorrect, but user exists.";
		}
	}

	
	if ($stmt->rowCount() == 0) {
		$_SESSION['message'] = "Username does not exist. You may register first.";
	}

}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}



// Insert a new lender into the database
function insertLender($pdo, $first_name, $last_name, $contact_info, $home_address, $max_borrowers, $user_id) {
    $sql = "INSERT INTO lenders (first_name, last_name, contact_info, home_address, max_borrowers, added_by, date_added, last_updated) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$first_name, $last_name, $contact_info, $home_address, $max_borrowers, $user_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
}



// Insert a new Borrower into the database
function insertBorrower($pdo, $borrower_name, $loan_amount, $interest_rate, $repayment_schedule, $lender_id, $user_id) {
    $sql = "INSERT INTO borrowers (borrower_name, loan_amount, interest_rate, repayment_schedule, lender_id, added_by, date_added) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$borrower_name, $loan_amount, $interest_rate, $repayment_schedule, $lender_id, $user_id, date('Y-m-d H:i:s')]);
}

// Update a lender details
// Update a lender's details
function updateLender($pdo, $lender_id, $first_name, $last_name, $contact_info, $home_address, $max_borrowers, $user_id) {
    $sql = "UPDATE lenders SET first_name = ?, last_name = ?, contact_info = ?, home_address = ?, max_borrowers = ?, updated_by = ?, last_updated = ? WHERE lender_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$first_name, $last_name, $contact_info, $home_address, $max_borrowers, $user_id, date('Y-m-d H:i:s'), $lender_id]);
}



// Delete a lender and their associated borrowers
function deleteLender($pdo, $lender_id) {
	$deleteBorrower = "DELETE FROM borrowers WHERE lender_id = ?";
	$deleteStmt = $pdo->prepare($deleteBorrower);
	$executeDeleteQuery = $deleteStmt->execute([$lender_id]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM lenders WHERE lender_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$lender_id]);

		if ($executeQuery) {
			return true; // Successful deletion
		}
	}
}

// Retrieve all lenders from the database
function getAllLenders($pdo) {
    $sql = "SELECT lender_id, first_name, last_name, contact_info, home_address, max_borrowers, date_added, added_by, updated_by, last_updated FROM lenders";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Retrieve a specific lender by their ID
function getLenderByID($pdo, $lender_id) {
    $sql = "SELECT * FROM lenders WHERE lender_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$lender_id]);

    if ($executeQuery) {
        return $stmt->fetch(); // Return lender details
    }
}

// Retrieve all information for a lender by their ID
function getAllInfoByLenderID($pdo, $lender_id) {
	$sql = "SELECT * FROM lenders WHERE lender_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$lender_id]);

	if ($executeQuery) {
		return $stmt->fetch(); // Return lender information
	}
}

// Get all borrowers associated with a specific lender
function getBorrowersByLender($pdo, $lender_id) {
    $sql = "SELECT 
                borrowers.borrower_id AS borrower_id,
                borrowers.borrower_name AS borrower_name,
                borrowers.loan_amount AS loan_amount,
                borrowers.interest_rate AS interest_rate,
                borrowers.repayment_schedule AS repayment_schedule,
				borrowers.date_added AS date_added,
                borrowers.added_by AS added_by,
                borrowers.updated_by AS updated_by,
                borrowers.last_updated AS last_updated,
                CONCAT(lenders.first_name,' ',lenders.last_name) AS lender
            FROM borrowers
            JOIN lenders ON borrowers.lender_id = lenders.lender_id
            WHERE borrowers.lender_id = ?";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$lender_id]);
    if ($executeQuery) {
        return $stmt->fetchAll(); // Return all borrowers for the lender
    }
}


// Retrieve a specific borrower by their ID
function getBorrowerByID($pdo, $borrower_id) {
	$sql = "SELECT 
				borrowers.borrower_id AS borrower_id,
				borrowers.borrower_name AS borrower_name,
				borrowers.loan_amount AS loan_amount,
				borrowers.interest_rate AS interest_rate,
				borrowers.repayment_schedule AS repayment_schedule,
				CONCAT(lenders.first_name,' ',lenders.last_name) AS lender,
				borrowers.repayment_schedule AS repayment_schedule,
				borrowers.date_added AS date_added
			FROM borrowers
			JOIN lenders ON borrowers.lender_id = lenders.lender_id
			WHERE borrowers.borrower_id  = ? 
			GROUP BY borrowers.borrower_name";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$borrower_id]);
	if ($executeQuery) {
		return $stmt->fetch(); // Return borrower details
	}
}

// Update an existing borrower's details
function updateBorrower($pdo, $borrower_name, $loan_amount, $interest_rate, $repayment_schedule, $borrower_id, $user_id) {
    $sql = "UPDATE borrowers SET borrower_name = ?, loan_amount = ?, interest_rate = ?, repayment_schedule = ?, last_updated = ?, updated_by = ? WHERE borrower_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$borrower_name, $loan_amount, $interest_rate, $repayment_schedule, date('Y-m-d H:i:s'), $user_id, $borrower_id]);
}
// Delete a borrower from the database
function deleteBorrower($pdo, $borrower_id) {
	$sql = "DELETE FROM borrowers WHERE borrower_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$borrower_id]);
	if ($executeQuery) {
		return true; // Successful deletion
	}
}


?>
