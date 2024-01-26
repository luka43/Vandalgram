<?php
if (
    $_POST["loggedin"] == $_SESSION["loggedin"]  &&
    $_POST["username"] == $_SESSION["username"]  &&
    $_POST["displayname"] == $_SESSION["displayname"]

) {
    include "../../OjN2RyD5UKg3ZM.Mxh5N.php";

    if ($_POST["submit"] === "Delete") {

        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

        if (mysqli_connect_errno()) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to MySQL: ' . mysqli_connect_error() . "<br>");
        }
        if ($stmt = $con->prepare('DELETE FROM gallery where url=?')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            $stmt->bind_param('s', $_POST['imageurl']);
            $stmt->execute();
            $stmt->close();
            echo "Image " . $_POST['imageurl'] . " deleted from database.<br>";
        } else {
            echo "Couldn't prepare statement..";
        }
        if (!unlink("uploads/" . $_POST["imageurl"])) {
            echo $_POST["imageurl"] . ' cannot be deleted due to an error<br>';
        } else {
            echo "Image file: " . $_POST["imageurl"] . ' has been deleted<br>';
        }
        if (!unlink("uploads/thumbnails/" . $_POST["imageurl"])) {
            echo 'Thumbnail : ' . $_POST["imageurl"] . ' cannot be deleted due to an error<br>';
        } else {
            echo 'Thumbnail : ' . $_POST["imageurl"] . ' has been deleted<br>';
        }
    } elseif ($_POST["submit"] === "Apply") {

        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

        if (mysqli_connect_errno()) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to MySQL: ' . mysqli_connect_error() . "<br>");
        }
        if ($stmt = $con->prepare(
            "UPDATE gallery SET  
            title='" . $_POST['title'] . "', 
            category='" . $_POST['category'] . "', 
            description='" . $_POST['description'] . "', 
            country='" . $_POST['country'] . "', 
            city='" . $_POST['city'] . "', 
            year='" . $_POST['year'] . "' 
            WHERE url='" . $_POST['imageurl'] . "'"

        )) {
            $stmt->execute();
        }
    } else {
        echo 'Something went wrong with preparing statements, pls try again later.. ' . $_POST['imageurl'];
    }
}
echo ("<meta http-equiv='refresh' content='0'>");
