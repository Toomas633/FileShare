const changePasswordModal = document.getElementById("password-change-modal");
const changePasswordForm = document.querySelector(
  "#password-change-modal form"
);

const successPopup = document.getElementById("success-popup");
const errorPopup = document.getElementById("error-popup");
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
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'php/settings-download.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (xhr.status === 200) {
      var blob = new Blob([xhr.response]);
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = filename;
      link.click();
    }
  };
  xhr.send('filename=' + filename);
}