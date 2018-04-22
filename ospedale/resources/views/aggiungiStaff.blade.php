@extends('layouts.sidebar')
@section('content')
<h4>Inserimento nuovo membro dello staff</h4>
<br/>
<form method="post">
    <div class="card bg-light">
      <div class="card-header">
        <p class="h6">Dati Anagrafici</p>
      </div>
      <div class="card-body">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-row">
          <div class="form-group row col-md-6">
              <label for="nome" class="col-sm-2 col-form-label">Nome</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="nome" name="nome">
              </div>
          </div>
          <div class="form-group row col-md-6">
              <label for="cognome" class="col-sm-2 col-form-label">Cognome</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="cognome" name="cognome">
              </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group row col-md-6">
              <label for="dataNascita" class="col-sm-2 col-form-label">Data di nascita</label>
              <div class="col-sm-10">
              <input type="date" class="form-control" id="dataNascita" name="dataNascita">
              </div>
          </div>
          <div class="form-group row col-md-6">
              <label class="col-sm-2 col-form-label">Sesso</label>
              <div class="col-sm-10">
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineRadio1" name="sesso" value="uomo">
                      <label class="form-check-label" for="inlineRadio1">Uomo</label>
                  </div>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="inlineRadio2" name="sesso" value="donna">
                      <label class="form-check-label" for="inlineRadio2">Donna</label>
                  </div>
              </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group row col-md-6">
              <label for="codiceFiscale" class="col-sm-2 col-form-label">Codice Fiscale</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="codiceFiscale" name="codiceFiscale">
              </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group row col-md-6">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
              <input type="email" class="form-control" id="email" name="email">
              </div>
          </div>
          <div class="form-group row col-md-6">
              <label for="telefono" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
              <input type="password" class="form-control" id="password" name="password">
              </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group row col-md-6">
              <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="telefono" name="telefono">
              </div>
          </div>
        </div>
        <div class="form-row">
            <div class="form-group row col-md-6">
                <label for="via" class="col-sm-2 col-form-label">Via</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="via" name="via">
                </div>
            </div>
            <div class="form-group row col-md-6">
                <label for="civico" class="col-sm-2 col-form-label">Civico</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="civico" name="civico">
                </div>
            </div>
        </div>
        <div class="form-row">

            <div class="form-group row col-md-6">
                    <label for="comune" class="col-sm-2 col-form-label">Comune</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="comune" name="comune">
                    </div>
            </div>    
        </div>
        <div class="form-row">
            <div class="form-group row col-md-6">
              <label for="provincia" class="col-sm-2 col-form-label">Provincia</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="provincia" name="provincia">
              </div>
            </div>
            <div class="form-group row col-md-6">
                <label for="stato" class="col-sm-2 col-form-label">Stato</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="stato" name="stato">
                </div>
            </div>
        </div>
      </div>
    </div>
    <br/>
    <div class="card bg-light">
      <div class="card-header">
        <p class="h6">Dati incarico</p>
      </div>
      <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Ruolo</label>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="ruolo2" name="ruolo" value="medico">
                    <label class="form-check-label">
                        Medico
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="ruolo3" name="ruolo" value="infermiere">
                    <label class="form-check-label">
                        Infermiere
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="ruolo4" name="ruolo" value="impiegato">
                    <label class="form-check-label">
                        Impiegato
                    </label>
                </div>
                @if($ruolo == "Amministratore")
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="ruolo5" name="ruolo" value="amministratore">
                        <label class="form-check-label">
                            Amministratore
                        </label>
                    </div>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group row col-md-6">
                <label for="identificativoReparto" class="col-sm-2 col-form-label">Identificativo Reparto</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="identificativoReparto" name="identificativoReparto">
                </div>
            </div>
            <div class="form-group row col-md-6">
                <label for="identificativoPersonale" class="col-sm-2 col-form-label">Identificativo Personale</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="identificativoPersonale" name="identificativoPersonale">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group row col-md-6">
                <label for="stipendio" class="col-sm-2 col-form-label">Stipendio</label>
                <div class="col-sm-10">
                <input type="number" class="form-control" id="stipendio" name="stipendio">
                </div>
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
                <p>Stai creando un nuovo membro dello staff.</p>
                <p>Premi su <b>Conferma</b> per procedere.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Conferma</button>
            </div>
            </div>
        </div>
    </div>
    <br/>
    <a type="button" class="btn btn-primary" style="color:white" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-plus" style="color:white"></i> Inserisci</a>
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