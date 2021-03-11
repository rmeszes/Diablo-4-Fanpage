$(function() {
    $("#cookie").click(function() {
        $.ajax({
            method: "GET",
            url: "php/inc/allow_cookies.php"
        }).fail(function() {
            $.ajax({
                method: "GET",
                url: "inc/allow_cookies.php"
            });
        });
    });
});