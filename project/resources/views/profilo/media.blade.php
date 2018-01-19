
@extends('layouts.master')

@section ('scripts')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
<link type="text/css" rel="stylesheet" href="{{asset('/css/profilo.css')}}">

<script>
$(document).ready(function(){
	$(document).on('click','#postButton', function() {
       var text = $("#postTextarea").val();
       if(document.getElementById("imageSubmit").files.length != 0) {
           $("#formPost").submit();
       }
    });
});
</script>
@endsection


@section ('content')

<div class="container profile">
	<div class="row">
		<div class="col profileName">
			{{$utente->nome}} {{$utente->cognome}}
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="row">
				<div class="col">
				<img src="<?php echo $utente->immagine?>" id="profileImage">
				</div>
				</div>
				<div class="row">
				<div class="col">
					@if($boolean_immagine==1)
					<form action="../storeImage" method="POST" enctype="multipart/form-data" id="formPost">
							{{ csrf_field() }}
							<input id='imageSubmit' type="file" name="image">
							<input type="hidden" name="control" value="1"> 
							<button type="button" id="postButton" style="width:100px;"><b>Aggiorna</b></button>
							<ul>
							@foreach ($errors->all() as $error)
								<li>
									{{ $error }}
								</li>
							@endforeach
							</ul>
						</form>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col profileInfo">
					<div class="row">
						<div class="col">
							{{ $data[2] or '' }}/{{$data[1] or ''}}/{{ $data[0] or ''}}
						</div>
					</div>
					<div class="row">
						<div class="col">
							{{$sesso}}
						</div>
					</div>
					<div class="row">
						<div class="col">
							<a href="/profilo/media/id?utenteID=<?php echo $utente->utenteID?>">
								Foto
							</a>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="col profilePosts">
				<div class="row">
	
				<?php foreach ($media as $m){ ?>
						<div class="col">
						<div class="postImage" style="background: url(<?php echo $m->percorso ?>) 50% 50% / contain no-repeat, #FFF; width: 100%; padding-top: 65%;"></div>
						</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
