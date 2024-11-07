<?php
require_once('comps/connection.php');

// Handle form submission
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $artist_file = $_FILES['artist_image']['name'];  // Get the uploaded artist file
    $target_dir = "../uploads/artist/";  // Define directory for uploading
    $target_file = $target_dir . basename($artist_file);  // Complete path for file

    // Move the uploaded file to the server
    move_uploaded_file($_FILES["artist_image"]["tmp_name"], $target_file);

    // Use prepared statements to prevent SQL injection
    $sql = $conn->prepare("INSERT INTO artists (name, age, description, image) 
                           VALUES (?, ?, ?, ?)");
    $sql->bind_param("siss", $name, $age, $description, $artist_file);

    if ($sql->execute()) {

        echo "Artist added successfully!";
    } else {
        echo "Error: " . $sql->error;
    }
}
// Delete the song if the delete button is clicked
else if (isset($_POST['delete_artist'])) {
    $artist_id = $_POST['artist_id'];

    $sql = "DELETE FROM artists WHERE artist_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $artist_id);
    if ($stmt->execute()) {
        echo "Artist deleted successfully!";
    } else {
        // Rollback the transaction if something goes wrong

        echo "Error: ";
    }
}

$conn->close();
