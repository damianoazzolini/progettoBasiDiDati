@extends('layouts.sidebar')
@section('content')
<h4>Aggiorna dati paziente: </h4><h3>{{ $datiPaziente->nome }} {{ $datiPaziente->cognome }}</h3>
<br/>
<form method="post" class="col-sm-20">
    <div class="card bg-light">
        <div class="card-header">
            <p class="h6">Dati Anagrafici</p>
        </div>
        <div class="card-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group row col-sm-10"> 
                <label for="nome" class="col-sm-6 col-form-label">Nome</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ $datiPaziente->nome }}">
                </div>
            </div>
            
            <div class="form-group row col-sm-10"> 
                <label for="cognome" class="col-sm-6 col-form-label">Cognome</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cognome" name="cognome" value="{{ $datiPaziente->cognome }}">
                </div>
            </div>
            
            <div class="form-group row col-sm-10"> 
                <label for="dataNascita" class="col-sm-6 col-form-label">Data di nascita</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="dataNascita" name="dataNascita" value="{{ $datiPaziente->dataNascita }}">
                </div>
            </div>
            
            <div class="form-group row col-sm-10"> 
                <label class="col-sm-10 col-form-label">Sesso</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <?php if($datiPaziente->sesso == '1') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio1" name="sesso" value="uomo" checked>
                        <?php } ?>
                        <?php if($datiPaziente->sesso == '0') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio1" name="sesso" value="uomo">
                        <?php } ?>
                        <label class="form-check-label" for="inlineRadio1">Uomo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <?php if($datiPaziente->sesso == '1') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio2" name="sesso" value="donna">
                        <?php } ?>
                        <?php if($datiPaziente->sesso == '0') {?>
                        <input class="form-check-input" type="radio" id="inlineRadio2" name="sesso" value="donna" checked>
                        <?php } ?>
                        <label class="form-check-label" for="inlineRadio2">Donna</label>
                    </div>
                </div>
            </div>

            <div class="form-group row col-sm-10"> 
                <label for="codiceFiscale" class="col-sm-6 col-form-label">Codice Fiscale</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale" value="{{ $datiPaziente->codiceFiscale }}">
                </div>
            </div>
            
            <div class="form-group row col-sm-10"> 
                <label for="email" class="col-sm-6 col-form-label">Email</label>
                <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $datiPaziente->email }}">
                </div>
            </div>

            <div class="form-group row col-sm-10"> 
                <label for="telefono" class="col-sm-6 col-form-label">Telefono</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $datiPaziente->telefono }}">
                </div>
            </div>

            <div class="form-group row col-sm-10"> 
                <label for="via" class="col-sm-6 col-form-label">Via</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="via" name="via" value="{{ $datiPaziente->via }}">
                </div>
            </div>

            <div class="form-group row col-sm-10"> 
                <label for="civico" class="col-sm-6 col-form-label">Civico</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="civico" name="civico" value="{{ $datiPaziente->numeroCivico }}">
                </div>
            </div>
            
            
            <div class="form-group row col-sm-10"> 
                <label for="comune" class="col-sm-6 col-form-label">Comune</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="comune" name="comune" value="{{ $datiPaziente->comune }}">
                </div>
            </div>

            <div class="form-group row col-sm-10"> 
                <label for="provincia" class="col-sm-6 col-form-label">Provincia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="provincia" name="provincia" value="{{ $datiPaziente->provincia }}">
                </div>
            </div>
                
            <div class="form-group row col-sm-10"> 
                <label for="stato" class="col-sm-6 col-form-label">Stato</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="stato" name="stato" value="{{ $datiPaziente->stato }}">
                </div>
            </div>    
        </div>
    </div>

    <br/>
    
    <div class="card bg-light">
        <div class="card-header">
            <p class="h6">Dati Clinici</p>
        </div>
        
        <div class="card-body">          
            <div class="form-group row col-sm-10"> 
                <label for="altezza" class="col-sm-6 col-form-label">Altezza</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="altezza" name="altezza" value="{{ $datiPaziente->altezza }}">
                </div>
            </div>
            
            <div class="form-group row col-sm-10"> 
                <label for="peso" class="col-sm-6 col-form-label">Peso</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="peso" name="peso" value="{{ $datiPaziente->peso }}">
                </div>
            </div>

            <div class="form-group row col-sm-10"> 
                <label for="note" class="col-sm-6 col-form-label">Note mediche</label>
                <div class="col-sm-10">
                    <textarea cols="40" rows="5" class="form-control" id="note" name="note">{{ $datiPaziente->note }}</textarea>
                </div>
            </div>
        </div>
    </div>

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
                <p>Stai aggiornando i dati del paziente.</p>
                <p>Premi su <b>Conferma</b> per applicare le modifiche.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Conferma</button>
            </div>
            </div>
        </div>
    </div>
    <br/>
    <a type="button" class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-edit" style="color:white"></i> Aggiorna</a>
    <a type="button" class="btn btn-secondary" href="/elencoPazienti"></i>Annulla</a>
</form> 
<br/>
<br/>
@endsection