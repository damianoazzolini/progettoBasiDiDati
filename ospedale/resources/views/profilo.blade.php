@extends('layouts.sidebar')
@section('content')

@if (session('status'))
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <br/>
@endif

<h4>Dettaglio utente: </h4><h3>{{ $datiUtente->nome }} {{ $datiUtente->cognome }}</h3>
<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="/dashboard"></i>Chiudi</a>
    @if($ruolo == "Paziente" || $ruolo == "Amministratore")
    <a type="button" class="btn btn-warning float-sm-right" style="margin-left: 5px; color:white" href="/modificaProfilo/{{ $datiUtente->id}}"><i class="fas fa-edit"></i> Modifica</a>
    @endif
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati Anagrafici</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Sesso: </b><?php if($datiUtente->sesso == '1') echo 'Uomo'; else echo 'Donna';?></p>
    <p class="card-text"><b>Data di Nascita: </b>{{ $datiUtente->dataNascita }}</p>
    <p class="card-text"><b>Codice Fiscale: </b>{{ $datiUtente->codiceFiscale }}</p>
    <p class="card-text"><b>Residenza Via: </b>{{ $datiUtente->via }} <b>Civico: </b>{{ $datiUtente->numeroCivico }}</p>
    <p class="card-text"><b>Città: </b>{{ $datiUtente->comune }} <b>Provincia: </b>{{ $datiUtente->provincia }} <b>Stato: </b>{{ $datiUtente->stato }}</p>
    <p class="card-text"><b>Email: </b>{{ $datiUtente->email }}</p>
    <p class="card-text"><b>Telefono: </b>{{ $datiUtente->telefono }}</p>
  </div>
</div>

@endsection