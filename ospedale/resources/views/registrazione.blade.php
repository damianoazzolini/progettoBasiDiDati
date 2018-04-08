@extends('layouts.sidebar')
@section('content')
<h4> Registrazione nuovo utente </h4>
<br/>
<form method="post" class="col-sm-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nome" name="nome" value="Nome">
        </div>
    </div>
    <div class="form-group row">
        <label for="cognome" class="col-sm-2 col-form-label">Cognome</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="cognome" name="cognome" value="Cognome">
        </div>
    </div>
    <div class="form-group row">
        <label for="dataNascita" class="col-sm-2 col-form-label">Data di nascita</label>
        <div class="col-sm-10">
        <input type="date" class="form-control" id="dataNascita" name="dataNascita">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Sesso</label>
        <div class="col-sm-10">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio1" name="sesso" value="uomo" checked >
                <label class="form-check-label" for="inlineRadio1">Maschio</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="inlineRadio2" name="sesso" value="donna">
                <label class="form-check-label" for="inlineRadio2">Femmina</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="codiceFiscale" class="col-sm-2 col-form-label">Codice Fiscale</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale" value="C.F.">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
        <input type="email" class="form-control" id="email" name="email">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
        <input type="password" class="form-control" id="password" name="password" value="password">
        </div>
    </div>
    <div class="form-group row">
        <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="telefono" name="telefono" value="Telefono">
        </div>
    </div>
    <div class="form-group row">
        <label for="via" class="col-sm-2 col-form-label">Via</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="via" name="via" value="Via">
        </div>
    </div>
    <div class="form-group row">
        <label for="civico" class="col-sm-2 col-form-label">Civico</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="civico" name="civico" value="Civico">
        </div>
    </div>
    <div class="form-group row">
        <label for="comune" class="col-sm-2 col-form-label">Comune</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="comune" name="comune" value="Comune">
        </div>
    </div>
    <div class="form-group row">
        <label for="provincia" class="col-sm-2 col-form-label">Provincia</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="provincia" name="provincia" value="Provincia">
        </div>
    </div>
    <div class="form-group row">
        <label for="stato" class="col-sm-2 col-form-label">Stato</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="stato" name="stato" value="Stato">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Ruolo</label>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" type="radio" id="ruolo1" name="ruolo" value="paziente" checked>
                <label class="form-check-label">
                    Paziente
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="ruolo2" name="ruolo" value="medico">
                <label class="form-check-label">
                    Medico
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="ruolo3" name="ruolo" value="infermiere">
                <label class="form-check-label">
                    Infermiere
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="ruolo4" name="ruolo" value="impiegato">
                <label class="form-check-label">
                    Impiegato
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="ruolo5" name="ruolo" value="amministratore">
                <label class="form-check-label">
                    Amministratore
                </label>
            </div>
        </div>
    </div>


    <div id="paziente">
        <div class="form-group row">
            <label for="note" class="col-sm-2 col-form-label">Note</label>
            <div class="col-sm-10">
            <textarea cols="40" rows="5" class="form-control" id="note" name="note" value="Nessuna nota"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="altezza" class="col-sm-2 col-form-label">Altezza</label>
            <div class="col-sm-10">
            <input type="number" class="form-control" id="altezza" name="altezza" value="180">
            </div>
        </div>
        <div class="form-group row">
            <label for="peso" class="col-sm-2 col-form-label">Peso</label>
            <div class="col-sm-10">
            <input type="number" class="form-control" id="peso" name="peso" value="80">
            </div>
        </div>
    </div>

    <div id="dipendente">
        <div class="form-group row">
            <label for="idReparto" class="col-sm-2 col-form-label">ID Reparto</label>
            <div class="col-sm-10">
            <input type="number" class="form-control" id="idReparto" name="idReparto">
            </div>
        </div>
        <div class="form-group row">
            <label for="identificativo" class="col-sm-2 col-form-label">Identificativo</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="identificativo" name="identificativo" value="IDNF01">
            </div>
        </div>
        <div class="form-group row">
            <label for="stipendio" class="col-sm-2 col-form-label">Stipendio</label>
            <div class="col-sm-10">
            <input type="number" class="form-control" id="stipendio" name="stipendio">
            </div>
        </div>
    </div>


    <button type="submit" class="btn btn-primary">Registra</button>


</form> 
<br/>
<br/>

<script charset="utf-8" type="text/javascript" src="{{asset('/js/registration.js')}}"></script>

@endsection

