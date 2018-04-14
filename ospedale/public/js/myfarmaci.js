$(document).ready(function() {
  $("#categoria").autocomplete({
      source: function(request, response) {
          $.ajax({
              url: "/myfarmaci/ajaxCategoria",
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
  $("#nome").autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "/myfarmaci/ajaxNome",
            dataType: "json",
            data: {
                term : request.term,
                categoria : document.getElementById('categoria').value
            },
            success: function(data) {
                response(data);
            }
        });
    },
    minLength: 0,
});
});