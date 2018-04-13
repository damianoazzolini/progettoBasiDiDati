@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio sala: </h4><h3>{{ $sala->nomeSala }}</h3>
<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="/sale"></i>Chiudi</a>
    <a type="button" class="btn btn-warning float-sm-right" style="margin-left: 5px; color:white" href="/modificaSala/{{ $sala->id}}"><i class="fas fa-edit"></i> Modifica</a>
    <a type="button" class="btn btn-danger float-sm-right" style="margin-left: 5px; color:white" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i> Cancella</a>
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati sala</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Nome: </b>{{ $sala->nomeSala }}</p>
    <p class="card-text"><b>Piano: </b>{{ $sala->piano }}</p>
    <p class="card-text"><b>Descrizione: </b>{{ $sala->descrizioneSala }}</p>
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati reparto di appartenenza</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Nome: </b>{{ $sala->nomeReparto}}</p>
    <p class="card-text"><b>Identificativo Reparto: </b>{{ $sala->identificativoReparto }}</p>
    <p class="card-text"><b>Descrizione: </b>{{ $sala->descrizioneReparto }}</p>
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
            <p>Stai cancellando la sala dal database.</p>
            <p><b>L'operazione è irreversibile.</b> Vuoi continuare ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a type="button" class="btn btn-danger" href="/cancellaSala/{{ $sala->id}}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
</div>

@endsection