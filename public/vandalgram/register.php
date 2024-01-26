<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (isset($_SESSION['loggedin'])) {
    header('Location: ./.');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css?<?= filemtime('css/styles.css'); ?>">
    <link rel="stylesheet" href="css/scrollbar.css">
    <script src="js/check-password.js" defer></script>

    <title>Vandalgram | Sign Up</title>
</head>

<body id="body">
    <header id="">
        <a class="banner-title" href="index.php">Vandalgram</a>
    </header>
    <div class="menu-bar">
        <a href="./.">[ HOME ]</a>
    </div>
    <main>
        <div class="container-wrapper">

            <div class="reg-box">
                <h2>Sign Up</h1>
            </div>

            <div class="reg-box">
                <form action="" method="post" autocomplete="off">
                    <label for="username">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" name="username" placeholder="Username" id="username" required>
                    <label for="password">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" name="password" placeholder="Password" id="password" required>
                    <div class="password-warnings" id="password-warning"></div>
                    <input type="password" name="password-retype" placeholder="Retype password" id="password-retype" required>
                    <div class="password-warnings" id="password-retype-warning"></div>
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                    </label>
                    <input type="email" name="email" placeholder="Email" id="email" required>
                    <hr>
                    <div class="checkbox-wrapper">
                        <input class="checkbox" type="checkbox" style="width: 10px" required>
                        <p>
                            I agree that all images are photographed by me and I don't take credits for the vandalism.
                        </p>
                    </div>

                    <input id="submit" name="submit" class="submit" type="submit" value="Register">
                </form>

                <div style="display: flex; flex-direction: column; width: 100%; justify-content: center">

                    <hr>
                </div>
                <a href="termsofagreement.php">Terms of agreement</a>

            </div>
            <?php
            if (isset($_POST['submit'])) {
                include "_register.php";
            }
            ?>
        </div>
        <?php

        ?>
        </div>

    </main>
    <footer><?php include "components/footer.php" ?></footer>

    <script>

    </script>

</html>