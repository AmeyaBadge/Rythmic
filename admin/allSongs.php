<?php
require_once('comps/functions.php');

session_start();
if (!isset($_SESSION['user'])) {
  redirect('login.php');
}

  require_once('comps/connection.php');

  $query = "SELECT 
                s.song_id, 
                s.song_name, 
                s.duration, 
                g.genre_name AS genre_name, 
                a.title AS album_name, 
                GROUP_CONCAT(ar.name SEPARATOR ', ') AS artist_names
            FROM songs s
            JOIN genres g ON s.genre_id = g.genre_id
            JOIN albums a ON s.album_id = a.album_id
            LEFT JOIN song_artist sa ON s.song_id = sa.song_id
            LEFT JOIN artists ar ON sa.artist_id = ar.artist_id
            GROUP BY s.song_id
            ORDER BY s.song_id;";


$result = $conn->query($query);
 
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <?php require_once('comps/head.php'); ?>

</head>

<body data-bs-theme="dark">
  <div class="container mt-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Song</th>
          <th scope="col">Duration</th>
          <th scope="col">Genre</th>
          <th scope="col">Album</th>
          <th scope="col">Artist</th>
          <!-- <th scope="col">Edit</th> -->
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        
        if($result->num_rows > 0){

          foreach ($result as $song) {
            echo '<tr>';
            echo '<td>' . $song['song_id'] . '</td>';
            echo '<td>' . $song['song_name'] . '</td>';
            echo '<td>' . $song['duration'] . '</td>';
            echo '<td>' . $song['genre_name'] . '</td>';
            echo '<td>' . $song['album_name'] . '</td>';
            echo '<td>' . $song['artist_names'] . '</td>';
            echo '
                      <td><form method="POST" action="addSong.php">
                                <input type="hidden" name="song_id" value="'.$song['song_id'].'">
                                <button type="submit" name="delete_song" class="btn btn-danger">Delete</button>
                            </form></td>
            </tr>';
        }

          // while($row = $result -> fetch_assoc()){
          //     echo '<tr>
          //             <th scope="row">'.$row['song_id'].'</th>
          //             <td>'.$row['song_name'].'</td>
          //             <td>'.$row['duration'].'</td>
          //             <td>'.$row['genre_name'].'</td>
          //             <td>'.$row['album_name'].'</td>
          //             <td>'.$row['artist_name'].'</td>
          //             <td><button class="btn btn-info">Edit</button></td>
          //             <td><button class="btn btn-danger">Delete</button></td>
          //           </tr>';
          // }
        }

        ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script src="js/sidebar.js"></script>
</body>

</html>