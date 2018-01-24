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
    $(document).on('click', '.bottone.pagina.nuova' ,function(){
        var paginaID = $(this).attr('value');
        $.ajax({
            url : "/pagine/nuova",
            method : "GET",
            data : {value:paginaID,_token:"{{csrf_token()}}"},
            dataType : "text",
            success : function (data) {
                $('#div-pagesBox-button'+paginaID).empty();
                $('#div-pagesBox-button'+paginaID).append(data);
                $('#div-pagesBox-message'+paginaID).empty();
                $('#div-pagesBox-message'+paginaID).append("Ora segui la pagina").fadeIn( 30 ).fadeOut( 3000 );
            },
            error: function (xhr, status, error) {

            }
        });
    }); 
    $(document).on('click', '.bottone.pagina.elimina' ,function(){
        var paginaID = $(this).attr('value');
        $.ajax({
            url : "/pagine/cancella",
            method : "GET",
            data : {value:paginaID,_token:"{{csrf_token()}}"},
            dataType : "text",
            success : function (data) {
                $('#div-pagesBox-button'+paginaID).empty();
                $('#div-pagesBox-button'+paginaID).append(data);
            },
            error: function (xhr, status, error) {

            }
        });
    });
});

$(document).ready(function(){
    var paginaID = getParameterByName('paginaID');
    $.ajax({
        url : "/pagine/button",
        method : "GET",
        data : {value:paginaID,_token:"{{csrf_token()}}"},
        dataType : "text",
        success : function (data) {
            $('#div-pagesBox-button'+paginaID).empty();
            $('#div-pagesBox-button'+paginaID).append(data);
        },
        error: function (xhr, status, error) {

        }
    });  
});
