var successPopup = document.getElementById("success-popup");
var errorPopup = document.getElementById("error-popup");
function DisplayDeleteStatus(status) {
  if (status.startsWith('ERROR:')) {
    errorPopup.innerHTML = status.substring(7);
    errorPopup.style.display = "block";
    setTimeout(() => {
      errorPopup.style.display = "none";
    }, 3000);
  } else {
    successPopup.innerHTML = status;
    successPopup.style.display = "block";
    setTimeout(() => {
      successPopup.style.display = "none";
    }, 3000);
  }
}