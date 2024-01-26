<?php
session_start();
// Be very very sure everything is right
if (!isset($_SESSION['loggedin']) || !isset($_GET['url']) || $_GET['url'] === "" || !file_exists("uploads/" . $_GET["url"])) {
    header("Location: ./.");
    exit;
} else {

    include '_connectdatabase.php';
    [
        $artist, $title, $category, $description, $country, $city, $year,
        $display_name, $crew, $artist_country, $artist_city
    ] = getImageDatabaseData($_GET["url"]);
}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <mailto></mailto>
    <meta charset="UTF-8">
    <meta name="description" content="Gallery for photographs of vandalism">
    <meta name="keywords" content="vandalgram, vandalism, gallery, graffiti, street art">
    <meta name="author" content="luka43">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css?<?= filemtime('css/styles.css'); ?>">
    <link rel="stylesheet" href="css/scrollbar.css?<?= filemtime('css/scrollbar.css'); ?>">

    <title>Vandalgram | <?= $title ?></title>
</head>

<body id="body">

    <header id="header">
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
                    <p style="font-size: 1.5rem"><b><?php echo $display_name ?></b></p>
                    <p><?php echo $crew ?></p>
                    <p><?php echo $artist_country ?>, <?php echo $artist_city ?></p>
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
            <div class="box">

                <div class="card-preview-title" id="card-preview-title"><?= $title ?></div>
                <img class=" card-preview-image" src="uploads/<?= $_GET["url"] ?>">
                <div id="image-info">
                    <div class="card-preview-category"><?= $category ?></div>
                    <div class="card-preview-description"><?= $description ?></div>
                    <div class="card-preview-location"><?= $country ?>, <?= $city ?></div>

                </div>

                <?php
                if ($_SESSION["username"] === $artist || $_SESSION["role"] === "admin") {
                    echo "
                <input onclick='showHideEdit(this)' type='submit' id='edit' value='Edit image'>

                <div>
                        <div id='edit-form' name='edit-form' class='hide' action='' onreset='deleteImage()'>

                        <form>
                            <hr>
                            <input name='image-title' type='text' id='image-title' placeholder='" . $title . "'>
                            <input name='image-category' type='text' id='image-category' placeholder='" . $category . "'>
                            <input name='image-description' type='text' id='image-description' placeholder='" . $description . "'>
                            <input name='image-country' type='text' id='image-country' placeholder='" . $country . "'>
                            <input name='imge-city' type='text' id='image-city' placeholder='" . $city . "'>
                            <input name='image-year' type='text' id='image-year' placeholder='" . $year . "'>
                            <div style='display: flex'><input type='button' onclick='apply()' value='Apply'><input id='delete-image' type='reset' value='Delete image'></div>
                        </form>
                    </div>";
                }
                ?>
            </div>
        </div>

    </main>
    <footer><?php include "components/footer.php" ?></footer>
</body>
<?php
echo '<div id="save-warning-wrapper" class="warning-wrapper, hide">' .
    '<div id="save-warning" class="delete-warning">' .
    '<div>
 <p><b>Save changes?</b></p>
 <hr>
 <p><b>Are you sure you want to apply these changes?</b></p>
 <br><br>
 <hr>
 <form style="display: flex;" id="saveimage" name="save-image" action="" method="post" onreset="cancel()">
     <input name="title" id="title" type="hidden">
     <input name="category" id="category" type="hidden">
     <input name="description" id="description" type="hidden">
     <input name="country" id="country" type="hidden">
     <input name="city" id="city" type="hidden">
     <input name="year" id="year" type="hidden">
     <input name="username" type="hidden" value=' . $_SESSION["username"] . '>
     <input name="displayname" type="hidden" value=' . $_SESSION["displayname"] . '>
     <input name="loggedin" type="hidden" value=' . $_SESSION["loggedin"] . '>
     <input name="imageurl" id="imageurl"type="hidden" value=' . $_GET["url"] . '>
     <input name="submit" type="submit" value="Apply" style="background-color: green; color: white"><input type="reset" value="Cancel">

 </form>

</div>
</div>
</div>';
echo '<div id="delete-warning-wrapper" class="warning-wrapper, hide">
    <div id="delete-warning" class="delete-warning">
        <div>
            <p><b>WARNING !</b></p>
            <hr>
            <p><b>Are you sure you want to delete this photo?</b></p>
            <br><br>
            <hr>
            <form style="display: flex;" id="delete-image" name="delete-image" action="#" method="post" onreset="dontDelete()">
                <input name="loggedin" type="hidden" value=' . $_SESSION["loggedin"] . '>
                <input name="username" type="hidden" value=' . $_SESSION["username"] . '>
                <input name="displayname" type="hidden" value=' . $_SESSION["displayname"] . '>
                <input name="imageurl" type="hidden" value=' . $_GET["url"] . '>
                <input name="submit" type="submit" value="Delete" style="background-color: red; color: white"><input type="reset" value="Cancel">

            </form>

        </div>
    </div>
</div>';
?>
<script>
    function apply() {

        document.getElementById("save-warning-wrapper").classList.toggle("hide", false);
        document.getElementById("save-warning-wrapper").classList.toggle("warning-wrapper", true);
        document.getElementById("title").value = document.getElementById("image-title").value;
        document.getElementById("category").value = document.getElementById("image-category").value;
        document.getElementById("description").value = document.getElementById("image-description").value;
        document.getElementById("country").value = document.getElementById("image-country").value;
        document.getElementById("city").value = document.getElementById("image-city").value;
        document.getElementById("year").value = document.getElementById("image-year").value;

    }

    function cancel() {
        document.getElementById("save-warning-wrapper").classList.toggle("hide", true);
        document.getElementById("save-warning-wrapper").classList.toggle("warning-wrapper", false);
    }

    function deleteImage() {
        document.getElementById("delete-warning-wrapper").classList.toggle("hide", false);
        document.getElementById("delete-warning-wrapper").classList.toggle("warning-wrapper", true);
    }

    function dontDelete() {
        document.getElementById("delete-warning-wrapper").classList.toggle("hide", true);
        document.getElementById("delete-warning-wrapper").classList.toggle("warning-wrapper", false);
    }

    function showHideEdit(element) {
        if (element.value == "Edit image") {
            document.getElementById("card-preview-title").classList.toggle("hide", true);
            document.getElementById("image-info").classList.toggle("hide", true);
            document.getElementById("edit").value = "Cancel";
            document.getElementById("delete-image").style.backgroundColor = "red";
            document.getElementById("delete-image").style.color = "white";
            document.getElementById("edit-form").classList.toggle("hide", false);
            console.log("show");
        } else {
            document.getElementById("card-preview-title").classList.toggle("hide", false);
            document.getElementById("image-info").classList.toggle("hide", false);
            document.getElementById("edit").value = "Edit image";
            document.getElementById("delete-image").style.backgroundColor = "auto";
            document.getElementById("delete-image").style.color = "auto";
            document.getElementById("edit-form").classList.toggle("hide", true);
            console.log("hide");
        }
    }
</script>
<?php
if (isset($_POST["submit"]))
    include "_deleteimage.php";
?>

</html>