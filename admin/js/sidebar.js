
function showForm(formId) {
  // Hide all forms
  document.getElementById('addSongForm').style.display = 'none';
  document.getElementById('addArtistForm').style.display = 'none';
  document.getElementById('addAlbumForm').style.display = 'none';

  // Show the selected form
  document.getElementById(formId).style.display = 'block';
}
