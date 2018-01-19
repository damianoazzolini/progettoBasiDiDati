@extends('layouts.master')

@section('content')
    <div class="contentNotifiche">
   
  @if(count($array_richieste_amicizia_ricevute_nonlette)==0 and count($array_richieste_amicizia_inviate_accettate_nonlette)==0 and count($array_richieste_amicizia_ricevute_lette)==0 and count($array_richieste_amicizia_inviate_insospeso)==0 and count($suggeriti[0])==0)

   <h2> NESSUNA AMICIZIA IN SOSPESO </h2>
   @endif 


    	@if(count($array_richieste_amicizia_ricevute_nonlette))
	   <h2> NUOVE RICHIESTE DI AMICIZIA </h2>
	    <br/>
	    <ul>
	    	
	    	@foreach ($array_richieste_amicizia_ricevute_nonlette as $nr)
	    		<div id="div-boxutente{{$nr->utenteID}}">
	    			<div id="div-remove-boxutente{{$nr->utenteID}}">
	    		<div class="userBox">
	    			<div class="userImage">
	    				<div id="cornice" style="width:60px;height:60px; background: url({{$nr->immagine}}) 50% 0 / cover no-repeat; "></div>
	    				
	    			</div>
		    		<div class="userName">
		    			<a href="/profilo/id?utenteID={{$nr->utenteID}}">
		    			{{$nr->nome}} {{$nr->cognome}}
		    			</a>
		    		</div>
	   				
				    	<input id="tipo{{$nr->utenteID}}" type="hidden" name="tipo" value="ricevuta"/>
						<input id="{{$nr->utenteID}}" type="button" name="stato" value="Conferma" class="bottone"/>
						<input id="{{$nr->utenteID}}" type="button" name="stato" value="Elimina richiesta" class="bottone"/>
						<input id="{{$nr->utenteID}}" type="button" name="stato" value="Blocca" class="bottone"/>
	    			
				</div>
			</div>
			</div>
	    	@endforeach
	    </ul>
	    <br/>
	    @endif

		@if(count($array_richieste_amicizia_inviate_accettate_nonlette))
		<h2>RICHIESTE DI AMICIZIA ACCETTATE</h2>
	    <br/>
	    <ul>
			@foreach ($array_richieste_amicizia_inviate_accettate_nonlette as $ar)
			    <div class="userBox">
			    	<div class="userImage">
			    		<div id="cornice" style="width:60px;height:60px; background: url({{$ar->immagine}}) 50% 0 / cover no-repeat; "></div>
	    				
	    			</div>
			    	<div class="userName">
			    		<a href="/profilo/id?utenteID={{$ar->utenteID}}">
		    			
			    		{{$ar->nome}} {{$ar->cognome}}</a> ha accettato la tua richiesta di amicizia
			    	</div>
				</div>
			@endforeach
		</ul>
	    <br/>
	    @endif

		@if(count($array_richieste_amicizia_ricevute_lette))
		<h2>	RICHIESTE DI AMICIZIA RICEVUTE IN SOSPESO </h2>
		<br/>
		<ul>
			
		    @foreach ($array_richieste_amicizia_ricevute_lette as $or) 
		    <div id="div-boxutente{{$or->utenteID}}">
	    			<div id="div-remove-boxutente{{$or->utenteID}}">
				<div class="userBox">
					<div class="userImage">
						<div id="cornice" style="width:60px;height:60px; background: url({{$or->immagine}}) 50% 0 / cover no-repeat; "></div>
	    				
	    			</div>
	    			<div class="userName">
	    				<a href="/profilo/id?utenteID={{$or->utenteID}}">
		    			
					{{$or->nome}} {{$or->cognome}} 
				</a>
					</div>
					
	   					
						<input id="tipo{{$or->utenteID}}" type="hidden" name="tipo" value="ricevuta"/>
						<input id="{{$or->utenteID}}" type="button" name="stato" value="Conferma" class="bottone">
						<input id="{{$or->utenteID}}" type="button" name="stato" value="Elimina richiesta" class="bottone"/>
						<input id="{{$or->utenteID}}" type="button" name="stato" value="Blocca" class="bottone"/>
		    		
				</div>
			</div>
				</div>
			@endforeach
		</ul>
		<br/>
		@endif


		@if(count($array_richieste_amicizia_inviate_insospeso))
		<h2>	RICHIESTE DI AMICIZIA INVIATE </h2>
	 	<br/>
	 	<ul>
	 		
	 		@foreach ($array_richieste_amicizia_inviate_insospeso as $nar)
	 		<div id="div-boxutente{{$nar->utenteID}}">
	    			<div id="div-remove-boxutente{{$nar->utenteID}}">
		    	<div class="userBox">
		    		<div class="userImage">
		    			<div id="cornice" style="width:60px;height:60px; background: url({{$nar->immagine}}) 50% 0 / cover no-repeat; "></div>
	    				
	    				
	    			</div>
	    			<div class="userName">
	    				<a href="/profilo/id?utenteID={{$nar->utenteID}}">
		    			
		   			{{$nar->nome}} {{$nar->cognome}}
		   		</a>
		   		</div>
					
						<input id="tipo{{$nar->utenteID}}" type="hidden" name="tipo"  value="inviata"/>
						<input id="{{$nar->utenteID}}" type="button" name="stato" value="Annulla richiesta" class="bottone"/>
	   				
				</div>
			</div>
				</div>
			@endforeach
	 	</ul>
	 	<br/>
		<br/>
		<br/>
	
	 	@endif

	 	@if(count($suggeriti[0]))	
	 	<h2>	PERSONE CHE POTRESTI CONOSCERE </h2>
	 	<br/>
	 	<ul>
	 		@foreach($suggeriti as $s)	
	 			@if(!empty($s[0]->utenteID))
                            @if($s[0]->utenteID > 0)
						    	<div class="userBox">
						    		<div class="userImage">
						    			<div id="cornice" style="width:60px;height:60px; background: url({{$s[0]->immagine}}) 50% 0 / cover no-repeat; "></div>
					    					
					    			</div>
					    			<div class="userName">
					    				<a href="/profilo/id?utenteID={{$s[0]->utenteID}}">
						    					{{$s[0]->nome}} {{$s[0]->cognome}}
						   				</a>
						   			</div>	
								</div>
							@endif
				@endif
			@endforeach
	 	</ul>
	 	<br/>
		<br/>
		<br/>
	
	 	@endif
	 </div>
   @endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">

<script>

$(document).ready(function(){
 $(document).on('click', '.bottone' ,function(){

 	var utenteID=$(this).attr('id');
 	var stato=$(this).val();
   var tipo=$('#tipo'+utenteID).val();
  		//alert(utenteID+' ' +tipo+ ' ' +stato);

  		 $.ajax({
           url : "/richieste_amicizia",
           method : "POST",
           data : {stato:stato, tipo:tipo, utenteID:utenteID,_token:"{{csrf_token()}}"},
           dataType : "text",
           success : function (data)
           {
              if(data != '') 
              {

                  $('#div-remove-boxutente'+utenteID).remove();
                  
                  $('#div-boxutente'+utenteID).append(data);
                   
              }
              else
              {
                alert("fallito");   
              }
           },
           error: function (xhr, status, error) {
     
            }
       });
   });  
});
</script>
   @endsection
							