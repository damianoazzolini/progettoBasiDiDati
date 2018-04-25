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
@if($ruolo != "Paziente")
<form action="/elencoPrestazioni" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-row col-md-8">
            <div class="col-3">
                <label class="col-form-label"><b>Ricerca prestazione</b></label>
            </div>
            <div class="col">
                <input type="text" class="form-control" name="search" placeholder="Paziente / Medico">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cerca</button>
                <a type="button" class="btn btn-primary" href="/elencoPrestazioni"><i class="fas fa-list-ul" style="color:white"></i> Mostra tutti</a>
            </div>
        </div>
        @if($ruolo != "Infermiere" and $ruolo != "Paziente")
        <div class="col">
                <a type="button" class="btn btn-primary float-sm-right" href="/aggiungiPrestazione"><i class="fas fa-plus" style="color:white"></i> Aggiungi nuova</a>
        </div>
        @endif
    </div>
</form>
<br/>
@endif
<table class="table">
<thead>
@if($ruolo != "Paziente")
<th scope="col"> Nome Paziente </th>
<th scope="col"> Cognome Paziente </th>
@endif
<th scope="col"> Data </th>
<th scope="col"> Ora </th>
<th scope="col"> Attiva </th>
<th scope="col"> Effettuata </th>
<th scope="col"></th>
</thead>

<tbody>
@for ($i = 0; $i < count($prestazioni); $i++) 
    <tr>
        @if($ruolo != "Paziente")
        <td> {{ $pazienti[$i]->nome }} </td>
        <td> {{ $pazienti[$i]->cognome }} </td>
        @endif
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
                @if($ruolo == "Amministratore")
                <a type="button" class="btn btn-warning" href="/modificaPrestazione/{{ $prestazioni[$i]->id }}"><i class="fas fa-edit"></i></a>
                @endif
                @if($ruolo == "Amministratore")
                    <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $prestazioni[$i]->id }}"><i class="fas fa-trash-alt"></i></a>
                @endif
                
                @if(!$prestazioni[$i]->effettuata)
                    <a type="button" class="btn btn-success" href="/effettuaPrestazione/{{ $prestazioni[$i]->id }}"><i class="fas fa-check" style="color:black"></i></a>            
                @endif
                @if($prestazioni[$i]->effettuata)
                    <a type="button" class="btn btn-info" href="/visualizzaReferto/{{ $prestazioni[$i]->id }}"><i class="fas fa-clone" style="color:black"></i></a>                            
                @endif
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