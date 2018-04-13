$(document).ready(function() {
  $("#identificativoReparto").autocomplete({
      source: function(request, response) {
          $.ajax({
              url: "/sale/ajax",
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