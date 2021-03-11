function reply_click(id) {
    $.ajax({
        method: "GET",
        url: "inc/delete_topic.php",
        data: { id: id }
        }).done(function() {
            location.reload();
        });
    }