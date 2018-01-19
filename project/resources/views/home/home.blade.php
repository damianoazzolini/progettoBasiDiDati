@extends('layouts.master')

@section('content')
        <div class="contentHome">
            <div id="contentHomeLeft">
                <input type="hidden" id="username" value="{{ $utente->nome }}"/>
                <input type="hidden" id="surname" value="{{ $utente->cognome }}"/>
                <input type="hidden" id="image" value="{{ $utente->immagine }}"/>
                <input type="hidden" id="userID" value="{{ $utente->utenteID }}"/>
            	<div class="content">
                    <div class="scriviPost">
                        <form action="home" method="POST" enctype="multipart/form-data" id="formPost">
                            {{ csrf_field() }}
                            <textarea id='postTextarea' name="post" cols="40" rows="5" spellcheck="false" placeholder="A cosa stai pensando?"></textarea>
                            <input type="file" name="image">
                            <input type="hidden" name="control" value="sendPost"> 
                            <button type="button" id="postButton"><b>Post</b></button>
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                {{ $error }}
                                </li>
                            @endforeach
                            </ul>
                        </form>
                    </div>
                </div>
                <!-- Imposto lingua italiana -->
                <div style="display:none">{{ Carbon\Carbon::setLocale('it')}}</div>
                <?php foreach($post as $pubblica){ ?>
                    <div class="content">
                        <div class ="user">
                            <div id="userImage">
                                <div id="cornice" style="background: url(<?php echo $pubblica->immagine ?>) 50% 0 / cover no-repeat; width: 50px;"></div>
                            </div>
                            <div id="userName">
				<a href="/profilo/id?utenteID=<?php echo $pubblica->utenteID?>">
                                    <h3><?php  echo $pubblica->nome." ".$pubblica->cognome;  ?></h3>
                                    <div id="clock">
                                    {{ Carbon\Carbon::parse($pubblica->created_at)->diffForHumans()}}
                                    </div>
                                </a>
                            </div>	
                        </div>
                        <div id="testo">
                            <?php echo $pubblica->contenuto; ?>
                        </div>
                        <?php if ($pubblica->percorso!=null) { ?>
                        <div class="postImage" style="background: url(<?php echo $pubblica->percorso ?>) 0% 0% / cover no-repeat, #FFF; width: 100%;"></div>
                        <?php } ?>
                        
                        <div class='contentLike' style="display: flex; padding-bottom: 10px;">
                            <div style="text-align: left; width: 50%;"><img src="{{ asset('/systemImages/contaBanane.png') }}" height="20px" border="0" style='float: left; margin-right: 5px;'>
                                <div id="contentLikes-<?php echo $pubblica->postID ?>" style="margin-top: 5px;">
                                    <?php if($pubblica->likes == NULL) {
                                        echo '0'; 
                                    } else {
                                        echo $pubblica->likes;
                                    } ?>
                                    
                                </div>
                            </div>
                            <div style="float: right; width: 50%; text-align: right; font-size: 18px;">
                                <a style="text-decoration: none; font-family: unset;color: #133212;font-size: 15px;font-weight: 600;" href="/posts/<?php echo $pubblica->postID ?>">Visualizza <img src="{{ asset('/systemImages/zoom.svg') }}" style="width: 20px"/></a>
                            </div>
                        </div>
                        <div class="contentLike">
                            <div id="like">
                                <div id='banana-<?php echo $pubblica->postID ?>'>
                                    <?php $trovato=true; foreach($likes as $like) { 
                                        if($like->postID == $pubblica->postID) {
                                            $trovato=false;
                                            break;
                                        }
                                    }
                                    if($trovato) { ?>
                                    <img class="like" id='image-<?php echo $pubblica->postID ?>' src="{{ asset('/systemImages/banana-no.png') }}" height="20px" border="0" style='cursor: pointer'>
                                    <?php } else { ?>
                                    <img class="dislike" id='image-<?php echo $pubblica->postID ?>' src="{{ asset('/systemImages/banana-si.png') }}" height="20px" border="0" style='cursor: pointer'>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="contentComment">
                            <div id="comment-<?php echo $pubblica->postID ?>">
                                <div class="comment" id='commento-<?php echo $pubblica->postID ?>'><img src="{{ asset('/systemImages/commento.png') }}" height="20px" border="0" style='cursor: pointer'></div>
                                <div class="contentComment" id="contentComment-<?php echo $pubblica->postID ?>"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?> 
            </div>   
            <div id="contentHomeRight">
                <!-- Widget Meteo -->
                <div class="content-weather">                
                <a href="https://www.accuweather.com/it/it/ferrara/212982/weather-forecast/212982" class="aw-widget-legal">
                </a><div id="awcc1514318547318" class="aw-widget-current"  data-locationkey="212982" data-unit="c" data-language="it" data-useip="false" data-uid="awcc1514318547318"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>
                </div>
                <div class="content consigli">
                    <h3>Persone che potresti conoscere</h3>    
                    <!-- restituisce nome consigliato -->
                    @foreach ($suggeriti as $suggerito)
                        @if(!empty($suggerito[0]->utenteID))
                            @if($suggerito[0]->utenteID > 0)
                                <div class="content consigli amico">
                                    <div class ="user">
                                        <div id="userImage">
                                            <div id="cornice" ><img src="<?php echo $suggerito[0]->immagine ?>"></div>
                                        </div>
                                        <div id="userName">
                                            <p><a href="/profilo/id?utenteID={{ $suggerito[0]->utenteID or '' }}"> {{ $suggerito[0]->nome or '' }} {{ $suggerito[0]->cognome or '' }}</a> </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach   
                </div>         
                <div class="createPage"> 
                    <form action="pagina" method="POST" enctype="multipart/form-data" id="formPost">
                        {{ csrf_field() }}
                        <input type="submit"> Crea Pagina
                    </form>
                </div>           
            </div>
        </div>
@endsection
@section('scripts')

<script>
$(document).ready(function(){
    $(document).on('click','#postButton', function() {
       var text = $("#postTextarea").val();
       if(text != "") {
           $("#formPost").submit();
       }
    });
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
                control: "like",
                postID: postID,
                nome: nome,
                cognome: cognome,
                _token: "{{csrf_token()}}"
            },
            success: function() {
                //alert("successo");
            },
            error: function(xhr, status, error){
                alert("XHR -> "+xhr+"  STATUS -> "+status+"  ERROR -> "+error);
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
                control: "dislike",
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
        $("#comment-"+postID).empty();
        var append = "<div class='closeComment' id='commento-"+postID+"'><img src='{{ asset('/systemImages/commento.png') }}' height='20px' border='0' style='cursor: pointer'></div>";
        append += "<div class='contentComment' id='contentComment-"+postID+"'></div>";
        $("#comment-"+postID).append(append);
        
        $("#contentComment-"+postID).empty();
        var string = "<b>Caricamento commenti...</b>";
        $("#contentComment-"+postID).append(string);
        $.ajax({
            type: "post",
            url: "home",
            data: {
                control: "getComment",
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
                    control: "submitComment",
                    postID: postID,
                    contenuto: contenuto,
                    _token: "{{csrf_token()}}"
                },
            });
        }
    });
     $(document).on('click','.closeComment',function() {
        var postID = $(this).attr("id").split("-")[1];        
        $("#contentComment-"+postID).empty();
        $("#comment-"+postID).empty();
        var append = "<div class='comment' id='commento-"+postID+"'><img src='{{ asset('/systemImages/commento.png') }}' height='20px' border='0' style='cursor: pointer'></div>";
        append += "<div class='contentComment' id='contentComment-"+postID+"'></div>";
        $("#comment-"+postID).append(append);
    });
});
</script>


@endsection