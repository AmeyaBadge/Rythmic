<?php
require_once('comps/connection.php');

// Handle form submission
if (isset($_POST['submit'])) {
    // Get form data
    $song_name = $_POST['song_name'];
    $genre_id = $_POST['genre_id'];
    $album_id = $_POST['album_id'];
    $duration = "00:10:00";  // Correct format for time
    $artist_ids = $_POST['artist_ids']; // Array of artist IDs
    $cover_image = $_POST['cover_image']; // Cover image URL or text (not used for now)
    $song_file = $_FILES['song_file']['name'];  // Get the uploaded song file
    $target_dir = "../uploads/song/";  // Define directory for uploading
    $target_file = $target_dir . basename($song_file);  // Complete path for file

    // Move the uploaded file to the server
    move_uploaded_file($_FILES["song_file"]["tmp_name"], $target_file);

    // $target_file =  str_replace('../','',$target_file);

    // Use prepared statements to prevent SQL injection
    $sql = $conn->prepare("INSERT INTO songs (song_name, duration, genre_id, album_id, cover_image, song_file) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssiiss", $song_name, $duration, $genre_id, $album_id, $cover_image, $song_file);

    if ($sql->execute()) {
        $song_id = $conn->insert_id; // Get the last inserted song ID

        // Insert the many-to-many relations (song_artist table)
        foreach ($artist_ids as $artist_id) {
            // Add artist to the song_artist table
            $artist_sql = "INSERT INTO song_artist (song_id, artist_id) VALUES ('$song_id', '$artist_id')";
            $conn->query($artist_sql);
            
            // Check if artist is already associated with the album, if not, associate artist with the album
            $album_artist_sql = "SELECT * FROM album_artist WHERE album_id = '$album_id' AND artist_id = '$artist_id'";
            $result = $conn->query($album_artist_sql);
            if ($result->num_rows == 0) {
                // If the artist is not already linked to the album, link them
                $link_artist_sql = "INSERT INTO album_artist (album_id, artist_id) VALUES ('$album_id', '$artist_id')";
                $conn->query($link_artist_sql);
            }
        }

        echo "Song added successfully!";

    } else {
        echo "Error: " . $sql->error;
    }
}
// Delete the song if the delete button is clicked
else if (isset($_POST['delete_song'])) {
    $song_id = $_POST['song_id'];

    $res = $conn->query("SELECT song_file from songs WHERE song_id=".$_POST['song_id']);
    $path =  "../uploads/song/".$res->fetch_assoc()['song_file'];
    if(!unlink($path)){
        echo "Cannot delete file : ".$path;
    }

    // Begin transaction to delete the song and its relations
    $conn->begin_transaction();

    try {
        // 1. Delete the relations in the song_artist table
        $sql = "DELETE FROM song_artist WHERE song_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $song_id);
        $stmt->execute();

        // 2. Delete the song from the songs table
        $sql = "DELETE FROM songs WHERE song_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $song_id);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();
        echo "Song deleted successfully!";
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

$conn->close();
?>
