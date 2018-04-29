@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio farmaci prestazione</h4>

<div>
    @if (session('status'))
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br/>
    @endif
</div>

<div class="card bg-light">
  <div class="card-header"><p class="h6">Dettaglio</p></div>
  <div class="card-body">
    <p class="card-text"><b>Farmaci: </b>
    </br>
    @foreach($farmaci as $farmaco) 
        {{ $farmaco->nome }}
        <form method="post" action="{{ action('PrestazioneController@deleteFarmacoPrestazione') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
            <input type="hidden" name="nomeFarmaco" value="{{ $farmaco->nome }}">
            
            <input type="submit" class="btn btn-primary" value="Rimuovi" align="right">        
        </form>  
    @endforeach
    
    <p class="card-text"><b>Aggiungi farmaco: </b>
    </br>
    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
        <div class="form-group row">
            <label for="nomeFarmaco" class="col-sm-2 col-form-label">Nome farmaco</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nomeFarmaco" name="nomeFarmaco" placeholder="Nome farmaco">
            </div>
        </div>    
        <button type="submit" class="btn btn-primary">Aggiungi Farmaco</button>
    </form>

    </p>   
  </div>
</div>

@endsection