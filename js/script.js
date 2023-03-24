const dropArea = document.getElementById("drop-area");
const fileInput = document.getElementById("file-input");
const linkPopup = document.getElementById("link-popup");
const errorPopup = document.getElementById("error-popup");
const errorText = document.getElementById("error");
const linkInput = document.getElementById("link");
const copyLinkButton = document.getElementById("copy-link-button");
const deleteTimeSlider = document.getElementById("delete-time-slider");
const deleteTimeDisplay = document.getElementById("slider-value");
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
deleteTimeSlider.addEventListener("input", () => {
  const sliderValue = parseInt(deleteTimeSlider.value);
  let deleteTimeDisplayValue;
  if (sliderValue === 0) {
    deleteTimeDisplayValue = "Never";
  } else if (sliderValue <= 12) {
    deleteTimeDisplayValue = `${sliderValue} hour${sliderValue > 1 ? "s" : ""}`;
  } else if (sliderValue === 13) {
    deleteTimeDisplayValue = "24 hours";
  } else {
    deleteTimeDisplayValue = "Never";
  }
  deleteTimeDisplay.innerHTML = deleteTimeDisplayValue;
});
const form = document.querySelector("form");
form.addEventListener("submit", (e) => {
  e.preventDefault();
  const randomToggleSwitch = document.getElementById("random-toggle-switch");
  const directToggleSwitch = document.getElementById("direct-toggle-switch");
  const file = fileInput.files[0];
  const formData = new FormData();
  formData.append("file", file);
  if (randomToggleSwitch.checked) {
    var random = 1;
  } else {
    var random = 0;
  }
  formData.append("random", random);
  if (directToggleSwitch.checked) {
    var direct = 1;
  } else {
    var direct = 0;
  }
  formData.append("direct", direct)
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
        if (deleteTimeSlider.value <= 12) {
          var deleteDate = Date.now() + deleteTimeSlider.value * 60 * 60 * 1000;
        } else {
          var deleteDate = Date.now() + 24 * 60 * 60 * 1000;
        }
        var fileName = linkEnding.substring(linkEnding.lastIndexOf("/") + 1);
        const fileData = {
          name: fileName,
          uploadTime: Date.now(),
          deleteTime: deleteDate,
        };
        var json_data = JSON.stringify(fileData);
        // Send data to PHP script using AJAX
        var xhr = new XMLHttpRequest();
        var url = "php/write.php";
        xhr.open("POST", url, true);
        xhr.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
          }
        };
        xhr.send("data=" + json_data);
        linkInput.value = linkEnding;
        linkPopup.style.display = "block";
      }
    })
    .catch((error) => {
      console.error(error);
    });
});
copyLinkButton.addEventListener("click", (e) => {
  e.preventDefault();
  linkInput.select();
  document.execCommand("copy");
  copyLinkButton.innerHTML = '<i class="fa-check"></i> Copied!';
  setTimeout(() => {
    copyLinkButton.innerHTML = '<i class="fa-clipboard"></i> Copy Link';
  }, 3000);
});
const closeButtons = document.querySelectorAll(".close");
closeButtons.forEach((button) => {
  button.addEventListener("click", (e) => {
    e.preventDefault();
    location.reload();
  });
});
