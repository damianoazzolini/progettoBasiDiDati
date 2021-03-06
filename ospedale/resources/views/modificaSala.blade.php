@extends('layouts.sidebar')
@section('content')
<h4>Aggiorna dati sala: </h4><h3>{{ $sala->nomeSala }}</h3>
<br/>
<div>
    @if (session('status'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br/>
    @endif
</div>
<form method="post" class="col-sm-8">
    <div class="card bg-light">
        <div class="card-header">
            <p class="h6">Dati sala</p>
        </div>
        <div class="card-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group row col-sm-10">
                <label for="nomeSala" class="col-sm-6 col-form-label">Nome</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nomeSala" name="nomeSala" value="{{ $sala->nomeSala}}">
                </div>
            </div>
            <div class="form-group row col-sm-10">
                <label for="identificativoReparto" class="col-sm-6 col-form-label">Identificativo Reparto</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="identificativoReparto" name="identificativoReparto" value="{{ $sala->identificativoReparto }}">
                </div>
            </div>
            <div class="form-group row col-sm-10">
                <label for="piano" class="col-sm-6 col-form-label">Piano</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="piano" name="piano" value="{{ $sala->piano }}">
                </div>
            </div>
            <div class="form-group row col-sm-10">
                <label for="descrizioneSala" class="col-sm-6 col-form-label">Descrizione</label>
                <div class="col-sm-10">
                <textarea cols="40" rows="5" class="form-control" id="descrizioneSala" name="descrizioneSala">{{ $sala->descrizioneSala }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confema modifiche-->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confermi l'operazione ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Stai aggiornando i dati della sala.</p>
                <p>Premi su <b>Conferma</b> per applicare le modifiche.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Conferma</button>
            </div>
            </div>
        </div>
    </div>

    <br/>
    <a type="button" class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-edit" style="color:white"></i> Aggiorna</a>
    <a type="button" class="btn btn-secondary" href="/sale"></i>Annulla</a>

</form> 

<br/>
<br/>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script charset="utf-8" type="text/javascript" src="{{asset('/js/sale.js')}}" ></script>
@endsection