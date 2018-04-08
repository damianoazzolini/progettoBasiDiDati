{{-- 
<html>
<body>
<h1> DASHBOARD </h1>
Elenco utenti:<br>
<table>
<thead>

</thead>
<th> Nome </th>
<th> Cognome </th>
<th> Email </th>
<th> Paziente </th>
<th> Medico </th>
<th> Infermiere </th>
<th> Impiegato </th>
<th> Amministratore </th>
<tbody>

@foreach($users as $user) 
    <tr>
    <form method=POST action="{{ action('DashboardController@assegnaRuolo')}}">
        <td> {{ $user->nome }} </td>
        <td> {{ $user->cognome }} </td>
        <td> {{ $user->email }} </td>
        <td><input type="checkbox" {{ $user->hasRole('Paziente') ? 'checked' : ''}} name="ruolo_paziente"></td>
        <td><input type="checkbox" {{ $user->hasRole('Medico') ? 'checked' : ''}} name="ruolo_medico"></td>
        <td><input type="checkbox" {{ $user->hasRole('Infermiere') ? 'checked' : ''}} name="ruolo_nfermiere"></td>
        <td><input type="checkbox" {{ $user->hasRole('Impiegato') ? 'checked' : ''}} name="ruolo_impiegato"></td>
        <td><input type="checkbox" {{ $user->hasRole('Amministratore') ? 'checked' : ''}} name="ruolo_amministratore"></td>
        <td><input type="submit" value="Assegna Ruolo"></td>
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </tr> 
    </form>
@endforeach
</tbody>
</table>

</body>
</html>
--}}
@extends('layouts.sidebar')
@section('content')
<div>
    @if (session('status'))
        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
<h1> Contenuto </h1>



@endsection

