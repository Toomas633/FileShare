function displayError() {
  var errorPopup = document.getElementById("error-popup");
  errorPopup.style.display = "block";
  setTimeout(() => {
    errorPopup.style.display = "none";
  }, 3000);
}
