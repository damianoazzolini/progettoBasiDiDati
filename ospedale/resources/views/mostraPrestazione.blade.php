@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio prestazione</h4>

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
    @if(($ruolo == "Medico" || $ruolo == "Amministratore") and $$autorizzatoModificaPrestazione)
        <a type="button" class="btn btn-warning float-sm-right" style="margin-left: 5px; color:white" href="/modificaPrestazione/{{ $prestazione->id }}"><i class="fas fa-edit"></i> Modifica</a>
        <a type="button" class="btn btn-danger float-sm-right" style="margin-left: 5px; color:white" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i> Cancella</a>
    @endif
  </div>
</div>
<br/>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati prestazione</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Nome Paziente: </b>{{ $paziente[0]->nome }}</p>
    <p class="card-text"><b>Cognome Paziente: </b>{{ $paziente[0]->cognome }}</p>
    <p class="card-text"><b>Codice Fiscale: </b>{{ $paziente[0]->codiceFiscale }}</p>
    <p class="card-text"><b>Data: </b>{{ $prestazione->data }}</p>
    <p class="card-text"><b>Ora: </b>{{ $prestazione->ora }}</p>
    <p class="card-text"><b>Durata: </b>{{ $prestazione->durata }} minuti</p>
    <p class="card-text"><b>Reparto: </b>{{ $reparto }}</p>
    <p class="card-text"><b>Sala: </b>{{ $sala }}</p>
    <p class="card-text"><b>Identificativo: </b>{{ $prestazione->identificativo }}</p>
    <p class="card-text"><b>Note: </b>{{ $prestazione->note }}</p>
    <p class="card-text"><b>Attiva: </b>{{ $prestazione->attivo }}</p>
    <p class="card-text"><b>Effettuata: </b>{{ $prestazione->effettuata }}</p>
    
    <p class="card-text"><b>Staff: </b>
    @if(($ruolo == "Medico" || $ruolo == "Amministratore") and $$autorizzatoModificaPrestazione)
        <a type="button" class="btn btn-primary" href="/modificaStaffPrestazione/{{ $prestazione->id }}"><i class="fas fa-folder-open" style="color:black"></i></a>
    @endif
    </br>
    @foreach($staff as $componenteStaff) 
        {{ $componenteStaff->nome }} {{ $componenteStaff->cognome }} </br>       
    @endforeach
    
    </p>
    <p class="card-text"><b>Farmaci: </b>
    @if(($ruolo == "Medico" || $ruolo == "Infermiere" || $ruolo == "Amministratore") and $autorizzatoModficaFarmaci)
        <a type="button" class="btn btn-primary" href="/modificaFarmacoPrestazione/{{ $prestazione->id }}"><i class="fas fa-folder-open" style="color:black"></i></a>
    @endif
    </br>
    @foreach($farmaci as $farmaco) 
        {{ $farmaco->nome }} </br>  
    @endforeach
    </br>
    <p class="card-text"><b>Esito: </b>{{ $referto->esito }}</p>
    <p class="card-text"><b>Note referto: </b>{{ $referto->note }}</p>
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