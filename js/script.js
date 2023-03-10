const dropArea = document.getElementById("drop-area");
const fileInput = document.getElementById("file-input");
const linkPopup = document.getElementById("link-popup");
const errorPopup = document.getElementById("error-popup");
const errorText = document.getElementById("error");
const linkInput = document.getElementById("link");
const copyLinkButton = document.getElementById("copy-link-button");

// Allow drag and drop for file upload
dropArea.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropArea.classList.add("dragover");
});

dropArea.addEventListener("dragleave", (e) => {
  e.preventDefault();
  dropArea.classList.remove("dragover");
});

dropArea.addEventListener("drop", (e) => {
  e.preventDefault();
  dropArea.classList.remove("dragover");
  fileInput.files = e.dataTransfer.files;
});

// Generate link and display it in a popup upon file upload
const form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const file = fileInput.files[0];

  const formData = new FormData();
  formData.append("file", file);

  fetch("php/upload.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      return response.text();
    })
    .then((linkEnding) => {
      if (linkEnding.startsWith("ERROR: ")) {
        errorText.value = linkEnding.substring(7);
        errorPopup.style.display = "block";
      } else {
        linkInput.value = linkEnding;
        linkPopup.style.display = "block";
      }
    })
    .catch((error) => {
      console.error(error);
    });
});

// Copy link to clipboard
copyLinkButton.addEventListener("click", (e) => {
  e.preventDefault();
  linkInput.select();
  document.execCommand("copy");
  copyLinkButton.innerHTML = '<i class="fa-check"></i> Copied!';
  setTimeout(() => {
    copyLinkButton.innerHTML = '<i class="fa-clipboard"></i> Copy Link';
  }, 3000);
});


// Close the popup when the user clicks the close button
const closeButtons = document.querySelectorAll(".close");

closeButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
  });
});