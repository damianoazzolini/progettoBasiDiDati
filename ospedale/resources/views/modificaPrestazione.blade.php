@extends('layouts.sidebar')
@section('content')
<h4> Modifica prestazione </h4>
<h3> Puoi cambiare solo identificativo e note </h3>
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

<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="{{ URL::previous() }}"></i>Chiudi</a>
  </div>
</div>
<br/>

<form method="post" class="col-sm-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group row">
        <label for="identificativoReparto" class="col-sm-2 col-form-label">Reparto</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="identificativoReparto" name="identificativoReparto" value="{{ $reparto }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="identificativoSala" class="col-sm-2 col-form-label">Identificativo sala</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="identificativoSala" name="identificativoSala" value="{{ $sala }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="data" class="col-sm-2 col-form-label">Data della prestazione</label>
        <div class="col-sm-10">
        <input type="date" class="form-control" id="data" name="data" value="{{ $prestazione->data }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="ora" class="col-sm-2 col-form-label">Ora della prestazione</label>
        <div class="col-sm-10">
        <input type="time" class="form-control" id="ora" name="ora" value="{{ $prestazione->ora }}">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="durata" class="col-sm-2 col-form-label">Durata della prestazione</label>
        <div class="col-sm-10">
        <input type="number" class="form-control" id="durata" name="durata" value="{{ $prestazione->durata }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="identificativo" class="col-sm-2 col-form-label">Tipo della prestazione</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="identificativo" name="identificativo" value="{{ $prestazione->identificativo }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="nomePaziente" class="col-sm-2 col-form-label">Nome Paziente</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nomePaziente" name="nomePaziente" value="{{ $paziente[0]->nome }}">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="cognomePaziente" class="col-sm-2 col-form-label">Cognome Paziente</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="cognomePaziente" name="cognomePaziente" value="{{ $paziente[0]->cognome }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="codiceFiscale" class="col-sm-2 col-form-label">Codice Fiscale</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale" value="{{ $paziente[0]->codiceFiscale }}">
        </div>
    </div>

    @foreach($staff as $componenteStaff) 
    <div class="form-group row">
        <label for="nomeStaff" class="col-sm-2 col-form-label">Nome Membro Staff</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nomeStaff" name="nomeStaff" value="{{ $componenteStaff->nome }}">
        </div>
    </div>

    <div class="form-group row">
        <label for="cognomeStaff" class="col-sm-2 col-form-label">Cognome Membro Staff</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="cognomeStaff" name="cognomeStaff" value="{{ $componenteStaff->cognome }}">
        </div>
    </div>
    @endforeach

    <div class="form-group row">
        <label for="note" class="col-sm-2 col-form-label">Note</label>
        <div class="col-sm-10">
        <textarea cols="40" rows="5" class="form-control" id="note" name="note" value="{{ $prestazione->note }}"></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Modifica prestazione</button>

</form> 
<br/>
<br/>

@endsection