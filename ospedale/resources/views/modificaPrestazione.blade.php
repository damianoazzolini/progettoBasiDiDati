@extends('layouts.sidebar')
@section('content')
<h4> Modifica prestazione </h4>

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

<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="{{ URL::previous() }}"></i>Chiudi</a>
  </div>
</div>
<br/>

<div class="card bg-light">
    <div class="card-header">
        <p class="h6">Modifica Prestazione</p>
    </div>

    <div class="card-body">
        <div class="col-sm-10">
            <p class="card-text"><b>Reparto: </b> {{ $reparto }} </p>
            <p class="card-text"><b>Sala: </b> {{ $sala }} </p>
            <p class="card-text"><b>Data: </b>{{ $prestazione->data }}</p>
            <p class="card-text"><b>Ora: </b>{{ $prestazione->ora }}</p>
            <p class="card-text"><b>Durata: </b>{{ $prestazione->durata }}</p>
            <p class="card-text"><b>Nome Paziente: </b>{{ $paziente[0]->nome }}</p>
            <p class="card-text"><b>Cognome Paziente: </b>{{ $paziente[0]->cognome }}</p>
            <p class="card-text"><b>Codice Fiscale: </b>{{ $paziente[0]->codiceFiscale }}</p>
            @foreach($staff as $componenteStaff) 
                <p class="card-text"><b>Nome Staff: </b>{{ $componenteStaff->nome }}</p>
                <p class="card-text"><b>Cognome Staff: </b>{{ $componenteStaff->cognome }}</p> 
            @endforeach
        </div>
    </div>
</div>

</br>

<div class="card bg-light">    
    <div class="card-header">
        <p class="h6">Campi Modificabili</p>
    </div>

    <div class="card-body">
        <form method="post" class="col-sm-20">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group row col-sm-10"> 
                <label for="identificativo" class="col-sm-6 col-form-label">Tipologia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="identificativo" name="identificativo" value="{{ $prestazione->identificativo }}">
                </div>
            </div>

            <div class="form-group row col-sm-10"> 
                <label for="note" class="col-sm-6 col-form-label">Note</label>
                <div class="col-sm-10">
                    <textarea cols="40" rows="5" class="form-control" id="note" name="note" placeholder="{{ $prestazione->note }}"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Modifica prestazione</button>
        </form> 
    </div>
    
</div>
<br/>
<br/>

@endsection