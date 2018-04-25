@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio Staff Prestazione</h4>
</br>
<div>
    @if (session('status'))
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br/>
        </br>
    @endif
</div>
<h6> Aggiungi un membro dello staff alla prestazione indicandone il nome e il cognome </h6>
</br>
<table class="table">
    <thead>
    <th scope="col"> Nome </th>
    <th scope="col"> Cognome </th>
    <th scope="col"> </th>
    </thead>

    <tbody>
    <tr>
    <form method="post" class="col-sm-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
        <td><input type="text" class="form-control" id="nomeStaff" name="nomeStaff" placeholder="Nome"></td>
        <td><input type="text" class="form-control" id="cognomeStaff" name="cognomeStaff" placeholder="Cognome"></td>
        <td><button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Aggiungi</button></td>
    </form>
    </tr>

    @foreach($staff as $componenteStaff) 
        <tr>
            <td>{{ $componenteStaff->nome }} </td>
            <td>{{ $componenteStaff->cognome }} </td>
            <td>
            <form method="post" action="{{ action('PrestazioneController@deleteStaffPrestazione') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
                <input type="hidden" name="nomeStaff" value="{{ $componenteStaff->nome }}">
                <input type="hidden" name="cognomeStaff" value="{{ $componenteStaff->cognome }}">
        
                <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Rimuovi</button>       
            </form>
        </tr> 
    @endforeach
    </tbody>
</table>
</br>
@endsection