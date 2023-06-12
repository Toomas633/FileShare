const dropArea = document.getElementById("drop-area");
const fileInput = document.getElementById("file-upload");
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
dropArea.addEventListener("click", () => {
  fileInput.click();
});
fileInput.addEventListener("change", (e) => {
  const fileName = document.getElementById("file-name");
  const file = e.target.files[0];
  fileName.textContent = file.name;
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
form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const randomToggleSwitch = document.getElementById("random-toggle-switch");
  const directToggleSwitch = document.getElementById("direct-toggle-switch");
  const file = fileInput.files[0];
  const formData = new FormData();
  formData.append("file", file);
  formData.append("random", randomToggleSwitch.checked ? 1 : 0);
  formData.append("direct", directToggleSwitch.checked ? 1 : 0);
  document.getElementById('upload-status').style.display = 'flex';
  const segments = document.getElementsByClassName('segment');
  for (let segment of segments) {
    segment.style.display = 'flex';
  }
  document.getElementById('status-message').innerText = 'Uploading...';
  document.getElementById('status-message').style.color = '#fff';
  try {
    const response = await fetch("php/upload.php", {
      method: "POST",
      body: formData,
    });
    const linkEnding = await response.text();
    if (linkEnding.startsWith("ERROR: ")) {
      errorText.value = linkEnding.substring(7);
      errorPopup.style.display = "block";
      document.getElementById('upload-status').style.display = 'none';
      for (let segment of segments) {
        segment.style.display = 'none';
      }
      document.getElementById('upload-status').style.display = 'flex';
      document.getElementById('status-message').innerText = 'Upload failed!';
      document.getElementById('upload-status').style.backgroundColor = '#dc3545';
      document.getElementById('status-message').style.color = '#fff';
      setTimeout(function() {
        document.getElementById('upload-status').style.display = 'none';
      }, 3000);
    } else {
      if (deleteTimeSlider.value <= 12) {
        var deleteDate = Date.now() + deleteTimeSlider.value * 60 * 60 * 1000;
      } else {
        var deleteDate = Date.now() + 24 * 60 * 60 * 1000;
      }
      if (direct === 1) {
        var fileName = linkEnding.substring(linkEnding.lastIndexOf("/") + 1);
      }
      else {
        var fileName = linkEnding.substring(linkEnding.lastIndexOf("=") + 1);
      }
      const fileData = {
        name: fileName,
        uploadTime: Date.now(),
        deleteTime: deleteDate,
      };
      var json_data = JSON.stringify(fileData);
      var url = "php/write.php";
      const xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.upload.onprogress = function(event) {
        if (event.lengthComputable) {
          var percentage = Math.round((event.loaded / event.total) * 100);
          document.getElementById('status-message').innerText = 'Uploading... ' + percentage + '%';
        }
      };
      xhr.onload = function() {
        document.getElementById('upload-status').style.display = 'flex';
        document.getElementById('status-message').innerText = 'Upload complete!';
        for (let segment of segments) {
          segment.style.display = 'none';
        }
        document.getElementById('progress-bar').style.backgroundColor = '#2196f3';
        document.getElementById('upload-status').style.backgroundColor = '#28a745';
        document.getElementById('status-message').style.color = '#fff';
        setTimeout(function() {
          document.getElementById('upload-status').style.display = 'none';
        }, 3000);
      };
      xhr.onerror = function() {
        document.getElementById('upload-status').style.display = 'flex';
        document.getElementById('status-message').innerText = 'Upload failed!';
        for (let segment of segments) {
          segment.style.display = 'none';
        }
        document.getElementById('status-message').style.color = '#fff';
        document.getElementById('upload-status').style.backgroundColor = '#dc3545';        
        setTimeout(function() {
          document.getElementById('upload-status').style.display = 'none';
        }, 3000);
      };
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
      document.getElementById('upload-status').style.display = 'flex';
      linkInput.value = linkEnding;
      linkPopup.style.display = "block";
    }
  } catch (error) {
    console.error(error);
  }
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
const min = deleteTimeSlider.min;
const max = deleteTimeSlider.max;
const value = deleteTimeSlider.value;
deleteTimeSlider.style.setProperty("--min", min);
deleteTimeSlider.style.setProperty("--max", max);
deleteTimeSlider.style.setProperty("--value", value);
deleteTimeSlider.addEventListener("input", function () {
  deleteTimeSlider.style.setProperty("--value", deleteTimeSlider.value);
});
