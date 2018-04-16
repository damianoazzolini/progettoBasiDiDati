@extends('layouts.sidebar')
@section('content')
<h4> Referto </h4>
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

<div class="row">
  <div class="col"></div>
  <div class="col">
    <a type="button" class="btn btn-secondary float-sm-right" style="margin-left: 5px; color:white" href="{{ URL::previous() }}"></i>Chiudi</a>
  </div>
</div>
<br/>

<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati referto</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Esito: </b>{{ $referto->esito }}</p>
    <p class="card-text"><b>Note: </b>{{ $referto->note }}</p>
  </div>
</div>
@endsection