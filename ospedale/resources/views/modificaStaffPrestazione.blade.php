@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio staff prestazione</h4>

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
    <p class="card-text"><b>Staff: </b>
    </br>
    @foreach($staff as $componenteStaff) 
        {{ $componenteStaff->nome }} {{ $componenteStaff->cognome }} 
        <form method="post" action="{{ action('PrestazioneController@deleteStaffPrestazione') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
            <input type="hidden" name="nomeStaff" value="{{ $componenteStaff->nome }}">
            <input type="hidden" name="cognomeStaff" value="{{ $componenteStaff->cognome }}">
            
            <input type="submit" value="Rimuovi">        
        </form>
    @endforeach
    
    <p class="card-text"><b>Aggiungi Staff: </b>
    </br>
    <form method="post" class="col-sm-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}"
    <div class="form-group row">
        <label for="nomeStaff" class="col-sm-2 col-form-label">Nome componente staff</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nomeStaff" name="nomeStaff" placeholder="Nome">
        </div>
    </div>
    <div class="form-group row">
        <label for="cognomeStaff" class="col-sm-2 col-form-label">Cognome componente staff</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="cognomeStaff" name="cognomeStaff" value="Cognome">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Aggiungi staff</button>
    </form>

    </p>   
  </div>
</div>

@endsection