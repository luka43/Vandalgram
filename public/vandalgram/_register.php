<?php
$account_created = false;
// Database credentials
include "../../OjN2RyD5UKg3ZM.Mxh5N.php";

// Try and connect using the info above.If there is an error with the connection, stop the script and display the error.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {

	exit('Failed to connect to MySQL: ' . mysqli_connect_error() . "<br>");
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {

	// Could not get the data that should have been sent.
	exit('Please complete the registration form!<br>');
}

// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {

	// One or more values are empty.
	exit('Please complete the registration form<br>');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email is not valid!<br>');
}
$usrname = strtolower($_POST['username']);
// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password, email FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $usrname);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.

	if ($stmt->num_rows > 0) {
		// Username already exists
		echo "<div style='color: red'><p>Username exists, please choose another!<br>";
	} else {

		// We need to check if the account with that email exists.
		if ($stmt = $con->prepare('SELECT id, password, email FROM accounts WHERE email = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
			$stmt->bind_param('s', $_POST['email']);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows > 0) {
				// Username already exists
				echo "<div style='color: red'><p>Email already exists, please choose another!<br>";
			} else {

				if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code, role) VALUES (?, ?, ?, ?, ?)')) {
					// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$uniqid = uniqid();
					$role = 'user';
					$stmt->bind_param('sssss', $usrname, $password, $_POST['email'], $uniqid, $role);
					$stmt->execute();

					$from    = 'noreply@vandalgram.com';
					$subject = 'Account Activation Required';
					$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
					// Update the activation variable below
					$activate_link = 'http://vandalgram.com/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
					$message = '<p><b>Vandalgram account activation</b></p><hr>
					<p>Please click the following link to confirm your email and activate your account:</p>
					<p><a href="' . $activate_link . '">' . $activate_link . '</a></p><br>
					<hr>
					<p>If you didn\'t made a request for a Sign Up to Vandalgram, please ignore this email or contact us: <a href="mailto:info@vandalgram.com">info@vandalgram.com</a></p>';
					mail($_POST['email'], $subject, $message, $headers);
					echo "<div class='header'><p>Please check your email to activate your account!<br></p></div>";
					mysqli_close($con);
					$account_created = true;
				} else {

					// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
					echo "<div style='color: red'><p>Could not prepare statement!<br>";
				}
			}
		} else {
			// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
			echo "<div style='color: red'><p>Could not prepare statement!<br>";
		}
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	echo "<div style='color: red'><p>Could not prepare statement!<br>";
}

// Gallery Database credentials
include "qjsxBK5iNdKKraM8.php";

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {

	// If there is an error with the connection, stop the script and display the error.
	exit("<div style='color: red'>Failed to connect to MySQL: " . mysqli_connect_error() . "<br>");
}

if ($account_created) {
	if ($stmt = $con->prepare("CREATE TABLE " . $usrname . " (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		title VARCHAR(30) NOT NULL,
		category VARCHAR(50),
		description VARCHAR(255) NOT NULL,
		country VARCHAR(20) NOT NULL,
		city VARCHAR(20) NOT NULL,
		year INT(5) NOT NULL,
		url VARCHAR(30) NOT NULL,
		gps VARCHAR(30) NOT NULL,
		likes INT(6) NOT NULL,
		upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)")) {
		$stmt->execute();
		echo "<p>Gallery created.</p><br>";
		$stmt->close();
	} else {
		// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
		echo "<div style='color: red'><p>Error while creating gallery<br>";
	}
}

mysqli_close($con);
