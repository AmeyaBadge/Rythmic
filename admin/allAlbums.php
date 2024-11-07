<?php
require_once('comps/functions.php');

session_start();
if (!isset($_SESSION['user'])) {
  redirect('login.php');
}

  require_once('comps/connection.php');

  $query = "SELECT 
                a.album_id, 
                a.title, 
                a.release_date, 
                GROUP_CONCAT(ar.name SEPARATOR ', ') AS artist_names 
            FROM albums a
            LEFT JOIN album_artist aa ON a.album_id = aa.album_id
            LEFT JOIN artists ar ON aa.artist_id = ar.artist_id
            GROUP BY a.album_id
            ORDER BY a.album_id";

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
          <th scope="col">Title</th>
          <th scope="col">Release Date</th>
          <th scope="col">Artist</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        
        if($result->num_rows > 0){
            foreach ($result as $song) {
                echo '<tr>';
                echo '<td>' . $song['album_id'] . '</td>';
                echo '<td>' . $song['title'] . '</td>';
                echo '<td>' . $song['release_date'] . '</td>';
                echo '<td>' . $song['artist_names'] . '</td>';
                echo '<td><button class="btn btn-info">Edit</button></td>
                          <td><button class="btn btn-danger">Delete</button></td>
                </tr>';
            }
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