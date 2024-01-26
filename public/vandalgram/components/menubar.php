<?php
echo
"<a href='./.'>[HOME]&nbsp; </a>";
if (isset($_SESSION['loggedin']) && isset($_SESSION["username"])) {
    echo
    "<a href='upload.php'>[UPLOAD]&nbsp; </a>",
    "<a href='profile.php'>[PROFILE]&nbsp; </a>",
    "<a href='account.php'>[ACCOUNT SETTINGS]&nbsp; </a>";
} else {
    echo
    "<a href='register.php'>[SIGN UP]&nbsp; </a>";
}
