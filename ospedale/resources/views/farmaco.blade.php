@extends('layouts.sidebar')
<html>
<body>
<h1> MY FARMACO </h1>
Elenco farmaci:<br>
<table>
<thead>

</thead>
<th> Nome </th>
<th> Categoria </th>
<th> Descrizione </th>
<tbody>

@foreach($farmaci as $farmaco) 
    <tr>
    <form method=POST action="{{ action('DashboardController@assegnaRuolo')}}">
        <td> {{ $farmaco->nome }} </td>
        <td> {{ $farmaco->categoria }} </td>
        <td> {{ $farmco->descrizione }} </td>
        <td><input type="button" onclick="">Rimuovi Farmaco</td>
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </tr> 
    </form>
@endforeach
</tbody>
</table>

</body>
</html>