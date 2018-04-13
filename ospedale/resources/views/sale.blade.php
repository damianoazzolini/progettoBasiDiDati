@extends('layouts.sidebar')
@section('content')

<h4>Elenco sale</h4>
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
<form action="/sale" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-row col-md-8">
            <div class="col-3">
                <label class="col-form-label"><b>Ricerca sala</b></label>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="search" placeholder="Nome">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cerca</button>
                <a type="button" class="btn btn-primary" href="/sale"><i class="fas fa-list-ul" style="color:white"></i> Mostra tutti</a>
            </div>
        </div>
        <div class="col">
                <a type="button" class="btn btn-primary float-sm-right" href="/aggiungiSala"><i class="fas fa-plus" style="color:white"></i> Aggiungi nuovo</a>
        </div>
    </div>
</form>
<br/>
<table class="table">
<thead>
<th scope="col"> ID </th>
<th scope="col"> Nome </th>
<th scope="col"> Identificativo Reparto</th>
<th scope="col"> Piano</th>
<th scope="col"></th>
</thead>

<tbody>
@foreach($sale as $sala) 
    <tr>
        <th scope="row">{{ $sala->id}}</th>
        <td> {{ $sala->nomeSala }} </td>
        <td> {{ $sala->identificativoReparto }} </td>
        <td> {{ $sala->piano }} </td>
        <td>
            <div>
                <a type="button" class="btn btn-success" href="/mostraSala/{{ $sala->id}}"><i class="fas fa-eye" style="color:black"></i></a>
                <a type="button" class="btn btn-warning" href="/modificaSala/{{ $sala->id}}"><i class="fas fa-edit"></i></a>
                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $sala->id}}"><i class="fas fa-trash-alt"></i></a>
            </div>
        </td>
    </tr> 
    <!-- Modal di conferma cancellazione-->
    <div class="modal fade" id="deleteModal{{ $sala->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confermi l'operazione ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Vuoi davvero cancellare la sala:<br/>
            <b>ID: </b>{{ $sala->id }}<br/>
            <b>Nome: </b>{{ $sala->nomeSala }}<br/>
            <b>Reparto: </b>{{ $sala->identificativoReparto }}<br/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a type="button" class="btn btn-danger" href="/cancellaSala/{{ $sala->id}}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
    </div>
@endforeach
</tbody>
</table>
@endsection