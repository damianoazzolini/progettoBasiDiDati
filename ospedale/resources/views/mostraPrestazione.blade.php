@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio farmaco: </h4><h3>{{ $farmaco->nome }}</h3>
<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="{{ URL::previous() }}"></i>Chiudi</a>
    <a type="button" class="btn btn-warning float-sm-right" style="margin-left: 5px; color:white" href="/modificaPrestazione/{{ $prestazione->id }}"><i class="fas fa-edit"></i> Modifica</a>
    <a type="button" class="btn btn-danger float-sm-right" style="margin-left: 5px; color:white" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i> Cancella</a>
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati prestazione</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Nome Paziente: </b>{{ $paziente->nome }}</p>
    <p class="card-text"><b>Cognome Paziente: </b>{{ $paziente->cognome }}</p>
    <p class="card-text"><b>Reparto: </b>{{ $reparto->nome }}</p>
    <p class="card-text"><b>Sala: </b>{{ $sala->identificativo }}</p>
    <p class="card-text"><b>Identificativo: </b>{{ $prestazione->identificativo }}</p>
    <p class="card-text"><b>Note: </b>{{ $prestazione->note }}</p>
    <p class="card-text"><b>Attiva: </b>{{ $prestazione->attivo }}</p>
    <p class="card-text"><b>Effettuata: </b>{{ $prestazione->effettuata }}</p>
    <p class="card-text"><b>Staff: </b></br>
    @foreach($staff as $componenteStaff) 
        {{ $componenteStaff->nome }} {{ $componenteStaff->cognome }}
    @endforeach
    </p>
    <p class="card-text"><b>Farmaci: </b></br>
    @foreach($farmaci as $farmaco) 
        {{ $farmaco->nome }}
    @endforeach
    </p>   
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
            <p>Stai cancellando la prestazione.</p>
            <p><b>L'operazione è irreversibile.</b> Vuoi continuare ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a type="button" class="btn btn-danger" href="/eliminaPrestazione/{{ $prestazione->id }}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
</div>

@endsection