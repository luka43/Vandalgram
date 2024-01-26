<?php

function generateRandomString($length = 25)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[random_int(0, $charactersLength - 1)];
  }
  return $randomString;
}
function createThumbnail($filepath, $width)
{
  // Get the file format of the input image
  $extension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
  // Load the original image based on the file format
  switch ($extension) {
    case 'jpg':
    case 'jpeg':
      $original_image = imagecreatefromjpeg($filepath);
      break;
    case 'png':
      $original_image = imagecreatefrompng($filepath);
      break;
    default:
      return false;
  }

  // Get the dimensions of the original image
  $original_width = imagesx($original_image);
  $original_height = imagesy($original_image);

  // Calculate the new dimensions for the thumbnail
  $thumbnail_height = round($width * $original_height / $original_width);

  // Create a new blank image for the thumbnail
  $thumbnail_image = imagecreatetruecolor($width, $thumbnail_height);

  // Resize the original image to fit the thumbnail
  imagecopyresampled($thumbnail_image, $original_image, 0, 0, 0, 0, $width, $thumbnail_height, $original_width, $original_height);

  // Save the thumbnail as a new image file with the "_thumb" suffix
  $thumbnail_path = pathinfo($filepath, PATHINFO_DIRNAME) . "/thumbnails/" . pathinfo($filepath, PATHINFO_FILENAME) . "." . $extension;
  switch ($extension) {
    case 'jpg':
    case 'jpeg':
      imagejpeg($thumbnail_image, $thumbnail_path);
      break;
    case 'png':
      imagepng($thumbnail_image, $thumbnail_path);
      break;
  }

  // Clean up the resources used by the images
  imagedestroy($original_image);
  imagedestroy($thumbnail_image);
}
include "../../OjN2RyD5UKg3ZM.Mxh5N.php";
$target_dir = "uploads/";

$imageFileType = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
$rand_filename = generateRandomString() . "." . $imageFileType;
$target_file = $target_dir . $rand_filename;
$uploadOk = 1;

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
    // file is image
    $uploadOk = 1;
  } else {
    // file is not an image
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  // filename allready exists creating new one
  $target_file = $target_dir . generateRandomString() . "." . $imageFileType;
  $uploadOk = 1;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if (
  $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
) {
  echo "Sorry, only JPG, JPEG, PNG files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    echo "<p>The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.</p>";
    echo "<img style='max-width: 30vw' src=" . $target_file . ">";
    createThumbnail($target_file, 300);
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
      // If there is an error with the connection, stop the script and display the error.
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    if ($stmt = $con->prepare('INSERT INTO gallery (artist, category, title, description, country, city, year, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
      // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
      $artist = $_SESSION["username"];
      $category = $_POST['category'];
      $title = $_POST['title'];
      $description = $_POST['description'];
      $country = $_POST['country'];
      $city = $_POST['city'];
      $year = $_POST['year'];
      $url = $rand_filename;
      $stmt->bind_param('ssssssss', $artist, $category, $title, $description, $country, $city, $year, $url);
      $stmt->execute();
      $stmt->close();
    }
    $_SESSION["submited"] = $_SESSION["submited"] + 1;
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
