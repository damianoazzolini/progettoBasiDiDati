@extends('layouts.sidebar')
@section('content')
<h4> Aggiunta nuova prestazione </h4>
<br/>
<form method="post" class="col-sm-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group row">
        <label for="reparto" class="col-sm-2 col-form-label">Reparto</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="reparto" name="reparto" placeholder="Nome Reparto">
        </div>
    </div>
    <div class="form-group row">
        <label for="sala" class="col-sm-2 col-form-label">Sala</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="sala" name="sala" placeholder="Sala">
        </div>
    </div>
    <div class="form-group row">
        <label for="data" class="col-sm-2 col-form-label">Data della prestazione</label>
        <div class="col-sm-10">
        <input type="date" class="form-control" id="data" name="data">
        </div>
    </div>
    <div class="form-group row">
        <label for="ora" class="col-sm-2 col-form-label">Ora della prestazione</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="ora" name="ora" placeholder="Ora">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="nomePaziente" class="col-sm-2 col-form-label">Nome Paziente</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nomePaziente" name="nomePaziente" placeholder="Nome Paziente">
        </div>
    </div>
    
    <div class="form-group row">
        <label for="cognomePaziente" class="col-sm-2 col-form-label">CognomePaziente</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="cognomePaziente" name="cognomePaziente" placeholder="CognomePaziente">
        </div>
    </div>

    <div class="form-group row">
        <label for="codiceFiscale" class="col-sm-2 col-form-label">Codice Fiscale</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale" placeholder="C.F.">
        </div>
    </div>

    <div class="form-group row">
        <label for="nomeStaff" class="col-sm-2 col-form-label">Nome Staff</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nomeStaff" name="nomeStaff" placeholder="Nome Staff">
        </div>
    </div>

    <div class="form-group row">
        <label for="note" class="col-sm-2 col-form-label">Note</label>
        <div class="col-sm-10">
        <textarea cols="40" rows="5" class="form-control" id="note" name="note" placeholder="Nessuna nota"></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Crea una nuova prestazione</button>

</form> 
<br/>
<br/>

<script charset="utf-8" type="text/javascript" src="{{asset('/js/registration.js')}}"></script>

@endsection

