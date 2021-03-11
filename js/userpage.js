$(function() {
    $("#password").keyup(function() {
    initializeStrengthMeter();
    });
});

function initializeStrengthMeter() {
    $("#pass_meter").PasswordStrengthManager({
    password: $("#password").val(),
    confirm_pass : $("#confirm-pass").val(),
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

    $("#username").keyup(function() {
    runUserCheck();
    });

    $("#confirm-password").keyup(function() {
    runConfCheck();
    });

    $("#old-password").keyup(function() {
    runOldPasswordCheck();
    });
});

function runOldPasswordCheck() {
    document.getElementById("oldErr").innerHTML = "";
    if(!isAlphaNumericString($("#old-password").val())) { document.getElementById("oldErr").innerHTML = "Jelszó csak számokat és betűket tartalmazhat"; }
}

function runPasswordCheck() {
    document.getElementById("passErr").innerHTML = "";
    if(!isAlphaNumericString($("#password").val())) { document.getElementById("passErr").innerHTML = "Jelszó csak számokat és betűket tartalmazhat"; }
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
    $("#update-btn").click(function(){
        //gomb megnyomásakor hibák eltüntetése
        document.getElementById("userErr").innerHTML = "";
        document.getElementById("passErr").innerHTML = "";
        //ellenőrzések
        if($("#username").val() == "") { document.getElementById("userErr").innerHTML = "Nem lehet üres"; } else 
        if($("#username").val().length < 3) { document.getElementById("userErr").innerHTML = "Túl rövid név!"; } else
        if($("#username").val().length > 20) { document.getElementById("userErr").innerHTML = "Túl hosszú név!"; } else
        if(!isAlphaNumericString($("#username").val())) { document.getElementById("userErr").innerHTML = "Felhasználónév csak számokat és betűket tartalmazhat"; }

        if($("#password").val() != "") { 
            if($("#password").val().length < 8) { document.getElementById("passErr").innerHTML = "Túl rövid jelszó!"; } else
            if($("#password").val().length > 20) { document.getElementById("passErr").innerHTML = "Túl hosszú jelszó!"; } else
            if(!isAlphaNumericString($("#password").val())) { document.getElementById("passErr").innerHTML = "Jelszó csak számokat és betűket tartalmazhat"; }
        }

        if($("#old-password").val() == "") { document.getElementById("oldErr").innerHTML = "Jelszó szükséges a változtatásokhoz"; } else
        if(!isAlphaNumericString($("#old-password").val())) { document.getElementById("oldErr").innerHTML = "Jelszó csak számokat és betűket tartalmazhat"; }

        if($("#password").val() != "") { 
            if($("#confirm-pass").val() == "") { document.getElementById("confErr").innerHTML = "Erősítsd meg a jelszavad" } else
            if($("#password").val() !== $("#confirm-pass").val()) { document.getElementById("confErr").innerHTML = "A jelszavak nem egyeznek"; }
        }

        //form submit ajaxxal ha minden jó
        if($("#email").val() != "" && $("#username").val() != "" && validateEmail($("#email").val()) && $("#old-password").val() != "" && $("#password").val() === $("#confirm-pass").val() && isAlphaNumericString($("#old-password").val()) &&  isAlphaNumericString($("#username").val()) && $("#username").val().length > 2 && $("#username").val().length < 21){
            if($("#password").val() != "") {
                if(isAlphaNumericString($("#password").val()) && $("#password").val().length > 7 && $("#password").val().length < 21) {
                    $.ajax({
                        method: "POST",
                        url: "inc/update.php",
                        data: { email: $("#email").val(), password: $("#password").val(), oldPass: $("#old-password").val(), username: $("#username").val() }
                    }).done(function( msg ) {
                        alert(msg);
                        location.reload();
                    });
                } 
            } else {
                $.ajax({
                method: "POST",
                url: "inc/update.php",
                data: { email: $("#email").val(), password: $("#password").val(), oldPass: $("#old-password").val(), username: $("#username").val() }
            }).done(function( msg ) {
                alert(msg);
                location.reload();
            });
            }
            
            
        }
        
    });
});