$(document).ready(function() {
    $("#identificativoReparto").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/prestazioniReparto/ajax",
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 1,
    });
});

$(document).ready(function() {
    $("#identificativoSala").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/prestazioniSala/ajax",
                dataType: "json",
                data: {
                    term : request.term,
                    reparto : $("#identificativoReparto").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 1,
    });
});

$(document).ready(function() {
    $("#codiceFiscale").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/prestazioniCodiceFiscale/ajax",
                dataType: "json",
                data: {
                    cognome : $("#cognomePaziente").val(),
                    nome : $("#nomePaziente").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 1,
    });
});