<div class="flex-shrink-0 p-3" style="width: 280px;">
      <a href="/" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
        <span class="fs-5 fw-semibold">Dashboard</span>
      </a>
      <ul class="list-unstyled ps-0">
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            onclick="showForm('addSongForm')">Add Song</button>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            onclick="showForm('addArtistForm')">Add Artist</button>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            onclick="showForm('addAlbumForm')">Add Album</button>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            onclick="location.href = 'allSongs.php';">Show Songs</button>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            onclick="location.href = 'allArtists.php';">Show Artists</button>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
            onclick="location.href = 'allAlbums.php';">Show Albums</button>
        </li>
      </ul>
      <form action="logout.php" method="post">
        <button class="logout btn btn-danger" type="submit" name="logoutBtn">Logout</button>
      </form>
    </div>