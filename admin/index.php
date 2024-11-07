<?php

require_once('comps/functions.php');

session_start();
if (!isset($_SESSION['user'])) {
  redirect('login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <?php require_once('comps/head.php'); ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body data-bs-theme="dark">
  <main class="d-flex flex-nowrap">

    <?php
    require_once('comps/sidebar.php');
    ?>

    <div class="container mt-5">
      <!-- Add Song Form -->
      <form action="addSong.php" method="POST" enctype="multipart/form-data">
        <div id="addSongForm">
          <h2>Add Songs</h2>

          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Enter Song name" id="song_name" name="song_name" required>
          </div>

          <div class="mb-3">
            <select class="form-select" aria-label="Select Genre" name="genre_id" required>
              <option selected>Select Genre</option>
              <option value="1">Pop</option>
              <option value="2">Rock</option>
              <option value="3">Classical</option>
              <option value="4">Rap</option>
              <option value="5">IndiPop</option>
              <option value="6">Jazz</option>
            </select>
          </div>

          <div class="mb-3">
            <select class="form-select" aria-label="Select Album" name="album_id" required>
              <option selected>Select Album</option>
              <!-- Dynamically fetch albums from the database -->
              <?php
              // Assuming you have a connection to the DB
              $conn = new mysqli("localhost", "root", "1234", "MusicPlayer"); // Update with your DB credentials
              $result = $conn->query("SELECT album_id, title FROM albums");
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['album_id'] . "'>" . $row['title'] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <select class="form-select" aria-label="Select Artists" name="artist_ids[]" multiple required>
              <option selected>Select Artists</option>
              <!-- Dynamically fetch artists from the database -->
              <?php
              $result = $conn->query("SELECT artist_id, name FROM artists");
              while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['artist_id'] . "'>" . $row['name'] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <input class="form-control" type="file" id="formFile" name="song_file">
          </div>

          <div class="mb-3">
            <textarea class="form-control" aria-label="Song Cover Image" name="cover_image" placeholder="Song Cover Image"></textarea>
          </div>

          <div class="col-12">
            <button class="btn btn-primary" type="submit" name="submit">Submit form</button>
          </div>
        </div>
      </form>


      <!-- Add Artist Form -->
      <div id="addArtistForm" style="display: none;">
        <h2>Add Artist</h2>
        <form action="addArtist.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Enter Artist name">
          </div>
          <div class="mb-3">
            <input type="integer" class="form-control" name="age" placeholder="Enter Your Age">
          </div>
          <div class="mb-3">
            <input class="form-control" type="file" name="artist_image">
          </div>
          <div class="mb-3">
            <textarea class="form-control" name="description" placeholder="Bio"></textarea>
          </div>
          <div class="col-12">
            <button class="btn btn-primary" name="submit" type="submit">Submit</button>
          </div>
        </form>
      </div>

      <!-- Add Album Form -->
      <div id="addAlbumForm" style="display: none;">
      <h2>Add Album</h2>
    <form action="addAlbum.php" method="post">
        <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Enter Album name" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="cover" placeholder="Enter Cover Image URL" required>
        </div>
        <div class="mb-3">
            <input type="date" class="form-control" name="release_date" placeholder="Choose Release Date" required>
        </div>

        <!-- Select artists for the album (multi-select dropdown) -->
        <!-- <div class="mb-3">
            <label for="artists">Select Artists</label>
            <select class="form-control" name="artist_ids[]" id="artists" multiple> -->
                <?php
                // Fetch all artists from the database
                // $artist_query = "SELECT artist_id, name FROM artists";
                // $result = $conn->query($artist_query);
                // if ($result->num_rows > 0) {
                //     while ($row = $result->fetch_assoc()) {
                //         echo "<option value='" . $row['artist_id'] . "'>" . $row['name'] . "</option>";
                //     }
                // }
                ?>
            <!-- </select>
        </div> -->

        <div class="col-12">
            <button class="btn btn-primary" name="submit" type="submit">Submit</button>
        </div>
    </form>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="js/sidebar.js"></script>

  <script>
    $(document).ready(function() {
      // Initialize Select2 for multi-select with search functionality
      $('#artist_select').select2({
        placeholder: "Select Artists",
        allowClear: true
      });
    });
  </script>
</body>

</html>