<?php
require_once('comps/connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $cover = $_POST['cover'];
    $release_date = $_POST['release_date'];
    // $artist_ids = isset($_POST['artist_ids']) ? $_POST['artist_ids'] : [];

    // Validate form inputs
    if (empty($name) || empty($cover) || empty($release_date)) {
        echo "Album name, cover image, and release date are required.";
    } else {
        // Insert the album into the albums table
        $sql = "INSERT INTO albums (title, cover, release_date) VALUES (?, ?, ?)";

        // Prepare and bind parameters to prevent SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $cover, $release_date);

        if ($stmt->execute()) {

            echo "Album created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>