<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ./.');
    exit;
}
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
    <title>Vandalgram | Upload image</title>
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
        <div class="container-grid">
            <div>
                <div class="box">
                    Image upload
                </div>
                <div class="box">
                    <form id="form" action="" method="post" enctype="multipart/form-data">

                        <input type="text" name="title" placeholder="Title" required>
                        <select name="category" id="category">
                            <option value="Abandoned">Abandoned</option>
                            <option value="Bombing">Bombing</option>
                            <option value="City">City</option>
                            <option value="Handstyle">Handstyle</option>
                            <option value="Throwup">Throwup</option>
                            <option value="Train">Train</option>
                            <option value="Freight">Freight</option>
                            <option value="Legal">Legal</option>
                        </select>
                        <textarea type="text" name="description" placeholder="Description" rows="5" required></textarea>
                        <input type="text" name="country" placeholder="Country" required>
                        <input type="text" name="city" placeholder="City" required>
                        <input type="text" name="year" placeholder="Year taken" required>
                        <input type="file" name="fileToUpload" id="fileToUpload" required>

                        <div class="submit"></div>
                        <input id="submit" class="submit" name="submit" type="submit" value="Upload Image" name="submit" onsubmit="message()">
                    </form>
                </div>
            </div>
            <div id="div" class='box'>
                <p id="message">

                    <?php
                    if (isset($_POST['submit'])) {
                        if ($_SESSION["submited"] < 3) {
                            include "_upload.php";
                            echo "<script>document.getElementById('submit').disabled = true;</script>";
                        } else {
                            echo "Already submited 3 pictures this session, please sign out an sign in again..";
                        }
                    }
                    ?>
                </p>
            </div>
        </div>


    </main>
    <footer><?php include "components/footer.php" ?></footer>
</body>
<script>
    function message() {
        document.getElementById("message").textContent = "Uploading...";
    }
    var date = new Date();
    date.setTime(date.getTime() + (60 * 1000));
    document.cookie = ('uploaded', "true",
        expire = date);
    console.log(document.cookie);
</script>

</html>