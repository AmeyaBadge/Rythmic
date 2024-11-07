<?php
require_once('comps/functions.php');

session_start();
if (!isset($_SESSION['user'])) {
  redirect('login.php');
}

  require_once('comps/connection.php');

  $query = "SELECT * FROM artists";


$result = $conn->query($query);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Artists</title>
  <?php require_once('comps/head.php'); ?>

</head>

<body data-bs-theme="dark">
  <div class="container mt-5">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Age</th>
          <th scope="col">Played</th>
          <th scope="col">Description</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        
        if($result->num_rows > 0){

          foreach ($result as $artist) {
            echo '<tr>';
            echo '<td>' . $artist['artist_id'] . '</td>';
            echo '<td>' . $artist['name'] . '</td>';
            echo '<td>' . $artist['age'] . '</td>';
            echo '<td>' . $artist['popularity'] . '</td>';
            echo '<td>' . $artist['description'] . '</td>';
            echo '<td><button class="btn btn-info">Edit</button></td>
                      <td><form method="POST" action="addArtist.php">
                                <input type="hidden" name="artist_id" value="'.$artist['artist_id'].'">
                                <button type="submit" name="delete_artist" class="btn btn-danger">Delete</button>
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