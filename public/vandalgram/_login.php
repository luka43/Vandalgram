<?php
session_start();

// Database credentials
include "../../OjN2RyD5UKg3ZM.Mxh5N.php";

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {

    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password, activation_code FROM accounts WHERE username = ?')) {
    $usrname = strtolower($_POST['username']);
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $usrname);
    $stmt->execute();

    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $activation_code);
        $stmt->fetch();

        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password) && $activation_code == "activated") {

            if ($stmt = $con->prepare('SELECT display_name, crew, country, city, role FROM accounts WHERE username = ?')) {
                $stmt->bind_param('s', $usrname);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {

                    $stmt->bind_result($display_name, $crew, $country, $city, $role);
                    $stmt->fetch();

                    session_regenerate_id();
                    $_SESSION["loggedin"] = TRUE;
                    $_SESSION["role"] = $role;
                    $_SESSION["username"] = $usrname;
                    $_SESSION["displayname"] = $display_name;
                    $_SESSION['id'] = $id;
                    $_SESSION['crew'] = $crew;
                    $_SESSION["country"] = $country;
                    $_SESSION["city"] = $city;
                    $_SESSION["submited"] = 0;
                    header('Location: index.php');
                }
            }
        } else {
            if ($activation_code == "activated") {
                // Incorrect password
                // echo 'Incorrect username and/or password!!';
                $status = 2;
            } else {
                // echo 'Please check your email for activation code!';
                $status = 1;
            }
        }
    } else {

        // Incorrect username
        // echo 'Incorrect username and/or password!';
        $status = 2;
    }

    $stmt->close();
}
mysqli_close($con);
if (isset($status)) {
    header("Location: ./?status=" . $status);
} else {
    header("Location: ./.");
}
