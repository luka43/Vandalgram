<?php
session_start();
session_regenerate_id();
// Database credentials
include "../../OjN2RyD5UKg3ZM.Mxh5N.php";

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {

    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($stmt = $con->prepare('SELECT id, password, activation_code, reg_date FROM accounts WHERE username = ?')) {
    $usrname = "admin";

    $stmt->bind_param('s', $usrname);
    $stmt->execute();


    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $activation_code, $reg_date);
        $stmt->fetch();
    }
} else {
    exit('Error while trying to prepare the statements: ' . mysqli_connect_error());
}

$_SESSION["ID"] = session_id();
$_SESSION["IP"] = $_SERVER["REMOTE_ADDR"];
$_SESSION["SYSINFO"] = $_SERVER['HTTP_USER_AGENT'];
$_SESSION['STARTED'] = $_SERVER['REQUEST_TIME'];
$_SESSION["logged_in"] = true;
$_SESSION["username"] = $usrname;
$_SESSION["activated"] = $activation_code;
$_SESSION["reg_date"] = $reg_date;
$_SESSION["upload_Count"] = 0;
/* $_SESSION["loginTry"] = $loginTryCount;
$_SESSION["loginOk"] = $loginOk; */
/* $_SESSION["registerTry"]
$_SESSION["registerOk"]
$_SESSION["termsRead"] */


foreach ($_SESSION as $name=>$value) {
    echo "$name => $value <br>";
}