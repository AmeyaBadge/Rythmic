<?php

if(isset($_POST['user_id'])){

    require_once('connection.php');
// Sample data - you may replace these with actual data from your application
$user_id = $_POST['user_id']; // User ID who listened to the song
$song_id = $_POST['song_id']; // ID of the song being listened to
$listen_timestamp = date("Y-m-d H:i:s"); // Current timestamp for the listening time

// Insert data into listening_history table
$sql = "INSERT INTO listening_history (user_id, song_id, listened_at) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $song_id, $listen_timestamp); // Bind the parameters

// Execute the statement and check if insertion was successful
if ($stmt->execute()) {
    echo "Listening history recorded successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
}else{
    echo "in Else";
}
?>