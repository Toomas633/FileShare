function displayError() {
  let errorPopup = document.getElementById("error-popup");
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

function downloadFile(filename) {
  let folderPath = "../uploads/";
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/download.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.responseType = "blob";
  xhr.onload = function () {
    if (xhr.status === 200) {
      let blob = new Blob([xhr.response]);
      let link = document.createElement("a");
      link.href = window.URL.createObjectURL(blob);
      link.download = filename;
      link.click();
    }
  };
  xhr.send("filename=" + folderPath + filename);
}
