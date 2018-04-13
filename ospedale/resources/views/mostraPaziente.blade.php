@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio paziente: </h4><h3>{{ $datiPaziente->nome }} {{ $datiPaziente->cognome }}</h3>
<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="{{ URL::previous() }}"></i>Chiudi</a>
    <a type="button" class="btn btn-warning float-sm-right" style="margin-left: 5px; color:white" href="/modificaPaziente/{{ $datiPaziente->id}}"><i class="fas fa-edit"></i> Modifica</a>
    <a type="button" class="btn btn-danger float-sm-right" style="margin-left: 5px; color:white" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i> Cancella</a>
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati Anagrafici</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Sesso: </b><?php if($datiPaziente->sesso == '1') echo 'Uomo'; else echo 'Donna';?></p>
    <p class="card-text"><b>Data di Nascita: </b>{{ $datiPaziente->dataNascita }}</p>
    <p class="card-text"><b>Codice Fiscale: </b>{{ $datiPaziente->codiceFiscale }}</p>
    <p class="card-text"><b>Residenza Via: </b>{{ $datiPaziente->via }} <b>Civico: </b>{{ $datiPaziente->numeroCivico }}</p>
    <p class="card-text"><b>Città: </b>{{ $datiPaziente->comune }} <b>Provincia: </b>{{ $datiPaziente->provincia }} <b>Stato: </b>{{ $datiPaziente->stato }}</p>
    <p class="card-text"><b>Email: </b>{{ $datiPaziente->email }}</p>
    <p class="card-text"><b>Telefono: </b>{{ $datiPaziente->telefono }}</p>
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati Clinici</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Peso: </b>{{ $datiPaziente->peso }} Kg</p>
    <p class="card-text"><b>Altezza: </b>{{ $datiPaziente->altezza }} cm</p>
    <p class="card-text"><b>Note mediche: </b>{{ $datiPaziente->note }}</p>
  </div>
</div>

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
            <a type="button" class="btn btn-danger" href="/cancellaPaziente/{{ $datiPaziente->id}}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
</div>

<!-- Sezione da aggiornare -->
<br/>
<p>--- Inserire farmaci assunti</p>
<p>--- Inserire prestazioni prenotate</p>
<p>--- Inserire prestazioni eseguite</p>
@endsection