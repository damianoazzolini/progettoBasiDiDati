@extends('layouts.sidebar')
@section('content')
<h4>Aggiorna dati reparto: </h4><h3>{{ $reparto->nome }}</h3>
<br/>
<form method="post" class="col-sm-8">
    <div class="card bg-light">
      <div class="card-header">
        <p class="h6">Dati reparto</p>
      </div>
      <div class="card-body">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group row">
            <label for="nome" class="col-sm-2 col-form-label">Nome</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $reparto->nome }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="identificativo" class="col-sm-2 col-form-label">Identificativo</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="identificativo" name="identificativo" value="{{ $reparto->identificativo }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="descrizione" class="col-sm-2 col-form-label">Descrizione</label>
            <div class="col-sm-10">
            <textarea cols="40" rows="5" class="form-control" id="descrizione" name="descrizione">{{ $reparto->descrizione}}</textarea>
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
                <p>Stai aggiornando i dati del reparto.</p>
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
    <a type="button" class="btn btn-secondary" href="/reparti"></i>Annulla</a>

</form> 


<br/>
<br/>
@endsection