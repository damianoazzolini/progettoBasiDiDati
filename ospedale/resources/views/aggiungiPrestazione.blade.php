@extends('layouts.sidebar')
@section('content')
<h4> Aggiunta nuova prestazione </h4>
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

<form method="post" class="col-sm-20">
    <div class="card bg-light">
        <div class="card-header">
            <p class="h6">Dati Prestazione</p>
        </div>
        <div class="card-body">
            
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group row col-sm-10">
                    <label for="identificativoReparto" class="col-sm-6 col-form-label">Reparto</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="identificativoReparto" name="identificativoReparto" placeholder="Nome Reparto">
                    </div>
                </div>
                <div class="form-group row col-sm-10">
                    <label for="identificativoSala" class="col-sm-6 col-form-label">Identificativo sala</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="identificativoSala" name="identificativoSala" placeholder="Sala">
                    </div>
                </div>
                <div class="form-group row col-sm-10">
                    <label for="data" class="col-sm-6 col-form-label">Data della prestazione</label>
                    <div class="col-sm-10">
                    <input type="date" class="form-control" id="data" name="data">
                    </div>
                </div>
                <div class="form-group row col-sm-10">
                    <label for="ora" class="col-sm-6 col-form-label">Ora della prestazione</label>
                    <div class="col-sm-10">
                    <input type="time" class="form-control" id="ora" name="ora" placeholder="Ora">
                    </div>
                </div>
                
                <div class="form-group row col-sm-10">
                    <label for="durata" class="col-sm-6 col-form-label">Durata della prestazione</label>
                    <div class="col-sm-10">
                    <input type="number" class="form-control" id="durata" name="durata" placeholder="Durata in minuti">
                    </div>
                </div>

                <div class="form-group row col-sm-10">
                    <label for="identificativo" class="col-sm-6 col-form-label">Tipo della prestazione</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="identificativo" name="identificativo" placeholder="Tipo">
                    </div>
                </div>

                <div class="form-group row col-sm-10">
                    <label for="nomePaziente" class="col-sm-6 col-form-label">Nome Paziente</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="nomePaziente" name="nomePaziente" placeholder="Nome Paziente">
                    </div>
                </div>
                
                <div class="form-group row col-sm-10">
                    <label for="cognomePaziente" class="col-sm-6 col-form-label">Cognome Paziente</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="cognomePaziente" name="cognomePaziente" placeholder="Cognome Paziente">
                    </div>
                </div>

                <div class="form-group row col-sm-10">
                    <label for="codiceFiscale" class="col-sm-6 col-form-label">Codice Fiscale</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale" placeholder="C.F.">
                    </div>
                </div>

                <div class="form-group row col-sm-10">
                    <label for="nomeStaff" class="col-sm-6 col-form-label">Nome Membro Staff</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="nomeStaff" name="nomeStaff" placeholder="Nome Staff">
                    </div>
                </div>

                <div class="form-group row col-sm-10">
                    <label for="cognomeStaff" class="col-sm-6 col-form-label">Cognome Membro Staff</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="cognomeStaff" name="cognomeStaff" placeholder="Cognome Staff">
                    </div>
                </div>


                <div class="form-group row col-sm-10">
                    <label for="note" class="col-sm-6 col-form-label">Note</label>
                    <div class="col-sm-10">
                    <textarea cols="40" rows="5" class="form-control" id="note" name="note" placeholder="Nessuna nota"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    <button type="submit" class="btn btn-primary">Crea una nuova prestazione</button>
    <a type="button" class="btn btn-secondary" href="/elencoPrestazioni"></i>Annulla</a>
</form> 
<br/>
<br/>
<script charset="utf-8" type="text/javascript" src="{{asset('/js/registration.js')}}"></script>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script charset="utf-8" type="text/javascript" src="{{asset('/js/prestazioni.js')}}" ></script>
@endsection

