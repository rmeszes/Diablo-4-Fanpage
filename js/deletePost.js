function reply_click(id) {
    $.ajax({
        method: "GET",
        url: "inc/delete_post.php",
        data: { id: id }
        }).done(function() {
            location.reload();
        });
    }