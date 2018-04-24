@extends('layouts.sidebar')
@section('content')
<h4>Aggiorna dati profilo: </h4><h3>{{ $datiUtente->nome }} {{ $datiUtente->cognome }}</h3>
<br/>
<form method="post">
    <div class="card bg-light">
        <div class="card-header">
            <p class="h6">Dati Anagrafici</p>
        </div>
        <div class="card-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
            <div class="form-group row col-sm-10">
                <label for="nome" class="col-sm-4 col-form-label">Nome</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $datiUtente->nome }}">
                </div>
            </div>

            <div class="form-group row col-sm-10">
                <label for="cognome" class="col-sm-4 col-form-label">Cognome</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="cognome" name="cognome" value="{{ $datiUtente->cognome }}">
                </div>
            </div>
        
        
            <div class="form-group row col-sm-10">
                <label for="dataNascita" class="col-sm-4 col-form-label">Data di nascita</label>
                <div class="col-sm-10">
                <input type="date" class="form-control" id="dataNascita" name="dataNascita" value="{{ $datiUtente->dataNascita }}">
                </div>
            </div>

            <div class="form-group row col-sm-10">
                <label class="col-sm-4 col-form-label">Sesso</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <?php if($datiUtente->sesso == '1') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio1" name="sesso" value="uomo" checked>
                        <?php } ?>
                        <?php if($datiUtente->sesso == '0') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio1" name="sesso" value="uomo">
                        <?php } ?>
                        <label class="form-check-label" for="inlineRadio1">Uomo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <?php if($datiUtente->sesso == '1') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio2" name="sesso" value="donna">
                        <?php } ?>
                        <?php if($datiUtente->sesso == '0') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio2" name="sesso" value="donna" checked>
                        <?php } ?>
                        <label class="form-check-label" for="inlineRadio2">Donna</label>
                    </div>
                </div>
            </div>

            <div class="form-group row col-sm-10">
                <label for="codiceFiscale" class="col-sm-4 col-form-label">Codice Fiscale</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale" value="{{ $datiUtente->codiceFiscale }}">
                </div>
            </div>

            <div class="form-group row col-sm-10">
                <label for="email" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $datiUtente->email }}">
                </div>
            </div>

            <div class="form-group row col-sm-10">
                <label for="telefono" class="col-sm-4 col-form-label">Telefono</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $datiUtente->telefono }}">
                </div>
            </div>

            <div class="form-group row col-sm-10">
                <label for="via" class="col-sm-4 col-form-label">Via</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="via" name="via" value="{{ $datiUtente->via }}">
                </div>
            </div>
            
            <div class="form-group row col-sm-10">
                <label for="civico" class="col-sm-4 col-form-label">Civico</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="civico" name="civico" value="{{ $datiUtente->numeroCivico }}">
                </div>
            </div>
           
            <div class="form-group row col-sm-10">
                <label for="comune" class="col-sm-4 col-form-label">Comune</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="comune" name="comune" value="{{ $datiUtente->comune }}">
                </div>
            </div>

            <div class="form-group row col-sm-10">            
                <label for="provincia" class="col-sm-4 col-form-label">Provincia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="provincia" name="provincia" value="{{ $datiUtente->provincia }}">
                </div>
            </div>
            
            <div class="form-group row col-sm-10">
                <label for="stato" class="col-sm-4 col-form-label">Stato</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="stato" name="stato" value="{{ $datiUtente->stato }}">
                </div>
            </div>
            
        </div>
    </div>
    <br/>
    
    <!-- Modal confema modifiche-->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confermi l'operazione ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Stai aggiornando i dati del profilo.</p>
            <p>Premi su <b>Conferma</b> per applicare le modifiche.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
            <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Aggiorna</button>
        </div>
        </div>
    </div>
    </div>
    <br/>
    <a type="button" class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-edit" style="color:white"></i> Aggiorna</a>
    <a type="button" class="btn btn-secondary" href="/profilo"></i>Annulla</a>
</form> 


<br/>
<br/>
@endsection