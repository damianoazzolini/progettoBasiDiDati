@extends('layouts.sidebar')
@section('content')

<h4>Dettaglio staff prestazione</h4>

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

<div class="card bg-light">
  <div class="card-header"><p class="h6">Dettaglio</p></div>
    <div class="card-body">
        <p class="card-text"><b>Staff: </b>
            </br>
            @foreach($staff as $componenteStaff) 
                <div class="col-sm-10">
                    <form method="post" action="{{ action('PrestazioneController@deleteStaffPrestazione') }}">
                    {{ $componenteStaff->nome }} {{ $componenteStaff->cognome }} 
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
                        <input type="hidden" name="nomeStaff" value="{{ $componenteStaff->nome }}">
                        <input type="hidden" name="cognomeStaff" value="{{ $componenteStaff->cognome }}">
                        
                        <button type="submit" class="btn btn-default btn-sm">
                            <i class="fa fa-trash"></i> Rimuovi
                        </button>      
                    </form>
                </div>
            @endforeach
        </p>
        
        <p class="card-text"><b>Aggiungi Staff: </b>
            </br>
            <form method="post" class="col-sm-10">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="idPrestazione" value="{{ $idPrestazione }}">
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nomeStaff" name="nomeStaff" placeholder="Nome">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="cognomeStaff" name="cognomeStaff" value="Cognome">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Aggiungi staff</button>
            </form>
        </p>   
    </div>
</div>

@endsection