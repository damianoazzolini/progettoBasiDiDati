@extends('layouts.sidebar')
@section('content')

<h4>Elenco staff</h4>

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
<form action="/elencoStaff" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-row col-md-8">
            <div class="col-3">
                <label class="col-form-label"><b>Ricerca membro staff</b></label>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="search" placeholder="Nome/Cognome">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cerca</button>
                <a type="button" class="btn btn-primary" href="/elencoStaff"><i class="fas fa-list-ul" style="color:white"></i> Mostra tutti</a>
            </div>
        </div>
        @if($ruolo == "Amministratore")
            <div class="col">
                    <a type="button" class="btn btn-primary float-sm-right" href="/aggiungiStaff"><i class="fas fa-user-plus" style="color:white"></i> Aggiungi nuovo</a>
            </div>
        @endif
    </div>
</form>
<br/>
<table class="table">
<thead>
<th scope="col"> ID </th>
<th scope="col"> Nome </th>
<th scope="col"> Cognome </th>
<th scope="col"> Identificativo Personale</th>
<th scope="col"> Identificativo Reparto</th>
<th scope="col"></th>
</thead>

<tbody>
@foreach($datiStaff as $staff)
    <tr>
        <td> {{ $staff->id }} </td>
        <td> {{ $staff->nome }} </td>
        <td> {{ $staff->cognome }} </td> 
        <td> {{ $staff->identificativoPersonale }} </td>  
        <td> <a href="/mostraReparto/{{ $staff->idReparto }} "> {{ $staff->identificativoReparto }}  </a></td>          
    
        <td>
            <div>
                <a type="button" class="btn btn-success" href="/mostraStaff/{{ $staff->id }}"><i class="fas fa-eye" style="color:black"></i></a>
                <a type="button" class="btn btn-warning" href="/modificaStaff/{{ $staff->id }}"><i class="fas fa-edit"></i></a>
                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $staff->id}}"><i class="fas fa-trash-alt"></i></a>
            </div>
        </td>
    </tr> 
    <!-- Modal di conferma cancellazione-->
    <div class="modal fade" id="deleteModal{{ $staff->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confermi l'operazione ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Vuoi davvero cancellare il membro dello staff:<br/>
            <b>ID: </b>{{ $staff->id }}<br/>
            <b>Nome: </b>{{ $staff->nome }}<br/>
            <b>Cognome: </b>{{ $staff->cognome }}<br/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a type="button" class="btn btn-danger" href="/cancellaStaff/{{ $staff->id}}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
    </div>
@endforeach
</tbody>
</table>

@endsection