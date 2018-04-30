@extends('layouts.sidebar')
@section('content')
<h4>Dettaglio farmaci prestazione</h4>
</br>
<div>
    @if (session('status'))
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </br>            
        </div>
    @endif
</div>
<h6> Aggiungi un farmaco alla prestazione indicandone il nome</h6>
</br>
<table class="table">
    <thead>
    <th scope="col"> Nome </th>
    <th scope="col"> </th>
    </thead>

    <tbody>
    <tr>
    <form method="post" class="col-sm-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
        <td><input type="text" class="form-control" id="nomeFarmaco" name="nomeFarmaco" placeholder="Nome"></td>
        <td><button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Aggiungi</button></td>
    </form>
    </tr>

    @foreach($farmaci as $farmaco)  
        <tr>
            <td>{{ $farmaco->nome }} </td>
            <td>
            <form method="post" action="{{ action('PrestazioneController@deleteFarmacoPrestazione') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
            <input type="hidden" name="nomeFarmaco" value="{{ $farmaco->nome }}">
            <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Rimuovi</button> 
        </tr> 
    @endforeach
    </tbody>
</table>
</br>
@endsection