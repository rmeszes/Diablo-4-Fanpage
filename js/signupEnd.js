$(function() {
    $("#password").keyup(function() {
    initializeStrengthMeter();
    });
});

function initializeStrengthMeter() {
    $("#pass_meter").PasswordStrengthManager({
    password: $("#password").val(),
    confirm_pass : $("#confirm_pass").val(),
    blackList : [$("#username").val()],
    minChars : "8",
    maxChars : "20",
    advancedStrength : true
    });
}


$(function() {
    $("#password").keyup(function() {
    runPasswordCheck();
    });

    $("#email").keyup(function() {
    runEmailCheck();
    });

    $("#username").keyup(function() {
    runUserCheck();
    });

    $("#confirm-password").keyup(function() {
    runConfCheck();
    });
});

function runPasswordCheck() {
    document.getElementById("passErr").innerHTML = "";
    if(!isAlphaNumericString($("#password").val())) { document.getElementById("passErr").innerHTML = "Jelszó csak számokat és betűket tartalmazhat"; }
}

function runEmailCheck() {
    document.getElementById("emailErr").innerHTML = "";
    if($("#email").val().length > 50) { document.getElementById("emailErr").innerHTML = "Email cím maximum 50 karakter"; } else
    if(!validateEmail($("#email").val())) { document.getElementById("emailErr").innerHTML = "Email cím nem érvényes"; }
}

function runUserCheck() {
    document.getElementById("userErr").innerHTML = "";
    if($("#username").val().length < 3) { document.getElementById("userErr").innerHTML = "Túl rövid név!"; } else
    if($("#username").val().length > 20) { document.getElementById("userErr").innerHTML = "Túl hosszú név!"; } else
    if(!isAlphaNumericString($("#username").val())) { document.getElementById("userErr").innerHTML = "Felhasználónév csak számokat és betűket tartalmazhat"; }
}

function runConfCheck() {
    document.getElementById("confErr").innerHTML = "";
    if($("#password").val() !== $("#confirm-password").val()) { document.getElementById("confErr").innerHTML = "A jelszavak nem egyeznek"; }
}

$(function() {
    $("#register-submit").click(function(){

        //gomb megnyomásakor hibák eltüntetése
        document.getElementById("emailErr").innerHTML = "";
        document.getElementById("passErr").innerHTML = "";
        document.getElementById("confErr").innerHTML = "";
        document.getElementById("userErr").innerHTML = "";
        //ellenőrzések
        if($("#username").val() == "") { document.getElementById("userErr").innerHTML = "Név szükséges a regisztrációhoz"; } else 
        if($("#username").val().length < 3) { document.getElementById("userErr").innerHTML = "Túl rövid név!"; } else
        if($("#username").val().length > 20) { document.getElementById("userErr").innerHTML = "Túl hosszú név!"; } else
        if(!isAlphaNumericString($("#username").val())) { document.getElementById("userErr").innerHTML = "Felhasználónév csak számokat és betűket tartalmazhat"; }

        if($("#email").val() == "") { document.getElementById("emailErr").innerHTML = "Email cím szükséges a regisztrációhoz"; } else
        if($("#email").val().length > 50) { document.getElementById("emailErr").innerHTML = "Email cím maximum 50 karakter"; } else
        if(!validateEmail($("#email").val())) { document.getElementById("emailErr").innerHTML = "Email cím nem érvényes"; }
        
        if($("#password").val() == "") { document.getElementById("passErr").innerHTML = "Jelszó szükséges a regisztrációhoz"; } else 
        if($("#password").val().length < 8) { document.getElementById("passErr").innerHTML = "Túl rövid jelszó!"; } else
        if($("#password").val().length > 20) { document.getElementById("passErr").innerHTML = "Túl hosszú jelszó!"; } else
        if(!isAlphaNumericString($("#password").val())) { document.getElementById("passErr").innerHTML = "Jelszó csak számokat és betűket tartalmazhat"; }
        
        if($("#confirm-password").val() == "") { document.getElementById("confErr").innerHTML = "Erősítsd meg a jelszavad" } else
        if($("#password").val() !== $("#confirm-password").val()) { document.getElementById("confErr").innerHTML = "A jelszavak nem egyeznek"; }

        if($("#username").val() != "" && $("#email").val() != "" && $("#password").val() != "" && validateEmail($("#email").val()) && isAlphaNumericString($("#password").val()) && $("#password").val() === $("#confirm-password").val() && $("#password").val().length > 7 && $("#password").val().length < 21 && $("#email").val().length < 51 && $("#username").val().length > 2 && $("#username").val().length < 21 && isAlphaNumericString($("#username").val())){
            $.ajax({
            method: "POST",
            url: "inc/register.php",
            data: { username: $("#username").val(), email: $("#email").val(), password: $("#password").val() }
            }).done(function( msg ) {
                alert(msg);
            });    
        } 
    });
});