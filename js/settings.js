const changePasswordModal = document.getElementById("password-change-modal");
const changePasswordForm = document.querySelector(
  "#password-change-modal form"
);
const changePasswordBtn = document.getElementById("change-password-btn");
changePasswordBtn.addEventListener("click", () => {
  changePasswordModal.style.display = "block";
});
const closePasswordModal = document.getElementById("close-password-modal");
closePasswordModal.addEventListener("click", () => {
  changePasswordModal.style.display = "none";
});
changePasswordForm.addEventListener("submit", (event) => {
  event.preventDefault();
  const currentPasswordInput = document.getElementById("current-password");
  const newPasswordInput = document.getElementById("new-password");
  const confirmPasswordInput = document.getElementById("confirm-password");
  const currentPassword = currentPasswordInput.value;
  const newPassword = newPasswordInput.value;
  const confirmPassword = confirmPasswordInput.value;
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "php/change_password.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          successPopup.innerHTML = response.message;
          successPopup.style.display = "block";
          setTimeout(() => {
            successPopup.style.display = "none";
            changePasswordModal.style.display = "none";
            currentPasswordInput.value = "";
            newPasswordInput.value = "";
            confirmPasswordInput.value = "";
          }, 3000);
        } else {
          errorPopup.innerHTML = response.message;
          errorPopup.style.display = "block";
          setTimeout(() => {
            errorPopup.style.display = "none";
          }, 3000);
        }
        currentPasswordInput.value = "";
        newPasswordInput.value = "";
        confirmPasswordInput.value = "";
      } else {
        console.log("Error:", xhr.status);
      }
    }
  };
  const data = `current_password=${currentPassword}&new_password=${newPassword}&confirm_password=${confirmPassword}`;
  xhr.send(data);
});
function confirmDelete(file) {
  if (confirm("Are you sure you want to delete this file? "+file)) {
    window.location.href = "php/delete.php?file=" + file;
  }
}
const selectElement = document.querySelector('select[name="timezone"]');
window.addEventListener("load", () => {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "php/read_tz.php");
  xhr.addEventListener("load", () => {
    if (xhr.status === 200) {
      const timezone = xhr.responseText.trim();
      selectElement.value = timezone;
    } else {
      errorPopup.innerHTML = "Error reading timezone:" + xhr.status;
      errorPopup.style.display = "block";
      setTimeout(() => {
        errorPopup.style.display = "none";
      }, 3000);
    }
  });
  xhr.send();
});
selectElement.addEventListener("change", (event) => {
  const timezone = event.target.value;
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "php/write_tz.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  const data = `timezone=${timezone}`;
  xhr.addEventListener("load", () => {
    if (xhr.status === 200) {
      successPopup.innerHTML = "Timezone written successfully!";
      successPopup.style.display = "block";
    } else {
      errorPopup.innerHTML = "Error writing timezone: " + xhr.status;
      errorPopup.style.display = "block";
      setTimeout(() => {
        errorPopup.style.display = "none";
      }, 3000);
    }
  });
  xhr.send(data);
});
function downloadFile(filename) {
  var folderPath = "../uploads/";
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "php/download.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.responseType = "blob";
  xhr.onload = function () {
    if (xhr.status === 200) {
      var blob = new Blob([xhr.response]);
      var link = document.createElement("a");
      link.href = window.URL.createObjectURL(blob);
      link.download = filename;
      link.click();
    }
  };
  xhr.send("filename=" + folderPath + filename);
}
const phpmodal = document.getElementById("php-log-modal");
const phpbtn = document.getElementById("phpModal-btn");
const phplogContent = document.getElementById("php-log-content");
function openPHPModal() {
  phpmodal.style.display = "block";
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      phplogContent.innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "FileShare.log", true);
  xhr.send();
}
const closePHPModal = document.getElementById("close-php-log-modal");
closePHPModal.addEventListener("click", () => {
  phpmodal.style.display = "none";
});

const cleanupmodal = document.getElementById("cleanup-log-modal");
const cleanupbtn = document.getElementById("cleanupModal-btn");
const cleanuplogContent = document.getElementById("cleanup-log-content");
function openCleanupModal() {
  cleanupmodal.style.display = "block";
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      cleanuplogContent.innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "cleanup.log", true);
  xhr.send();
}
const closeCleanupModal = document.getElementById("close-cleanup-log-modal");
closeCleanupModal.addEventListener("click", () => {
  cleanupmodal.style.display = "none";
});