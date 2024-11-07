<?php
// MySQLi connection
$conn = new mysqli("localhost", "root", "1234", "musicplayer");
// Check connection

if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
  }
?>