function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$(document).ready(function(){
    $(document).on('click', '.bottone.amicizia.nuova' ,function(){
        var utenteID2=$(this).attr('value');
        $.ajax({
            url : "/amici/nuova",
            method : "GET",
            data : {value:utenteID2,_token:"{{csrf_token()}}"},
            dataType : "text",
            success : function (data) {
                $('#div-friendBox-button'+utenteID2).empty();
                $('#div-friendBox-button'+utenteID2).append(data);
                $('#div-friendBox-message'+utenteID2).empty();
                $('#div-friendBox-message'+utenteID2).append("Richiesta Inviata").fadeIn( 30 ).fadeOut( 3000 );
            },
            error: function (xhr, status, error) {

            }
        });
    }); 
    $(document).on('click', '.bottone.amicizia.elimina' ,function(){
        var utenteID2=$(this).attr('value');
        $.ajax({
            url : "/amici/cancella",
            method : "GET",
            data : {value:utenteID2,_token:"{{csrf_token()}}"},
            dataType : "text",
            success : function (data) {
                $('#div-friendBox-button'+utenteID2).empty();
                $('#div-friendBox-button'+utenteID2).append(data);

                $('.classedarimuovere').remove();

            },
            error: function (xhr, status, error) {

            }
        });
    });
    $(document).on('click', '.bottone.amicizia.accetta' ,function(){
        var utenteID2=$(this).attr('value');
        $.ajax({
            url : "/amici/accetta",
            method : "GET",
            data : {value:utenteID2,_token:"{{csrf_token()}}"},
            dataType : "text",
            success : function (data) {
                $('#div-friendBox-button'+utenteID2).empty();
                $('#div-friendBox-button'+utenteID2).append(data);
                $('#div-friendBox-message'+utenteID2).empty();
                $('#div-friendBox-message'+utenteID2).append("Amicizia accettata").fadeIn( 30 ).fadeOut( 3000 );
            },
            error: function (xhr, status, error) {

            }
        });
    });
    $(document).on('click', '.bottone.amicizia.blocca' ,function(){
        var utenteID2=$(this).attr('value');
        $.ajax({
            url : "/amici/blocca",
            method : "GET",
            data : {value:utenteID2,_token:"{{csrf_token()}}"},
            dataType : "text",
            success : function (data) {
                $('#div-friendBox-button'+utenteID2).empty();
                $('#div-friendBox-button'+utenteID2).append(data);
                $('#div-friendBox-message'+utenteID2).empty();
                $('#div-friendBox-message'+utenteID2).append("Utente bloccato").fadeIn( 30 ).fadeOut( 3000 );
                $('.classedarimuovere').remove();
            },
            error: function (xhr, status, error) {

            }
        });
    });   
});

$(document).ready(function(){
    var utenteID2 = getParameterByName('utenteID');
    $.ajax({
        url : "/amici/button",
        method : "GET",
        data : {value:utenteID2,_token:"{{csrf_token()}}"},
        dataType : "text",
        success : function (data) {
            $('#div-friendBox-button'+utenteID2).empty();
            $('#div-friendBox-button'+utenteID2).append(data);
        },
        error: function (xhr, status, error) {

        }
    });  
});

