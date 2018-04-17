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

<br/>
<table class="table">
<thead>
<th scope="col"> Nome </th>
<th scope="col"> Cognome </th>
<th scope="col"></th>
</thead>

<tbody>
@foreach($datiStaff as $staff)
    <tr>
        
        <td> {{ $staff->nome }} </td>
        <td> {{ $staff->cognome }} </td>        
    
        <td>
            <div>
                <a type="button" class="btn btn-success" href="/mostraStaff/{{ $staff->id }}"><i class="fas fa-eye" style="color:black"></i></a>
                <a type="button" class="btn btn-warning" href="/modificaStaff/{{ $staff->id }}"><i class="fas fa-edit"></i></a>
            </div>
        </td>
    </tr> 
@endforeach
</tbody>
</table>

@endsection