$(document).ready(function() {
    $(document).on('click','.like',function() {
        var postID = $(this).attr("id").split("-")[1];
        var nome = $("#username").val();
        var cognome = $("#surname").val();
        
        $("#banana-"+postID).empty();
        var string = "<img class='dislike' id='image-"+postID+"' src='{{ asset('/systemImages/banana-si.png') }}' height='20px' border='0' style='cursor: pointer'>";
        $("#banana-"+postID).append(string);
        var likes = parseInt($("#contentLikes-"+postID).text());
        likes++;
        $("#contentLikes-"+postID).empty();
        $("#contentLikes-"+postID).append(likes);
        $.ajax({
            type: "post",
            url: "home",
            data: {
                control: 2,
                postID: postID,
                nome: nome,
                cognome: cognome,
                utenteID: utenteID,
                _token: "{{csrf_token()}}"
            },
            success: function() {
            },
            error: function(xhr, status, error){
                $("#banana-"+postID).empty();
                var string = "<img class='like' id='image-"+postID+"' src='{{ asset('/systemImages/banana-no.png') }}' height='20px' border='0' style='cursor: pointer'>";
                $("#banana-"+postID).append(string);
                var likes = parseInt($("#contentLikes-"+postID).text());
                likes--;
                $("#contentLikes-"+postID).empty();
                $("#contentLikes-"+postID).append(likes);
            }
        });
   });
   $(document).on('click','.dislike',function() {
        var postID = $(this).attr("id").split("-")[1];
        $("#banana-"+postID).empty();
        var string = "<img class='like' id='image-"+postID+"' src='{{ asset('/systemImages/banana-no.png') }}' height='20px' border='0' style='cursor: pointer'>";
        $("#banana-"+postID).append(string);
        var likes = parseInt($("#contentLikes-"+postID).text());
        likes--;
        $("#contentLikes-"+postID).empty();
        $("#contentLikes-"+postID).append(likes);
        $.ajax({
            type: "post",
            url: "home",
            data: {
                control: 3,
                postID: postID,
                _token: "{{csrf_token()}}"
            },
            success: function() {
            },
            error: function(xhr, status, error){
                $("#banana-"+postID).empty();
                var string = "<img class='dislike' id='image-"+postID+"' src='{{ asset('/systemImages/banana-si.png') }}' height='20px' border='0' style='cursor: pointer'>";
                $("#banana-"+postID).append(string);
                var likes = parseInt($("#contentLikes-"+postID).text());
                likes++;
                $("#contentLikes-"+postID).empty();
                $("#contentLikes-"+postID).append(likes);
            }
        });
    });
    $(document).on('click','.comment',function() {
        var postID = $(this).attr("id").split("-")[1];        
        $("#contentComment-"+postID).empty();
        var string = "<b>Caricamento commenti...</b>";
        $("#contentComment-"+postID).append(string);
        $.ajax({
            type: "post",
            url: "home",
            data: {
                control: 4,
                postID: postID,
                _token: "{{csrf_token()}}"
            },
            success: function(result) {
                $("#contentComment-"+postID).empty();
                var stringToAppend = "<div class='inputCommento' id='inputCommento-"+postID+"'>";
                for(var i=0; i<result.length; i++) {
                    stringToAppend += "<div class='styleComment'>";
                        stringToAppend += "<div class='userComment'><div class='userImageComment' style='background: url("+result[i].immagine+") 50% 0% / cover no-repeat;'></div></div>";
                        stringToAppend += "<div class='userNameComment'>";
                            stringToAppend += "<p><a href='/profilo/id?utenteID="+result[i].utenteID+"'><b>"+result[i].nome+" "+result[i].cognome+": </b></a> "+result[i].contenuto+"</p>";
                        stringToAppend += "</div>";
                    stringToAppend += "</div>";
                }
                stringToAppend += "</div>";
                stringToAppend += "<div style='background-color: #ededed'><textarea class='commentTextarea' id='commentTextarea-"+postID+"' cols='40' rows='1' spellcheck='false' placeholder='Scrivi il commento..'/>";
                stringToAppend += "<button class='submitComment' id='submitComment-"+postID+"'>Invia</button></div>";
                //stringToAppend += "</div>";
                $("#contentComment-"+postID).append(stringToAppend);
                $("#inputCommento-"+postID).scrollTop($("#inputCommento-"+postID)[0].scrollHeight);
                /*var objDiv = document.getElementById("#inputCommento-"+postID);
                objDiv.scrollTop = objDiv.scrollHeight;*/
            },
            error: function(xhr, status, error) {
                $("#contentComment-"+postID).empty();
            }
        });
    });
        
    $(document).on('click','.submitComment', function() {
        var postID = $(this).attr("id").split("-")[1];
        var contenuto = $("#commentTextarea-"+postID).val();
        $("#commentTextarea-"+postID).val("");
        if(contenuto != "") {
            var nome = $("#username").val();
            var cognome = $("#surname").val();
            var immagine = $("#image").val();
            var utenteID = $("#userID").val();

            var stringToAppend = "<div class='styleComment'>";
            stringToAppend += "<div class='userComment'><div class='userImageComment' style='background: url("+immagine+") 50% 0% / cover no-repeat;'></div></div>";
            stringToAppend += "<div class='userNameComment'>";
                stringToAppend += "<p><a href='/profilo/id?utenteID="+utenteID+"'><b>"+nome+" "+cognome+": </b></a> "+contenuto+"</p>";
            stringToAppend += "</div>";
            stringToAppend += "</div>";
            stringToAppend += "</div>";
            $("#inputCommento-"+postID).append(stringToAppend);
            $("#inputCommento-"+postID).scrollTop($("#inputCommento-"+postID)[0].scrollHeight);
            
            $.ajax({
                type: "post",
                url: "home",
                data: {
                    control: 5,
                    postID: postID,
                    contenuto: contenuto,
                    _token: "{{csrf_token()}}"
                },
                success: function() {
                },
                error: function() {
                },
            });
        }
    });
});

