<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ./.');
    exit;
}
// Database credentials
include "../../OjN2RyD5UKg3ZM.Mxh5N.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT email, activation_code, role, display_name, crew, country, city, reg_date FROM accounts WHERE username = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('s', $_SESSION["username"]);
$stmt->execute();
$stmt->bind_result($email, $activation_code, $role, $display_name, $crew, $country, $city, $reg_date);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gallery for photographs of vandalism">
    <meta name="keywords" content="vandalgram, vandalism, gallery, graffiti, street art">
    <meta name="author" content="luka43">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css?<?= filemtime('css/styles.css'); ?>">
    <link rel="stylesheet" href="css/scrollbar.css">
    <script src="js/to-top.js" defer></script>
    <title>Vandalgram | Account settings</title>
</head>

<body id="body">
    <header id="">
        <a class="banner-title" href="index.php">Vandalgram</a>
    </header>
    <div class="menu-bar">
        <?php
        include "components/menubar.php";
        ?>
    </div>
    <main>
        <div class="sidebar-wrapper">
            <div class='sidebar'>
                <div class='login'>
                    <?php
                    include "components/sidebar-login.php"
                    ?>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="box">
                <table>
                    <form method="post">
                        <tr>
                            <td>Role:</td>
                            <td><?= $role ?></td>
                        </tr>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" disabled="true" value=<?= $_SESSION["username"] ?>></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>
                                <input type="email" disabled="true" value=<?= $email ?>>
                            </td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" placeholder="Change password" disabled="true"></td>
                        </tr>
                        <tr>
                            <td>Display name:</td>
                            <td><input name="display-name" type=" text" value=<?= $display_name ?>></td>
                        </tr>
                        <tr>
                            <td>Crew:</td>
                            <td><input name="crew" type="text" value=<?= $crew ?>></td>
                        </tr>
                        <tr>
                            <td>Country: </td>
                            <td>
                                <input name="country" type="text" value=<?= $country ?>>
                            </td>
                        </tr>
                        <tr>
                            <td>City: </td>
                            <td>
                                <input name="city" type="text" value=<?= $city ?>>
                            </td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td><?= $activation_code ?></td>
                        </tr>
                        <tr>
                            <td>Registration date:&nbsp;&nbsp;</td>
                            <td><?= $reg_date ?></td>
                        </tr>
                </table>
                <input name="submit" type="submit" value="Save changes">
                </form>
            </div>
        </div>

    </main>
    <footer><?php include "components/footer.php" ?></footer>
    <?php
    if (isset($_POST['submit'])) {
        include "_updateacc.php";
    }
    ?>
</body>

</html>