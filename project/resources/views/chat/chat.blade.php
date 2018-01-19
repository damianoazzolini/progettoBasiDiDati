<html>
    <head>
        <title>Messaggi</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Type" content="json; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script charset="utf-8" type="text/javascript">
            $(".sendMessage").val("0");
            $("#lastID").val("0");
            recursive();
            function recursive(){
                var x = setTimeout(function(){reMessages()}, 1000);
            }
            
            function reMessages() {
                try {
                    var friendID = $(".sendMessage").attr("id").split("-")[1];
                    var userID = $("#utenteID").val();
                    var chatIdentifier1 = userID+"_"+friendID;
                    var chatIdentifier2 = friendID+"_"+userID;
                    var lastID = parseInt($("#lastID").val())+1;
                    $.ajax({
                        type: "post",
                        url: "chat",
                        data: {
                            control: "getNewMessages",
                            lastID: lastID,
                            chatID1: chatIdentifier1,
                            chatID2: chatIdentifier2,
                            _token: "{{csrf_token()}}"
                        },
                        success: function(result) {
                            if(result != "none") {
                                var string = "";
                                var i=0;
                                var length = result.length;
                                for(i=0; i<result.length; i++) {
                                    if(result[i].senderID == userID) {
                                        string += "<div class='divMessaggio'><table class='mioMess'>";
                                        string += "<tr><td>"+result[i].text+"</td></tr>";
                                        string += "<tr><td style='text-align: right;'>"+result[i].created_at+"</td></tr>";
                                        string += "</table></div>";
                                    } else {
                                        string += "<div class='divMessaggio'><table class='suoMess'>";
                                        string += "<tr><td>"+result[i].text+"</td></tr>";
                                        string += "<tr><td style='text-align: right;'>"+result[i].created_at+"</td></tr>";
                                        string += "</table></div>";
                                    }
                                }
                                string += "</div>";
                                string += "<input type='hidden' id='lastID' value='"+result[length-1].chatID+"'>";

                                var status = $("#statusChat").val();
                                if(status == "vuoto") {
                                    $(".divMessagesContent").empty();
                                }
                                $("#lastID").remove();
                                $(".divMessagesContent").append(string);
                                $(".divMessagesContent").scrollTop($(".divMessagesContent")[0].scrollHeight);
                            }
                        },
                        error: function(xhr, status, error) {
                            //alert("errore  -> "+xhr+"  STATUS -> "+status+"  ERROR -> "+error);
                        },
                    });
                } catch(e) {
                    
                } finally {
                    recursive();
                }                
            }
            
            $(document).on({
                mouseenter: function () {
                    $(this).css({"background-color":"#a4dda2"});
                },
                mouseleave: function () {
                    $(this).css({"background":"none"});
                }
            }, ".divFriend");
            $(document).on('click','.divFriend', function() {
                var friendID = $(this).attr("id").split("-")[1];
                var nome = $("#friendName-"+friendID).text();
                $(".divSelected").css({"background":"none","color":"#000000"});
                $(".divSelected").attr("class","divFriend");
                $(this).attr("class","divSelected");
                $(this).css({"background-color":"#133212","color":"#FFFFFF"});

                /* mostrare il caricamento */
                var userID = $("#utenteID").val();
                var chatID1 = userID+"_"+friendID;
                var chatID2 = friendID+"_"+userID;
                
                var string = "<div class='loading'></div>";
                $("#chatContent").empty();
                $("#chatContent").append(string);
                
                $.ajax({
                    type: "post",
                    url: "chat",
                    data: {
                        control: "getFriendChat",
                        chatID1: chatID1,
                        chatID2: chatID2,
                        _token: "{{csrf_token()}}"
                    },
                    success: function(result) {
                        if(result === "none") {
                            var string = "<div class='divMessagesContent'>";
                            string += "<p id='p_select'>Inizia a chattare con <b>"+nome+"</b></p>";
                            string += "</div>";
                            string += "<input type='hidden' id='lastID' value='0'>";
                            //string += "<div id='notification'></div>";
                            string += "<div class='divSender'>";
                            string += "<input type='hidden' value='vuoto' id='statusChat'>";
                            string += "<textarea class='textareaSender' id='text-"+friendID+"' placeholder='Scrivi il messaggio..'></textarea>";
                            string += "<button type='button' class='sendMessage' id='sendMessage-"+friendID+"'><b>Invia</b></button>";
                            string += "</div>";
                            $("#chatContent").empty();
                            $("#chatContent").append(string);
                        } else {
                            var string = "<div class='divMessagesContent'>";
                            var i=0;
                            var length = parseInt(result.length);

                            for(i=0; i<result.length; i++) {
                                if(result[i].senderID == userID) {
                                    string += "<div class='divMessaggio'><table class='mioMess'>";
                                    string += "<tr><td>"+result[i].text+"</td></tr>";
                                    string += "<tr><td style='text-align: right;'>"+result[i].created_at+"</td></tr>";
                                    string += "</table></div>";
                                } else {
                                    string += "<div class='divMessaggio'><table class='suoMess'>";
                                    string += "<tr><td>"+result[i].text+"</td></tr>";
                                    string += "<tr><td style='text-align: right;'>"+result[i].created_at+"</td></tr>";
                                    string += "</table></div>";
                                }
                            }
                            string += "</div>";
                            string += "<input type='hidden' id='lastID' value='"+result[length-1].chatID+"'>";
                            //string += "<div id='notification'></div>";
                            string += "<div class='divSender'>";
                            string += "<textarea class='textareaSender' id='text-"+friendID+"' placeholder='Scrivi il messaggio..'></textarea>";
                            string += "<button type='button' class='sendMessage' id='sendMessage-"+friendID+"'><b>Invia</b></button>";
                            string += "</div>";
                            $("#chatContent").empty();
                            $("#chatContent").append(string);
                            $(".divMessagesContent").scrollTop($(".divMessagesContent")[0].scrollHeight);
                        }
                    },
                    error: function(xhr, status, error){
                       // alert("errore  -> "+xhr+"  STATUS -> "+status+"  ERROR -> "+error);
                    }
                });
            });
            $(document).on('click','.sendMessage', function() {
                sendMessage();
            });
            
            $(document).keypress(function(e) {
                
                if(e.which == 13) {
                    sendMessage();
                }
            });
            
            function sendMessage() {
                var friendID = $(".sendMessage").attr("id").split("-")[1];
                var text = $("#text-"+friendID).val();
                
                if(text != "") {
                    var userID = $("#utenteID").val();
                    var chatID = friendID+"_"+userID;
                    $("#text-"+friendID).val("");
                    /* mettere il sending */
                    var status = $("#statusChat").val();
                    if(status == "vuoto") {
                        $(".divMessagesContent").empty();
                        $("#statusChat").val("");
                    }
                    
                    $.ajax({
                        type: "post",
                        url: "chat",
                        data: {
                            control: "sendMessage",
                            chatID: chatID,
                            receiverID: friendID,
                            text: text,
                            _token: "{{csrf_token()}}"
                        },
                        success: function() {
                            $("#text-"+friendID).val("");
                        },
                        error: function(xhr, status, error){
                           
                        }
                    });
                }
            };
        </script>
        <link type="text/css" rel="stylesheet" href="{{asset('/css/home.css')}}"/> 
        <link type="text/css" rel="stylesheet" href="{{asset('/css/layout.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{asset('/css/messaggi.css')}}"/>
        <link rel="shortcut icon" href="{{ asset('/systemImages/favicon.ico') }}"/>        
    </head>
    <body>
        @include('layouts.menu')
        <input type="hidden" value="{{ $utente->utenteID }}" id="utenteID"/>
        <div class="contentFriend">
            <h1 style="position: relative; top: 90px; text-align: center;">Chatta con i tuoi amici</h1>
            <div id="chatContainer">
                <div id="friendListContainer">
                    <?php foreach($amici as $amico) { ?>
                        <div class="divFriend" id="friend-<?php echo $amico->utenteID ?>">
                            <input type="hidden" value="<?php echo $amico->nome." ".$amico->cognome ?>" id="fiendName-">
                            <div class="photoFriend" style="background: url(<?php echo $amico->immagine ?>) 50% 0 / cover no-repeat, #FFFFFF;"></div>
                            <div class="friendName" id="friendName-<?php echo $amico->utenteID ?>"><?php echo $amico->nome." ".$amico->cognome ?></div>
                        </div>
                    <?php } ?>
                </div>
                <div id="chatContent">
                    <input type="hidden" value="0" class="sendMessage" id="pl-0"/>
                    <input type="hidden" value="0" id="lastID"/>
                    <p id="p_select">Seleziona un amico per iniziare a chattare</p>
                </div>
            </div>
            
            
        </div>
    </body>
</html>