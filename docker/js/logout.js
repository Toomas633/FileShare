window.addEventListener("beforeunload", function() {
    $.ajax({
        url: 'php/logout.php',
        async: false
    });
});