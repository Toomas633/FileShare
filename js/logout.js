window.addEventListener("beforeunload", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "php/logout.php", false); // Set the URL of the PHP script that unsets the session variable
    xhr.send();
});