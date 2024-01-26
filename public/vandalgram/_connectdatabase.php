<?php

function getImageDatabaseData($url)
{
    // Database credentials
    include "../../OjN2RyD5UKg3ZM.Mxh5N.php";

    $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    } else {

        if ($stmt = $connection->prepare("SELECT artist, title, category, description, country, city, year FROM gallery WHERE url=?")) {
            $stmt->bind_param('s', $url);
            $stmt->execute();

            $stmt->bind_result($artist, $title, $category, $description, $country, $city, $year);
            $stmt->fetch();

            $stmt->close();

            $stmt = $connection->prepare("SELECT display_name, crew, country, city FROM accounts WHERE username=?");
            $stmt->bind_param('s', $artist);
            $stmt->execute();

            $stmt->bind_result($display_name, $crew, $artist_country, $artist_city);
            $stmt->fetch();

            $stmt->close();
        }
        return [$artist, $title, $category, $description, $country, $city, $year, $display_name, $crew, $artist_country, $artist_city];
    }

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
}
function connectDatabaseGallery()
{
    // Database credentials
    include "../../qjsxBK5iNdKKraM8.php";

    $connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
}
