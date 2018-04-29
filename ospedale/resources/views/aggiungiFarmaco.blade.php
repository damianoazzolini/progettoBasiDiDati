@extends('layouts.sidebar')
@section('content')
<h4>Inserimento nuovo farmaco</h4>
<br/>
<form method="post" class="col-sm-10">
    <div class="card bg-light">
      <div class="card-header">
        <p class="h6">Dati tecnici</p>
      </div>
      <div class="card-body">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group row col-sm-10"> 
            <label for="nome" class="col-sm-6 col-form-label">Nome</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="nome" name="nome">
            </div>
        </div>
        <div class="form-group row col-sm-10"> 
            <label for="categoria" class="col-sm-6 col-form-label">Categoria</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="categoria" name="categoria">
            </div>
        </div>
        <div class="form-group row col-sm-10"> 
            <label for="descrizione" class="col-sm-6 col-form-label">Descrizione</label>
            <div class="col-sm-10">
            <textarea cols="40" rows="5" class="form-control" id="descrizione" name="descrizione"></textarea>
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
                <p>Stai creando un nuovo farmaco.</p>
                <p>Premi su <b>Conferma</b> per procedere.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Conferma</button>
            </div>
            </div>
        </div>
    </div>

    <br/>
    <a type="button" class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-plus" style="color:white"></i> Inserisci</a>
    <a type="button" class="btn btn-secondary" href="/farmacia"></i>Annulla</a>

</form> 


<br/>
<br/>
@endsection