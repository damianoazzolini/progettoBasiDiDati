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
        minLength: 0,
    });

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
        minLength: 0,
    });

    $("#nomeStaff").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/prestazioniNomeStaff/ajax",
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
        minLength: 0,
    });

    $("#cognomeStaff").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/prestazioniCognomeStaff/ajax",
                dataType: "json",
                data: {
                    cognome : request.term,
                    nome : $("#nomeStaff").val(),
                    reparto : $("#identificativoReparto").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 0,
    });

    $("#codiceFiscale").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "/prestazioniCodiceFiscale/ajax",
                dataType: "json",
                data: {
                    cf : request.term,
                    cognome : $("#cognomePaziente").val(),
                    nome : $("#nomePaziente").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 0,
    });
});