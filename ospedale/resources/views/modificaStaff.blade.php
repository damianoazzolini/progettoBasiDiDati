@extends('layouts.sidebar')
@section('content')
<h4>Aggiorna dati componente staff: </h4><h3>{{ $datiUtente->nome }} {{ $datiUtente->cognome }}</h3>
<br/>

<form method="post" class="col-sm-20">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
@if ($ruolo == "Amministratore")
<div class="card bg-light">
    <div class="card-header">
        <p class="h6">Dati Anagrafici</p>
    </div>
    <div class="card-body">       
        <div class="form-group row col-sm-10"> 
            <label for="nome" class="col-sm-6 col-form-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $datiUtente->nome }}">
            </div>
        </div>

        <div class="form-group row col-sm-10"> 
            <label for="cognome" class="col-sm-6 col-form-label">Cognome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="cognome" name="cognome" value="{{ $datiUtente->cognome }}">
            </div>
        </div>
    
        <div class="form-group row col-sm-10"> 
            <label for="dataNascita" class="col-sm-6 col-form-label">Data di nascita</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="dataNascita" name="dataNascita" value="{{ $datiUtente->dataNascita }}">
            </div>
        </div>

        <div class="form-group row col-sm-10"> 
            <label class="col-sm-6 col-form-label">Sesso</label>
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
            <label for="codiceFiscale" class="col-sm-6 col-form-label">Codice Fiscale</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale" value="{{ $datiUtente->codiceFiscale }}">
            </div>
        </div>
    
        <div class="form-group row col-sm-10"> 
            <label for="email" class="col-sm-6 col-form-label">Email</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="{{ $datiUtente->email }}">
            </div>
        </div>
        
        <div class="form-group row col-sm-10"> 
            <label for="telefono" class="col-sm-6 col-form-label">Telefono</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $datiUtente->telefono }}">
            </div>
        </div>
            
        <div class="form-group row col-sm-10"> 
            <label for="via" class="col-sm-6 col-form-label">Via</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="via" name="via" value="{{ $datiUtente->via }}">
            </div>
        </div>
        
        <div class="form-group row col-sm-10"> 
            <label for="civico" class="col-sm-6 col-form-label">Civico</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="civico" name="civico" value="{{ $datiUtente->numeroCivico }}">
            </div>
        </div>

        <div class="form-group row col-sm-10"> 
            <label for="comune" class="col-sm-6 col-form-label">Comune</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="comune" name="comune" value="{{ $datiUtente->comune }}">
            </div>
        </div>

        <div class="form-group row col-sm-10"> 
            <label for="provincia" class="col-sm-6 col-form-label">Provincia</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="provincia" name="provincia" value="{{ $datiUtente->provincia }}">
            </div>
        </div>
    
        <div class="form-group row col-sm-10"> 
            <label for="stato" class="col-sm-6 col-form-label">Stato</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="stato" name="stato" value="{{ $datiUtente->stato }}">
            </div>
        </div>

        
        <div class="form-group row col-sm-10"> 
            <label class="col-sm-6 col-form-label">Ruolo</label>
            <div class="col-sm-10">
                <div class="form-check">
                    @if($ruoloStaff == "Medico")
                    <input class="form-check-input" type="radio" id="ruolo2" name="ruolo" value="medico" checked>
                    @else
                    <input class="form-check-input" type="radio" id="ruolo2" name="ruolo" value="medico">
                    @endif
                    <label class="form-check-label">
                        Medico
                    </label>
                </div>
                <div class="form-check">
                    @if($ruoloStaff == "Infermiere")
                    <input class="form-check-input" type="radio" id="ruolo3" name="ruolo" value="infermiere" checked>
                    @else
                    <input class="form-check-input" type="radio" id="ruolo3" name="ruolo" value="infermiere">
                    @endif
                    <label class="form-check-label">
                        Infermiere
                    </label>
                </div>
                <div class="form-check">
                    @if($ruoloStaff == "Impiegato")
                    <input class="form-check-input" type="radio" id="ruolo4" name="ruolo" value="impiegato" checked>
                    @else
                    <input class="form-check-input" type="radio" id="ruolo4" name="ruolo" value="impiegato">
                    @endif
                    <label class="form-check-label">
                        Impiegato
                    </label>
                </div>
                <div class="form-check">
                    @if($ruoloStaff == "Amministratore")
                    <input class="form-check-input" type="radio" id="ruolo5" name="ruolo" value="amministratore" checked>
                    @else
                    <input class="form-check-input" type="radio" id="ruolo5" name="ruolo" value="amministratore">
                    @endif
                    <label class="form-check-label">
                        Amministratore
                    </label>
                </div>
            </div>
        </div>


    </div>
</div>
<br/>
@endif

@if ($ruolo == "Impiegato")
<div class="card bg-light">
  <div class="card-header"><p class="h6">Dati Anagrafici</p></div>
  <div class="card-body">
    <!--<h5 class="card-title">Dati anagrafici</h5>-->
    <p class="card-text"><b>Sesso: </b><?php if($datiUtente->sesso == '1') echo 'Uomo'; else echo 'Donna';?></p>
    <p class="card-text"><b>Data di Nascita: </b>{{ $datiUtente->dataNascita }}</p>
    <p class="card-text"><b>Codice Fiscale: </b>{{ $datiUtente->codiceFiscale }}</p>
    <p class="card-text"><b>Residenza Via: </b>{{ $datiUtente->via }} <b>Civico: </b>{{ $datiUtente->numeroCivico }}</p>
    <p class="card-text"><b>Città: </b>{{ $datiUtente->comune }} <b>Provincia: </b>{{ $datiUtente->provincia }} <b>Stato: </b>{{ $datiUtente->stato }}</p>
    <p class="card-text"><b>Email: </b>{{ $datiUtente->email }}</p>
    <p class="card-text"><b>Telefono: </b>{{ $datiUtente->telefono }}</p>
    <p class="card-text"><b>Ruolo: </b>{{$ruoloStaff}}</p>
    <p class="card-text"><b>Identificativo: </b>{{ $datiStaff->identificativo }}</p>
  </div>
</div>
<br/>
@endif

<div class="card bg-light">
    <div class="card-header">
    <p class="h6">Dati incarico</p>
    </div>
    
    <div class="card-body">
        
        <div class="form-group row col-sm-10">
            <label for="identificativoReparto" class="col-sm-6 col-form-label">Nome Reparto</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="identificativoReparto" name="identificativoReparto" value="{{ $reparto->nome }}">
            </div>
        </div>

        <div class="form-group row col-sm-10">
            <label for="identificativoPersonale" class="col-sm-6 col-form-label">Identificativo Personale</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="identificativoPersonale" name="identificativoPersonale" value="{{ $datiStaff->identificativo }}">
            </div>
        </div>
    
        <div class="form-group row col-sm-10">
            <label for="stipendio" class="col-sm-6 col-form-label">Stipendio</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stipendio" name="stipendio" value="{{ $datiStaff->stipendio }}">
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
                <p>Stai aggiornando i dati del membro dello staff.</p>
                <p>Premi su <b>Conferma</b> per applicare le modifiche.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Conferma</button>
            </div>
            </div>
        </div>
    </div>
</div>
<br/>
<a type="button" class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-edit" style="color:white"></i> Aggiorna</a>
<a type="button" class="btn btn-secondary" href="/elencoStaff"></i>Annulla</a>
</form> 
<br/>
<br/>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script charset="utf-8" type="text/javascript" src="{{asset('/js/staff.js')}}" ></script>
@endsection