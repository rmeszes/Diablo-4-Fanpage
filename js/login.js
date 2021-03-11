$(function() {
    $("#login-submit").click(function(){
        //gomb megnyomásakor hibák eltüntetése
        document.getElementById("emailErr").innerHTML = "";
        document.getElementById("passErr").innerHTML = "";
        //ellenőrzések
        if($("#email").val() == "") { document.getElementById("emailErr").innerHTML = "Email cím szükséges a bejelentkezéshez"; } else
        if(!validateEmail($("#email").val())) { document.getElementById("emailErr").innerHTML = "Email cím nem érvényes"; }
        
        if($("#password").val() == "") { document.getElementById("passErr").innerHTML = "Jelszó szükséges a bejelentkezéshez"; } else
        if(!isAlphaNumericString($("#password").val())) { document.getElementById("passErr").innerHTML = "Jelszó csak számokat és betűket tartalmazhat"; }
        //form submit ajaxxal ha minden jó
        if($("#email").val() != "" && $("#password").val() != "" && validateEmail($("#email").val())){
            $.ajax({
              method: "POST",
              url: "inc/login_inc.php",
              data: { email: $("#email").val(), password: $("#password").val() }
            }).done(function( msg ) {
                if(msg !== ""){
                    document.getElementById("loginErr").innerHTML = msg;
                }else{
                    window.location = "../index.php";
                }
            });
        }
    });
});