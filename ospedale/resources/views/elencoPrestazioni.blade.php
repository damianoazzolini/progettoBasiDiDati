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
<form action="/reparti" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-row col-md-8">
            <div class="col-3">
                <label class="col-form-label"><b>Ricerca prestazione</b></label>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="search" placeholder="Nome">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cerca</button>
                <a type="button" class="btn btn-primary" href="/elencoPrestazioni"><i class="fas fa-list-ul" style="color:white"></i> Mostra tutti</a>
            </div>
        </div>
    </div>
</form>
<br/>
<table class="table">
<thead>
<th scope="col"> Nome Paziente </th>
<th scope="col"> Cognome Paziente </th>
<th scope="col"> Data </th>
<th scope="col"> Ora </th>
<th scope="col"> Attiva </th>
<th scope="col"> Effettuata </th>
<th scope="col"></th>
</thead>

<tbody>
@for ($i = 0; $i < count($prestazioni); $i++) 
    <tr>
        <th scope="row">{{ $pazienti[$i]->nome }}</th>
        <td> {{ $pazienti[$i]->cognome }} </td>
        <td> {{ $prestazioni[$i]->data }} </td>
        <td> {{ $prestazioni[$i]->ora }} </td>
        @if($prestazioni[$i]->attivo)
            <td> <input type="checkbox" name="attivo" checked disabled> </td>
        @else
            <td> <input type="checkbox" name="attivo" disabled> </td>
        @endif

        @if($prestazioni[$i]->effettuata)
            <td> <input type="checkbox" name="effettuata" checked disabled> </td>
        @else
            <td> <input type="checkbox" name="effettuata" disabled> </td>
        @endif
        
        <td>
            <div>
                <a type="button" class="btn btn-primary" href="/mostraPrestazione/{{ $prestazioni[$i]->id }}"><i class="fas fa-eye" style="color:black"></i></a>
                <a type="button" class="btn btn-warning" href="/modificaPrestazione/{{ $prestazioni[$i]->id }}"><i class="fas fa-edit"></i></a>
                <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $prestazioni[$i]->id }}"><i class="fas fa-trash-alt"></i></a>
                <a type="button" class="btn btn-success" href="/effettuaPrestazione/{{ $prestazioni[$i]->id }}"><i class="fas fa-check" style="color:black"></i></a>            
            </div>
        </td>
    </tr> 
    <!-- Modal di conferma cancellazione-->
    <div class="modal fade" id="deleteModal{{ $prestazioni[$i]->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
            <b>Nome: </b>{{ $pazienti[$i]->nome }}<br/>
            <b>Cognome: </b>{{ $pazienti[$i]->cognome }}<br/>
            <b>Data: </b>{{ $prestazioni[$i]->data }}<br/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <a type="button" class="btn btn-danger" href="/cancellaPrestazione/{{ $prestazioni[$i]->id}}"><i class="fas fa-trash-alt"></i> Cancella</a>
        </div>
        </div>
    </div>
    </div>
@endfor
</tbody>


{{-- 
{{ print_r($pazienti) }}
{{ print_r($prestazioni) }}

{{ empty($pazienti) }}
{{ count($prestazioni) }}
--}}

</table>
@endsection