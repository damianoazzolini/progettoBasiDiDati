@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio staff: </h4><h3><b>{{$ruoloStaff}}</b> {{ $datiUtente->nome }} {{ $datiUtente->cognome }}</h3>
<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="{{ URL::previous() }}"></i>Chiudi</a>
    @if($ruolo == "Amministratore" || $ruolo == "Impiegato")
      <a type="button" class="btn btn-warning float-sm-right" style="margin-left: 5px; color:white" href="/modificaStaff/{{ $datiUtente->id}}"><i class="fas fa-edit"></i> Modifica</a>
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
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati Incarico</p></div>
  <div class="card-body">
    <p class="card-text"><b>Ruolo: </b>{{$ruoloStaff}}</p>
    <p class="card-text"><b>Identificativo: </b>{{ $datiStaff->identificativo }}</p>
    <p class="card-text"><b>Stipendio: </b>{{ $datiStaff->stipendio }}</p>
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati reparto</p></div>
  <div class="card-body">
    <p class="card-text"><b>Nome: </b>{{ $reparto->nome }} </p>
    <p class="card-text"><b>Descrizione: </b>{{ $reparto->descrizione }} </p>
    <p class="card-text"><b>Identificativo: </b>{{ $reparto->identificativo }}</p>
  </div>
</div>
<br/>


<!-- Modal di conferma cancellazione-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confermi l'operazione ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Stai cancellando il paziente dal database.</p>
            <p><b>L'operazione è irreversibile.</b> Vuoi continuare ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a type="button" class="btn btn-danger" href="/cancellaPaziente/{{ $datiUtente->id}}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
</div>

<!-- Sezione da aggiornare -->
<br/>

@endsection