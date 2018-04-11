@extends('layouts.sidebar')
@section('content')

<h4>Elenco prestazioni</h4>
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
<form action="/elencoPrestazioni" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-row col-md-8">
            <div class="col-3">
                <label class="col-form-label"><b>Ricerca prestazione</b></label>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="search" placeholder="Nome paziente/Cognome paziente/CF/Nome medico">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cerca</button>
                <a type="button" class="btn btn-primary" href="/elencoPrestazioni"><i class="fas fa-list-ul" style="color:white"></i> Mostra tutte</a>
            </div>
        </div>
        <div class="col">
                <a type="button" class="btn btn-primary float-sm-right" href="/aggiungiPrestazione"><i class="fas fa-plus" style="color:white"></i> Aggiungi nuova</a>
        </div>
    </div>
</form>
<br/>
<table class="table">
<thead>
<th scope="col"> ID </th>
<th scope="col"> Reparto </th>
<th scope="col"> Sala </th>
<th scope="col"> ID Paziente </th>
<th scope="col"> Identificativo </th>
<th scope="col"> Note </th>
<th scope="col"> Data </th>
<th scope="col"> Ora </th>
<th scope="col"> Effettuata </th>
<th scope="col"> Attiva </th>
<th scope="col"></th>
</thead>

<tbody>
@foreach($prestazioni as $prestazione) 
    <tr>
        <th scope="row">{{ $prestazione->id}}</th>
        <td> {{ $prestazione->idRparto }} </td>
        <td> {{ $prestazione->idSala }} </td>
        <td> {{ $prestazione->idPaziente }} </td>
        <td> {{ $prestazione->identificativo }} </td>
        <td> {{ $prestazione->note }} </td>
        <td> {{ $prestazione->data }} </td>
        <td> {{ $prestazione->ora }} </td>
        <td> {{ $prestazione->effettuata }} </td>
        <td> {{ $prestazione->attiva }} </td>
        <td>
            <div>
                <a type="button" class="btn btn-success" href="/mostraPrestazione/{{ $prestazione->id}}"><i class="fas fa-eye" style="color:black"></i></a>
                <a type="button" class="btn btn-warning" href="/modificaPrestazione/{{ $prestazione->id}}"><i class="fas fa-edit"></i></a>
                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $prestazione->id}}"><i class="fas fa-trash-alt"></i></a>
            </div>
        </td>
    </tr> 
    <!-- Modal di conferma cancellazione-->
    <div class="modal fade" id="deleteModal{{ $prestazione->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confermi l'operazione ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Vuoi davvero cancellare la prestazione:<br/>
            <b>ID: </b>{{ $prestazione->id }}<br/>
            <b>Data: </b>{{ $prestazione->data }}<br/>
            <b>Ora: </b>{{ $prestazione->ora }}<br/>
            <b>ID Paziente: </b>{{ $prestazione->idPaziente }}<br/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a type="button" class="btn btn-danger" href="/cancellaPrestazione/{{ $prestazione->id}}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
    </div>
@endforeach
</tbody>
</table>




@endsection