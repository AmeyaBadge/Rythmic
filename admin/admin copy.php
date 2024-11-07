<?php

require_once('comps/functions.php');

session_start();
if(!isset($_SESSION['user'])){
    redirect('login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <?php require_once('comps/head.php');?>

</head>
<body data-bs-theme="dark">
  <main class="d-flex flex-nowrap">

    <?php
    require_once('comps/sidebar.php');
    ?>

    <div class="container mt-5">
      <!-- Add Song Form -->
      <div id="addSongForm">

        <h2>Add Songs</h2>
  
        <div class="mb-3">
          <input type="email" class="form-control" placeholder="Enter Song name" id="exampleInputEmail1"
            aria-describedby="emailHelp">
        </div>
  
        <div class="mb-3">
          <select class="form-select" aria-label="Default select example">
            <option selected>Select Genre</option>
            <option value="1">Pop</option>
            <option value="2">Rock</option>
            <option value="3">Classical</option>
            <option value="4">Rap</option>
            <option value="5">IndiPop</option>
            <option value="6">Jazz</option>
          </select>
        </div>
  
        <div class="input-group mb-3">
          <select class="selectpicker" multiple aria-label="size 3 select example">
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            <option value="4">Four</option>
          </select>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">@</span>
          <select class="form-multi-select" placeholder="Artists" multiple data-coreui-search="true" aria-label="Username"
            aria-describedby="basic-addon1">
          <option>Hello</option>
          <option>Hello2</option>
          </select>
        </div>
  
        <div class="mb-3">
          <input class="form-control" type="file" id="formFile">
        </div>
  
        <div class="input-group mb-3">
          <span class="input-group-text">Song Cover Image</span>
          <textarea class="form-control" name="cover_image" aria-label="With textarea"></textarea>
        </div>
  
        <div class="col-12">
          <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
  
      </div>

      <!-- Add Artist Form -->
      <div id="addArtistForm" style="display: none;">
        <h2>Add Artist</h2>
        <div class="mb-3">
          <input type="text" class="form-control" placeholder="Enter Artist name">
        </div>
        <div class="mb-3">
          <textarea class="form-control" placeholder="Bio"></textarea>
        </div>
        <div class="col-12">
          <button class="btn btn-primary" type="submit">Submit</button>
        </div>
      </div>

      <!-- Add Album Form -->
      <div id="addAlbumForm" style="display: none;">
        <h2>Add Album</h2>
        <div class="mb-3">
          <input type="text" class="form-control" placeholder="Enter Album name">
        </div>
        <div class="mb-3">
          <input type="file" class="form-control">
        </div>
        <div class="col-12">
          <button class="btn btn-primary" type="submit">Submit</button>
        </div>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script src="js/sidebar.js"></script>
</body>
</html>