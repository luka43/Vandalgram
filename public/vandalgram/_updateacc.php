<?php
include "../../OjN2RyD5UKg3ZM.Mxh5N.php";
$username = $_SESSION["username"];
$display_name = $_POST["display-name"];
$crew = $_POST["crew"];
$country = $_POST["country"];
$city = $_POST["city"];
// Create connection
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($stmt = $con->prepare(
    "UPDATE accounts SET
    display_name='" . $display_name . "',
    crew='" . $crew . "',
    country='" . $country . "',
    city='" . $city . "'
    WHERE username='" . $username . "'"
)) {
    $stmt->execute();
}
$con->close();
echo ("<meta http-equiv='refresh' content='0'>");
