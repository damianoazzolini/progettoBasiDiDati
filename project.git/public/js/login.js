$(document).ready(function() {
    $(document).on('click','#submitLogin', function() {
        var email = $("#inputEmail").val();
        var arrayEmail = email.split("@");
        var password = $("#inputPassword").val();
        var bEmail = false;
        var bPassword = false;        
        
        if((email == "") || (email.indexOf("@") == -1) || (email.indexOf(".") == -1) || (arrayEmail[1].indexOf(".") == -1)) {
            $("#errorEmail").css({"display":"block"});
            bEmail = false;
        } else {
            $("#errorEmail").css({"display":"none"});
            bEmail = true;
        }
        
        if(password.length == 0 || password.length < 5 || password.length > 256) {
            $("#errorPassword").css({"display":"block"});
            bPassword = false;
        } else {
            $("#errorPassword").css({"display":"none"});
            bPassword = true;
        }
        
        if(bEmail && bPassword) {
            $("#formLogin").submit();
        }
    });
});