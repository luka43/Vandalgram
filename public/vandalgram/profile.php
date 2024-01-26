<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ./.');
    exit;
}
if (!isset($_GET['artist']) || $_GET['artist'] === "") {
    header('Location: profile.php?artist=' . $_SESSION["username"]);
    exit;
}
include "../../OjN2RyD5UKg3ZM.Mxh5N.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ($stmt = $con->prepare("SELECT display_name, crew, country, city FROM accounts WHERE username=?")) {
    $stmt->bind_param('s', $_GET["artist"]);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($display_name, $crew, $country, $city);
        $stmt->fetch();
    }
    $stmt->close();
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
    <script>
        var session_name = "<?= $_GET["artist"] ?>";
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/profile-gallery.js?<?= filemtime('js/profile-gallery.js'); ?>" defer></script>
    <script src="js/to-top.js" defer></script>
    <title>Vandalgram | <?= $display_name ?></title>
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
                    include "components/sidebar-profile.php";
                    ?>
                </div>
            </div>
            <div class='sidebar'>
                <div class='login'>
                    <?php
                    include "components/sidebar-login.php"
                    ?>
                </div>
            </div>

        </div>
        <div class="container-wrapper">
            <div class="gallery-item-grid" gallery-item-grid></div>
        </div>
    </main>
    <footer><?php include "components/footer.php" ?></footer>
</body>

<button onclick="topFunction()" id="to-top" title="Back to top">
    <h2>^</h2>
</button>

<div class="card-preview-wrapper" id="card-preview-wrapper" onclick="closeImagePreview(this)">
    <div id="card-preview" class="card-preview">
        <div class="card-preview-header"></div>
        <img class="card-preview-image" onclick="goToImage(this)" loading="lazy" id="preview-image">
        <div class="card-preview-title"></div>
        <div class="card-preview-category"></div>
        <div class="card-preview-description"></div>
        <div class="card-preview-location"></div>
    </div>

</div>
<template card-template>
    <div class="card" onclick="imagePreview(this)" card-container>
        <div class="card-header" id="card-header" card-header></div>
        <img class="card-image" loading="lazy" card-image>
        <div class="card-title" card-title></div>
        <div class="card-category" card-category></div>
        <div class="card-description" card-description></div>
        <div class="card-location" card-location></div>
    </div>
</template>

</html>