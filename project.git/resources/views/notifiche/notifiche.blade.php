@extends('layouts.master')

@section('content')
<div class="contentNotifiche">
	<h1 style="height:25px; margin-left: 10px;"> NOTIFICHE<a id="aggiorna-notifiche" href="#"><img src="{{ asset('/systemImages/notifica.png') }}" width="25" height="25" style="margin-left: 10px;"/></a></h1>
	<?php $last_notification_nonletta=0;
			$last_notification_letta=0; ?>
	
		
		<div id="notifiche-nonlette"><h2 id="nessuna-notifica"></h2>
	@if(count($notifiche_nonlette))
	<?php $last_notification_nonletta=$notifiche_nonlette[0]['notifica_ID']; ?>
	<h3 style="margin-left: 10px;"> NOTIFICHE NON LETTE </h3>
	    <ul>
	    @foreach ($notifiche_nonlette as $nn)
	    
	    <div class="userBox">
		    

	    	<div class="userImage">
	    		<div id="cornice" style="width:60px;height:60px; background: url({{$nn['utente_mittente_immagine']}}) 50% 0 / cover no-repeat; "></div>
	    	</div>
		    
		    @if($nn['notifica_tipo']==='commento')
		    <div class="userData">
		    	<a href="/profilo/id?utenteID={{$nn['utente_mittenteID']}}">
         			{{$nn['utente_mittente_nome']}} {{$nn['utente_mittente_cognome']}}
			    </a> ha commentato il tuo post
			    <a href="/posts/{{$nn['post_ID']}}" style="text-decoration:underline;">
				    @if(strlen($nn['post_contenuto'])> 10)
					    <?php
					    	echo"\"";
					    	for($i=0; $i<=10; $i++)
					    	{
					    		echo $nn['post_contenuto'][$i];
					    	}
					    	echo "...\"";
					    ?>
					@else
			  			"{{$nn['post_contenuto']}}"
			   		@endif
				</a>
				 <div class="userDate">
				 	{{$nn['commento_updatedat']}}
				 </div>
			</div>
			@elseif($nn['notifica_tipo']==='reazione')	
		    <div class="userData">
		    	<a href="/profilo/id?utenteID={{$nn['utente_mittenteID']}}">
         		
		    	{{$nn['utente_mittente_nome']}} {{$nn['utente_mittente_cognome']}}
		    	</a> ha aggiunto una reazione al tuo post 
		    	<a href="/posts/{{$nn['post_ID']}}" style="text-decoration:underline;">
			    	@if(strlen($nn['post_contenuto'])> 10)
				    	<?php
				    		echo"\"";
				    		for($i=0; $i<=10; $i++)
				    		{
				    			echo $nn['post_contenuto'][$i];
				    		}
				    		echo "...\"";
				    	?>
				    @else
				    	"{{$nn['post_contenuto']}}"
				    @endif
	   			</a>
	   				<div class="userDate">
				    	{{$nn['reazione_updatedat']}}
				    </div>
			</div>
			@endif
		</div>
		
    	@endforeach
	    </ul>
	    <br/>
	@endif
	</div> <!--chiude notifiche-nonlette-->

	@if(count($notifiche_lette))
	<?php $last_notification_letta=$notifiche_lette[0]['notifica_ID']; ?>
	<h3 style="margin-left: 10px;"> NOTIFICHE LETTE </h3>
	<ul>
	  	<div id="load-data">
	   	@foreach ($notifiche_lette as $nl)
		<div class="userBox">
   			<div class="userImage">
   				<div id="cornice"
   				style="width:60px;height:60px; background: url({{$nl['utente_mittente_immagine']}}) 50% 0 / cover no-repeat; "></div>
   				
   			</div>
	    	@if($nl['notifica_tipo']==='commento')		    		
			<div class="userData">
				<a href="/profilo/id?utenteID={{$nl['utente_mittenteID']}}">
         		
				{{$nl['utente_mittente_nome']}} {{$nl['utente_mittente_cognome']}}</a> ha commentato il tuo post 
	    		<a href="/posts/{{$nl['post_ID']}}" style="text-decoration:underline;">
			    	@if(strlen($nl['post_contenuto'])> 10)
				    	<?php
				    		echo"\"";
				    		for($i=0; $i<=10; $i++)
				    		{
				    			echo $nl['post_contenuto'][$i];
				    		}
				    		echo "...\"";
				    	?>
				    	@else
				    		"{{$nl['post_contenuto']}}"
				    	@endif
				</a>
				<div class="userDate">
					{{$nl['commento_updatedat']}}
				</div>
	  		</div>
		    @elseif($nl['notifica_tipo']==='reazione')	
	   		<div class="userData">
	   			<a href="/profilo/id?utenteID={{$nl['utente_mittenteID']}}">
         		
			   	{{$nl['utente_mittente_nome']}} {{$nl['utente_mittente_cognome']}}</a> ha aggiunto una reazione al tuo post
				<a href="/posts/{{$nl['post_ID']}}" style="text-decoration:underline;">
			    	@if(strlen($nl['post_contenuto'])> 10)
						<?php
				    		echo"\"";
				    		for($i=0; $i<=10; $i++)
				    		{
				    			echo $nl['post_contenuto'][$i];
				    		}
				    		echo "...\"";
				    	?>
				    	@else
				    		"{{$nl['post_contenuto']}}"
				    	@endif
				</a>
			    <div class="userDate">
				 	{{$nl['reazione_updatedat']}}
				</div>
	  		</div>
	   		@endif
	   	</div>
		@endforeach
	    </ul>
	    <br/>
	    <br/>

	

		    <div id="remove-row">
		   		 <button id="btn-more" data-id="{{$nl['notifica_ID']}}"> Carica precedenti </button>
		   	</div>
	    </div> <!--chiude load data-->

	    
</div> <!-- chiude contentNotifiche-->

@endif
@endsection

@section('scripts')

<script>
$(document).ready(function(){
	

	var ultimanotifica;
	var numero=<?php echo count($notifiche_nonlette);?>;
	
	if(numero>0)
	{
		ultimanotifica=<?php echo $last_notification_nonletta; ?>;
	}
	else
	{
		ultimanotifica=<?php echo $last_notification_letta; ?>;
	}
$(document).on('click','#aggiorna-notifiche',function(){
	
		 $("#nessuna-notifica").remove();
       
		var stato="aggiornamento";
		$.ajax({
           url : "/notifiche",
           method : "POST",
           data : {ultimanotifica:ultimanotifica, stato:stato, _token:"{{csrf_token()}}"},
           dataType : "json",
           success : function (result)
           {
              if(result != '') 
              {
                    var data1 = result.data1;
                    var data2 = result.data2;
                  $('#notifiche-nonlette').prepend(data1);
                  ultimanotifica=data2;
              }
              
           },
           error: function(){
           	$('#notifiche-nonlette').prepend('<h3 id="nessuna-notifica">Nessuna nuova notifica</h3>');
           }
       });

	});
	//setInterval(nuovenotifiche, 1000); //notifiche aggiornate ogni secondo -> tolto. Meglio su richiesta dell'utente con un click
	
   $(document).on('click','#btn-more',function(){
       var id = $(this).data('id');
       $("#btn-more").html("Caricamento....");
       $.ajax({
           url : "/notifiche",
           method : "POST",
           data : {id:id, _token:"{{csrf_token()}}"},
           dataType : "text",
           success : function (data)
           {
              if(data != '') 
              {
                  $('#remove-row').remove();
                  $('#load-data').append(data);
              }
              else
              {
                  $('#btn-more').html("Nessuna Notifica");
              }
           }
       });
   });  
}); 
</script>


@endsection

