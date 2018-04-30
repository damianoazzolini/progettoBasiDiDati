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
    @if(($ruolo == "Medico" || $ruolo == "Amministratore") and $autorizzatoModificaPrestazione and !$prestazione->effettuata)
        <a type="button" class="btn btn-warning float-sm-right" style="margin-left: 5px; color:white" href="/modificaPrestazione/{{ $prestazione->id }}"><i class="fas fa-edit"></i> Modifica</a>
    @endif
    @if($ruolo == "Amministratore" || $ruolo == "Impiegato")
        <a type="button" class="btn btn-danger float-sm-right" style="margin-left: 5px; color:white" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash-alt"></i> Cancella</a>
    @endif
  </div>
</div>
</br>

<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati paziente</p></div>
  <div class="card-body">
    <p class="card-text"><b>Nome Paziente: </b>{{ $paziente[0]->nome }}</p>
    <p class="card-text"><b>Cognome Paziente: </b>{{ $paziente[0]->cognome }}</p>
    <p class="card-text"><b>Codice Fiscale: </b>{{ $paziente[0]->codiceFiscale }}</p>
  </div>
</div>
</br>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati prestazione</p></div>
  <div class="card-body">
  <p class="card-text"><b>Data: </b>{{ $prestazione->data }}</p>
    <p class="card-text"><b>Ora: </b>{{ $prestazione->ora }}</p>
    <p class="card-text"><b>Durata: </b>{{ $prestazione->durata }} minuti</p>
    <p class="card-text"><b>Reparto: </b>{{ $reparto }}</p>
    <p class="card-text"><b>Sala: </b>{{ $sala }}</p>
    <p class="card-text"><b>Tipologia di prestazione: </b>{{ $prestazione->identificativo }}</p>
    <p class="card-text"><b>Note: </b>{{ $prestazione->note }}</p>
  </div>
</div>
</br>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Attiva: 
    @if($prestazione->attivo == 1)
    <i class="fas fa-check" style="color:green"></i>
    @else
    <i class="fas fa-times" style="color:red"></i>
    @endif
    </p></div>
</div>
</br>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Effettuata: 
    @if($prestazione->effettuata == 1)
    <i class="fas fa-check" style="color:green"></i>
    @else
    <i class="fas fa-times" style="color:red"></i>
    @endif
    </p></div>
</div>
</br>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Staff</p>
    @if(($ruolo == "Medico" || $ruolo == "Amministratore") and $autorizzatoModificaPrestazione and !$prestazione->effettuata)
        <a class="btn btn-default btn-sm" href="/modificaStaffPrestazione/{{ $prestazione->id }}"> <i class="fa fa-cog"></i> Modifica</a>  
    @endif
  </div>
  <div class="card-body">
    
    <table class="table">
      <thead>
      <th scope="col"> Nome </th>
      <th scope="col"> Cognome </th>
      </thead>

      <tbody>
      @foreach($staff as $componenteStaff) 
          <tr>
            <td> {{ $componenteStaff->nome }}<a/> </td>
            <td> {{ $componenteStaff->cognome }} <a/> </td>
          </tr> 
      @endforeach
      </tbody>
    </table>
  </div>
</div>
</br>
<div class="card bg-light">
  <div class="card-header"><p class="h6">Farmaci</p>
    @if(($ruolo == "Medico" || $ruolo == "Infermiere" || $ruolo == "Amministratore") and $autorizzatoModficaFarmaci and !$prestazione->effettuata)
        <a class="btn btn-default btn-sm" href="/modificaFarmacoPrestazione/{{ $prestazione->id }}"> <i class="fa fa-cog"></i> Modifica</a>
    @endif
  </div>
  <div class="card-body">
    
    <table class="table">
      <thead>
      <th scope="col"> Nome </th>
      </thead>

      <tbody>
      @foreach($farmaci as $farmaco) 
          <tr>
            <td> {{ $farmaco->nome }}<a/> </td>
          </tr> 
      @endforeach
      </tbody>
    </table>
  </div>
</div>
</br>
@if($ruolo != "Impiegato")
<div class="card bg-light">
  <div class="card-header"><p class="h6">Referto</p></div>
  <div class="card-body">
    <p class="card-text"><b>Esito: </b>{{ $referto->esito }}</p>
    <p class="card-text"><b>Note referto: </b>{{ $referto->note }}</p>
  </div>
</div>
@endif
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
            <a type="button" class="btn btn-danger" href="/cancellaPrestazione/{{ $prestazione->id }}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
</div>
</br>
</br>
@endsection