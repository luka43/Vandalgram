<?php
if (!isset($_SESSION['loggedin'])) {

    if (isset($_GET["activate"])) {
        if ($_GET["activate"] == 1) {
            echo "<div class='box' style='color: green'><b>You have successfully activated your account, you can now login.. </b></div>";
        } else if ($_GET["activate"] == 2) {
            echo "<div class='box' style='color: red'><b>The account is already activated or doesn\'t exist!</b></div>";
        }
    } else {
        echo "<div class='box'>Please sign up for full experience </div>";
    }
}
