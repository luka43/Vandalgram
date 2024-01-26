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
                        <input type="file" name="files" id="files" required>

                        <div class="submit"></div>
                        <input id="submit" class="submit" name="submit" type="submit" value="Upload Image" name="submit"
                            onsubmit="message()">
                        <label for="files"><i class="fa-solid fa-folder-open fa-2x"></i>Select files ...</label>
                        <div class="result"></div>
                        <div class="progress"></div>
                    </form>
                </div>
            </div>
    </main>

    <script>
    // Declare global variables for easy access
    const uploadForm = document.querySelector("#form");
    const filesInput = uploadForm.querySelector("#files");
    // Attach onchange event handler to the files input element
    filesInput.onchange = () => {
        // Append all the file names to the label
        uploadForm.querySelector("label").innerHTML = "";
        for (let i = 0; i < filesInput.files.length; i++) {
            uploadForm.querySelector("label").innerHTML +=
                '<span><i class="fa-solid fa-file"></i>' +
                filesInput.files[i].name +
                "</span>";
        }
    };
    // Attach submit event handler to form
    uploadForm.onsubmit = (event) => {
        event.preventDefault();
        // Make sure files are selected
        if (!filesInput.files.length) {
            uploadForm.querySelector(".result").innerHTML = "Please select a file!";
        } else {
            // Create the form object
            let uploadFormDate = new FormData(uploadForm);
            // Initiate the AJAX request
            let request = new XMLHttpRequest();
            // Ensure the request method is POST
            request.open("POST", uploadForm.action);
            // Attach the progress event handler to the AJAX request
            request.upload.addEventListener("progress", (event) => {
                // Add the current progress to the button
                uploadForm.querySelector("#submit").innerHTML =
                    "Uploading... " +
                    "(" +
                    ((event.loaded / event.total) * 100).toFixed(2) +
                    "%)";
                // Update the progress bar
                uploadForm.querySelector(".progress").style.background =
                    "linear-gradient(to right, #25b350, #25b350 " +
                    Math.round((event.loaded / event.total) * 100) +
                    "%, #e6e8ec " +
                    Math.round((event.loaded / event.total) * 100) +
                    "%)";
                // Disable the submit button
                uploadForm.querySelector("button").disabled = true;
            });
            // The following code will execute when the request is complete
            request.onreadystatechange = () => {
                if (request.readyState == 4 && request.status == 200) {
                    // Output the response message
                    uploadForm.querySelector(".result").innerHTML = "DONE !!";
                }
            };
            // Execute request
            request.send(uploadFormDate);
        }
    };
    </script>
    </div>
    </div>
    <div id="div" class='box'>
        <p id="message">
        </p>
    </div>
    </div>


    </main>
    <footer><?php include "components/footer.php" ?></footer>
</body>

</html>