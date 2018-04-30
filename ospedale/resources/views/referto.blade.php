@extends('layouts.sidebar')
@section('content')
<h4> Referto </h4>
<h6> Emetti Referto per la seguente prestazione </h6>
<br/>

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
  <div class="card-header"><p class="h6">Dati prestazione</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Nome Paziente: </b>{{ $paziente->nome }}</p>
    <p class="card-text"><b>Cognome Paziente: </b>{{ $paziente->cognome }}</p>
    <p class="card-text"><b>Codice Fiscale: </b>{{ $paziente->codiceFiscale }}</p>
    <p class="card-text"><b>Data: </b>{{ $prestazione->data }}</p>
    <p class="card-text"><b>Ora: </b>{{ $prestazione->ora }}</p>
    <p class="card-text"><b>Durata: </b>{{ $prestazione->durata }} minuti</p>
    <p class="card-text"><b>Reparto: </b>{{ $reparto }}</p>
    <p class="card-text"><b>Sala: </b>{{ $sala }}</p>
    <p class="card-text"><b>Identificativo: </b>{{ $prestazione->identificativo }}</p>
    <p class="card-text"><b>Note: </b>{{ $prestazione->note }}</p>
    <p class="card-text"><b>Attiva:</b> 
    @if($prestazione->attivo == 1)
    <i class="fas fa-check" style="color:green"></i>
    @else
    <i class="fas fa-times" style="color:red"></i>
    @endif
    </p>
    <p class="card-text"><b>Effettuata:</b> 
    @if($prestazione->effettuata == 1)
    <i class="fas fa-check" style="color:green"></i>
    @else
    <i class="fas fa-times" style="color:red"></i>
    @endif
    </p>

    <p class="card-text"><b>Staff: </b> </br>
    @foreach($staff as $componenteStaff) 
        {{ $componenteStaff->nome }} {{ $componenteStaff->cognome }} </br>       
    @endforeach
    
    </p>
    <p class="card-text"><b>Farmaci: </b> </br>

    @foreach($farmaci as $farmaco) 
        {{ $farmaco->nome }} </br>  
    @endforeach
    </p>   
  </div>
</div>
</br>
<form method="post" class="col-sm-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="idPrestazione" value="{{ $prestazione->id }}">
    <div class="form-group row">
        <label for="esito" class="col-sm-2 col-form-label">Esito Referto</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="esito" name="esito" placeholder="Esito">
        </div>
    </div>
    <div class="form-group row">
        <label for="note" class="col-sm-2 col-form-label">Note</label>
        <div class="col-sm-10">
        <textarea cols="40" rows="5" class="form-control" id="note" name="note" placeholder="Note"></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Emetti referto</button>

</form> 
<br/>
<br/>

@endsection