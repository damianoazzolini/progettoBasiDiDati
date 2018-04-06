@extends('layouts.sidebar')
<html>
<body>
<h1> MY FARMACO </h1>
Elenco farmaci:<br>
<table>
<thead>

</thead>
<th> Reparto </th>
<th> Identificativo </th>
<th> Note </th>
<th> Effettuata </th>
<th> Attiva </th>
<tbody>

@foreach($prestazioni as $prestazione) 
    <tr>
    <form method=POST action="{{ action('DashboardController@assegnaRuolo')}}">
        <td> {{ $prestazione->reparto }} </td>
        <td> {{ $prestazione->identificativo }} </td>
        <td> {{ $prestazione->note }} </td>
        <td> {{ $prestazione->effettuata }} </td>
        <td> {{ $prestazione->attiva }} </td>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </tr> 
    </form>
@endforeach
</tbody>
</table>

</body>
</html>