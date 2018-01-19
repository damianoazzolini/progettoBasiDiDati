@extends('layouts.master')

@section('content')

<div class="contentHome" >
<div id="contentHomeLeft">
<div class="content" style="margin-bottom:80px">

<div id="visualizzo-post">
	<div class ="user">
        <div id="userImage">
               <div id="cornice" style="background: url({{$autorePost->immagine}}) 50% 0 / cover no-repeat; "></div> 
        </div>
        <div id="userName">
        @if($eliminapost===1)
        <img id="rimuovipost" src="{{ asset('/systemImages/cancel-button.svg') }}" height="25px" border="0" style='float:right;margin-right: 5px; margin-top:10px;'>
        @endif 
            <a href="/profilo/id?utenteID={{$autorePost->utenteID}}">
              <h3>
           		 {{$autorePost->nome}} {{$autorePost->cognome}}
          	  </h3>
            </a>
           <div class="postPageDate">{{$time}}</div>
        </div>
  </div>
  <div id="testo">
    {{$post->contenuto}} 
  </div>   
    @if($percorso!=null)  
    <div class="postImage" style="min-height:auto;background: url({{$percorso}}) 50% 50% / contain no-repeat, #FFF; width: 100%; padding-top: 65%;"></div>
    @endif
 <a href="#" id="open">
      <div class='contentLike' style="display: flex; padding-bottom: 10px;">
           <div style="text-align: left; width: 50%;"><img src="{{ asset('/systemImages/contaBanane.png') }}" height="25px" border="0" style='float: left; margin-right: 5px;'>
                <div id="contentLikes" style="margin-top: 5px;">
                     <div id="loadLike">
                            <div id="remove-row-addlike">
                                  {{$numeroreazioni}} 
                              </div>
                      </div>
                  </div>
             </div>
        </div>
    </a>
    

    <p>
        <div class="contentLike">
            <div id="like">
                <div id="div-like"></div>
                @if($bool===0)
                    <div id="remove-banana-no">
                    <input id="btn-like" type="image" name="submit" src="{{ asset('/systemImages/banana-no.png') }}" height="25px" border="0" alt="Submit">
                     <input id="hiddenStatoLike" type="hidden" name="stato" value="inserimento_mipiace"/>
                      <input id="hiddenNumeroLike" type="hidden" name="numero_like" value="{{$numeroreazioni}} "/>
                    <input id="hiddenUtenteLike" type="hidden" name="utente" value="{{$utenteID}}"/>
                    <input id="hiddenPostIDLike" type="hidden" name="post" value="{{$id}}"/>
    
                   
                    </div>
                @elseif($bool===1)
                   <div id="remove-banana-si">
                    <input id="btn-dislike" type="image" name="submit" src="{{ asset('/systemImages/banana-si.png') }}" height="25px" border="0" alt="Submit">
                     <input id="hiddenStatoDislike" type="hidden" name="stato" value="cancellazione_mipiace"/>
                      <input id="hiddenNumeroDislike" type="hidden" name="numero_dislike" value="{{$numeroreazioni}} "/>
                    <input id="hiddenUtenteDislike" type="hidden" name="utente" value="{{$utenteID}}"/>
                    <input id="hiddenPostIDDislike" type="hidden" name="post" value="{{$id}}"/>
    
                    
                 </div>
                @endif
            </div>
        </div> 
        <div class="contentComment">
                <div id="comment">
                      <div class="comment"><img src="{{ asset('/systemImages/commento.png') }}" height="25px" border="0" style='cursor: pointer'></div>
                      <div class="contentComment">
                         <div id="commento" class="inputCommento" style="max-height:600px;">
    
                                  @foreach($commenti as $c)
                                  <div id="commento_ID{{$c->commentoID}}" class="styleComment">
                                      
                                      <div class='userComment'>
                                             <div class='userImageComment' style='background: url({{$autori_immagini[$c->commentoID]}}) 50% 50% / contain no-repeat;'>
                                            </div>
                                      </div>
                                       <div class='userNameComment'>
                                          @if($elimina_commenti[$c->commentoID]===1)
                                          <img id="{{$c->commentoID}}" class="commenti" src="{{ asset('/systemImages/cancel-button.svg') }}" height="25px" border="0" style='float:right;margin-right: 5px;'>
                
                                          @endif 
                                          <p><a href="/profilo/id?utenteID={{$autori_ID[$c->commentoID]}}">
                                              <b>
                                              {{$autori_commenti[$c->commentoID]}} 
                                            </b>
                                             </a>
                                            {{$c->contenuto}} <br/>
                                          {{$orari[$c->commentoID]}}
                                           
                                          </p>
                                       
                                         </div>  
                                        
                                      
                                  </div>
                                  @endforeach
                                </div>
                                <div id="insertNewComment">
                                  <div id="remove-row-addcomment" >
                                              <input id="hiddenStato" type="hidden" name="stato" value="inserimento_commento"/>
                                              <input id="hiddenUtente" type="hidden" name="utente" value="{{$utenteID}}"/>
                                              <input id="hiddenPostID" type="hidden" name="post" value="{{$id}}"/>
                                            
                                              <textarea class="commentTextarea"  cols='40' rows='3' spellcheck='false' placeholder='Scrivi un commento..'></textarea>
                                              <button class="submitComment" id="btn-comment">Invia</button>
                                    </div>

                          </div>

                      </div>
                </div>
        </div>
      </p>
        	
      <div id="errors">
          <div id="all-errors"
              @foreach ($errors->all() as $error)

              {{ $error }}

              @endforeach
          </div>
      </div>
    </div>
  </div> <!--chiude content-->
</div> <!--chiude content home left-->
</div>





<div id="finestraDialogo" title="Mi piace" style="overflow:auto">
    @foreach($reazioni as $r)
    <div id="reazione_ID{{$r->reazioneID}}">
      <a href="/profilo/id?utenteID={{$autori_reazioni_ID[$r->reazioneID]}}">
        {{$autori_reazioni[$r->reazioneID]}}
      </a> <br/>
    
    </div>
    @endforeach
</div>
@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">

<script>

$(document).ready(function(){

   $(document).on('click','#btn-comment',function(){
       var stato = $('input#hiddenStato').val();
       var contenuto = $('textarea.commentTextarea').val();
       var utente =$('input#hiddenUtente').val();
       var post =$('input#hiddenPostID').val();
       $.ajax({
           url : "/posts",
           method : "POST",
           data : {stato:stato, contenuto:contenuto, utente:utente, post:post, _token:"{{csrf_token()}}"},
           dataType : "json",
           success : function (result)
           {
              if(result != '') 
              {
                  var data1 = result.data1;
                  var data2 = result.data2;
                  $('#remove-row-addcomment').remove();
                  $('#all-errors').remove();
                  $('#commento').append(data1);
                  $('#insertNewComment').append(data2);
                  $("#commento").scrollTop($("#commento")[0].scrollHeight);   
              }
              else
              {
                alert("Inserimento fallito");   
              }
           },
           error: function (xhr, status, error) {
       $('#all-errors').remove();       
   $('#errors').append('<div id="all-errors"><b style="color:red">Un commento deve contenere minimo tre caratteri</b><br></div>');
                 
            }
       });
   });  

   $('#finestraDialogo').dialog({
        modal:true,
        autoOpen:false,
         maxHeight: 600,
        maxWidth: 500,
   });
   $("a#open").click(function(){
        $('#finestraDialogo').dialog("open");
        return false;
   });

 $(document).on('click','#btn-like',function(){
       var stato = $('input#hiddenStatoLike').val();
       var utente =$('input#hiddenUtenteLike').val();
       var numero_like=$('#hiddenNumeroLike').val();
       var post =$('input#hiddenPostIDLike').val();
       $.ajax({
           url : "/posts",
           method : "POST",
           data : {stato:stato, utente:utente, post:post, numero_like:numero_like, _token:"{{csrf_token()}}"},
           dataType : "json",
           success : function (result)
           {
              if(result != '') 
              {
                    
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data3 = result.data3;
                    var data4 = result.data4; //id reazione aggiunta
                    var data5 = result.data5; //id utente che ha messo mi piace
                  $('#remove-row-addlike').remove();
                  //ho incrementato di 1 i mi piace
                  $('#loadLike').append(data1);


                  $('#remove-banana-no').remove();
                  // mostra mi piace
                    
                  $('#div-like').append(data3);
                  //devo aggiungere alla finestra di dialogo il nome e cognome di chi ha messo mi piace
                  $('#finestraDialogo').append('<div id="reazione_ID'+data4+'"><a href="/profilo/id?utenteID='+data5+'">'+data2+'</a></br/></div>');
              }
              else
              {
                alert("Inserimento fallito");   
              }
           },
           error: function (xhr, status, error) {
              
            }
       });
     });
    $(document).on('click','#btn-dislike',function(){
       var stato = $('input#hiddenStatoDislike').val();
       var utente =$('input#hiddenUtenteDislike').val();
       var numero_like=$('#hiddenNumeroDislike').val();
       var post =$('input#hiddenPostIDDislike').val();
       $.ajax({
           url : "/posts",
           method : "POST",
           data : {stato:stato, utente:utente, post:post, numero_like:numero_like, _token:"{{csrf_token()}}"},
           dataType : "json",
           success : function (result)
           {
              if(result != '') 
              {
                    
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data3 = result.data3;
                  $('#remove-row-addlike').remove();
                  //ho decrementato di 1 i mi piace
                  $('#loadLike').append(data1);

                  $('#remove-banana-si').remove();
                  // mostra non mi piace
                    
                  $('#div-like').append(data3);
                
                  //devo rimuovere dalla finestra di dialogo il nome e cognome di chi ha tolto il mi piace
                  $('#reazione_ID'+data2).remove();
              }
              else
              {
                alert("Inserimento fallito");   
              }
           },
           error: function (xhr, status, error) {
              
            }
       });
   });
    $(document).on('click','#rimuovipost',function(){
       var stato = "rimuovipost";
       var post =<?php echo $id; ?>;
       var utente = <?php echo $utenteID; ?>;
       
       $.ajax({
           url : "/posts",
           method : "POST",
           data : {stato:stato, utente:utente, post:post, _token:"{{csrf_token()}}"},
           dataType : "text",
           success : function (result)
           {
              if(result != '') 
              {
                    
                  
                  $('#visualizzo-post').remove();
                  $('.content').remove();
                  $('#contentHomeLeft').remove();
                  $('.contentHome').append("<h2>Post eliminato correttamente</h2>");

                  //redirect automatico alla home dopo 5 secondi dall'eliminazione del post
                  window.setTimeout(function(){
                    window.location.href="/home";
                  }, 5000);
   
              }
              else
              {
                alert("Rimozione fallita");   
              }
           },
           error: function (xhr, status, error) {
              
            }
       });
   });
   
 $(document).on('click', '.commenti' ,function(){
        var commento=$(this).attr('id'); //commento da rimuovere
        var stato="eliminacommento";
        var post =<?php echo $id; ?>;
        var utente = <?php echo $utenteID; ?>;
       $.ajax({
                 url : "/posts",
                 method : "POST",
                 data : {stato:stato, utente:utente, post:post, commento:commento, _token:"{{csrf_token()}}"},
                 dataType : "text",
                 success : function (result)
                 {
                    if(result != '') 
                    {
                          
                        
                        $('#commento_ID'+commento).remove();
                       
                        
                    }
                    else
                    {
                      alert("Rimozione fallita");   
                    }
                 },
                 error: function (xhr, status, error) {
                    
                  }
       });
  });
}); 
</script>


@endsection