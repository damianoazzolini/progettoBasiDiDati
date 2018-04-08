@extends('layouts.sidebar')
@section('content')


<h1>Elenco pazienti</h1>

<table class="table">
<thead>
<th scope="col"> ID </th>
<th scope="col"> Nome </th>
<th scope="col"> Cognome </th>
<th scope="col"></th>
</thead>

<tbody>
@foreach($pazienti as $paziente) 
    <tr>
        <th scope="row">{{ $paziente->id}}</th>
        <td> {{ $paziente->nome }} </td>
        <td> {{ $paziente->cognome }} </td>
        <td>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-success"><i class="fas fa-eye"></i></button>
                <button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
            </div>
        </td>
    </tr> 
    </form>
@endforeach
</tbody>
</table>
@endsection