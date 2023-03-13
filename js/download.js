function displayError() {
  var errorPopup = document.getElementById("error-popup");
  errorPopup.style.display = "block";
  setTimeout(() => {
    errorPopup.style.display = "none";
  }, 3000);
}
function confirmDelete(file) {
    if (confirm("Are you sure you want to delete this file? " + file)) {
      window.location.href = "php/download-delete.php?file=" + file;
    }
  }