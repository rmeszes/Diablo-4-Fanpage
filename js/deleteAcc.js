$(function() {
    $("#delBtn").click(function(){
        $.ajax({
            method: "POST",
            url: "inc/delete_acc.php",
            data: { email: $("#email").val(), passDelete: $("#passDelete").val() }
        }).done(function(err) {
            if(err == 'index'){ 
                window.location.replace("../index.php"); 
            } else {
                document.getElementById("delErr").innerHTML = err;
            }
        });
    });
});