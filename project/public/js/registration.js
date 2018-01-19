$(document).ready(function() {
    $(document).on('click','#submitRegistration', function() {
        var name = $("#inputName").val();
        var surname = $("#inputSurname").val();
        var email = $("#inputEmail").val();
        var arrayEmail = email.split("@");
        var password = $("#inputPassword").val();
        var confirmPassword = $("#inputConfirmPassword").val();
        var data = $("#inputDate").val();
        
        var bName = false;
        var bSurname = false;
        var bEmail = false;
        var bPassword = false;
        var bConfirmPassword = false;
        var bData = false;

        if((email == "") || (email.indexOf("@") == -1) || (email.indexOf(".") == -1) || (arrayEmail[1].indexOf(".") == -1)) {
            $("#errorEmail").css({"display":"block"});
            bEmail = false;
        } else {
            $("#errorEmail").css({"display":"none"});
            bEmail = true;
        }

        if(name.length == 0 || name.length < 3 || name.length > 256) {
            $("#errorName").css({"display":"block"});
            bName = false;
        } else {
            $("#errorName").css({"display":"none"});
            bName = true;
        }

        if(surname.length == 0 || surname.length < 3 || surname.length > 256) {
            $("#errorSurname").css({"display":"block"});
            bSurname = false;
        } else {
            $("#errorSurname").css({"display":"none"});
            bSurname = true;
        }
        
        if(password.length == 0 || password.length < 5 || password.length > 256) {
            $("#errorPassword").css({"display":"block"});
            bPassword = false;
        } else {
            $("#errorPassword").css({"display":"none"});
            bPassword = true;
        }

        if(confirmPassword != password) {
            $("#errorConfirmPassword").css({"display":"block"});
            bConfirmPassword = false;
        } else {
            $("#errorConfirmPassword").css({"display":"none"});
            bConfirmPassword = true;
        }
        
        if(data == "") {
            $("#errorDate").css({"display":"block"});
            bData = false;
        } else {
            $("#errorDate").css({"display":"none"});
            bData = true;
        }

        if(bName && bSurname && bEmail && bPassword && bConfirmPassword && bData) {
            $("#formRegistration").submit();
        }
    });
    
    /* serve per mostrare l'immagine inserita dall'utente */
    $(document).on('click','#inputImage', function() {
        $("#inputImage").on("change", function() {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return;
            
            if (/^image/.test( files[0].type)) { 
                var reader = new FileReader(); 
                reader.readAsDataURL(files[0]); 
                
                reader.onloadend = function(){ 
                    $("#divUpload").css({"background-image":"url("+this.result+")"});
                };
            }
        });
    });    
    $(document).on('click','#close', function() {
        $("#divUpload").empty();
        var string = "<div id='close'></div>";
        string += "<input id='inputImage' type='file' name='image'/>";
        $("#divUpload").append(string);
        $("#divUpload").css({"background":"url(./systemImages/defaultUserImage.svg) 50% 0 / cover no-repeat;"});
        
    });
    /* fine inserimento immagini dell'utente */
});
