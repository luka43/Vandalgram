<?php
if (isset($_SESSION['loggedin']) && isset($_SESSION["username"])) {
    echo
    "<p>[Account]</p><hr>
    <p><b>" . $_SESSION['displayname'] . "</b></p>
    <p>" . $_SESSION['crew'] . "</p>
    <p>" . $_SESSION['country'] . ",</p>
    <p>" . $_SESSION['city'] . "</p><br>
    <hr>";

    echo "<p><a href='_logout.php'> LOG OUT </a></p>";
} else {
    echo "

        <p>[Login]<p>
        <hr>
        <form action='_login.php' method='post'>
        <label for='username'>
            <i class='fas fa-user'></i>
        </label>

        <input type='text' name='username' placeholder='Username' id='username' required>
        <label for='password'>
            <i class='fas fa-lock'></i>
        </label>

        <input type='password' name='password' placeholder='Password' id='password' required>
        <br><br>
        <input type='submit' value='Login'></form>
        <hr><a href='register.php'>Sign up</a>";
    if (isset($_GET["status"])) {
        if ($_GET["status"] == 1) {
            echo 'Please check your email for activation link!';
        } elseif ($_GET["status"] == 2) {
            echo "<p style='color: red'><a>Wrong username or password!</a></p>";
        }
    }
}
