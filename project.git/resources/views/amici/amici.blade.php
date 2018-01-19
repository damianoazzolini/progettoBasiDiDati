@extends('layouts.master')

@section('content')
<div class="contentAmici">
    <h2> Gestisci amicizie </h2>
    <div class="searchContainer">
        <div class="searchBox">
            <form action="/amici/ricerca" method="GET">
                {{ csrf_field() }}
                Ricerca tra gli amici <br>
                <input type="text" name="search" class="testo amicizia"><br>
                <input type="hidden" name="type" value="amici">
                <input type="submit" value="Cerca" class="bottone">
            </form>
        </div>
        <div class="searchBox">
            <form action="/amici/ricerca" method="GET">
                {{ csrf_field() }}
                Ricerca tra gli utenti di Harambe <br>
                <input type="text" name="search" class="testo amicizia"><br>
                <input type="hidden" name="type" value="tutti">
                <input type="submit" value="Cerca" class="bottone">
            </form>
        </div>
    </div>
    <?php foreach ($utenti as $utente){ ?>
        <div class = "friendBox">
            <img src= {{$utente->immagine}} class="userImage amicizia"/>
            <div class="userName amicizia">
                <a href="/profilo/id?utenteID={{$utente->utenteID}}">{{$utente->nome}} {{$utente->cognome}}</a>
            </div>
            <div>
                <div id="div-friendBox-button{{$utente->utenteID}}">
                    <?php if($utente->stato == 'richiedi'){ ?>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia nuova" id="button-nuova{{$utente->utenteID}}">Aggiungi agli amici</button>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia blocca" id="button-blocca{{$utente->utenteID}}">Blocca utente</button>
                    <?php } ?>
                    <?php if ($utente->stato == 'annulla') { ?>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia elimina" id="button-elimina{{$utente->utenteID}}">Annulla richiesta</button>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia blocca" id="button-blocca{{$utente->utenteID}}">Blocca utente</button>
                    <?php } ?>
                    <?php if ($utente->stato == 'accetta') { ?>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia accetta" id="button-accetta{{$utente->utenteID}}">Accetta amicizia</button>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia blocca" id="button-blocca{{$utente->utenteID}}">Blocca utente</button>
                    <?php } ?>
                    <?php if($utente->stato == 'rimuovi'){ ?>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia elimina" id="button-elimina{{$utente->utenteID}}">Elimina amicizia</button>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia blocca" id="button-blocca{{$utente->utenteID}}">Blocca utente</button>
                    <?php } ?>
                    <?php if($utente->stato == 'sblocca'){ ?>
                        <button value="{{$utente->utenteID}}" class="bottone amicizia elimina" id="button-elimina{{$utente->utenteID}}">Sblocca utente</button>
                    <?php } ?>
                </div>
                <div id="div-friendBox-message{{$utente->utenteID}}" class="message">
                </div>
            </div>
        </div>
    <?php } ?> 
    <?php if ($empty) { ?>
    <div class="testoErrore"> {{$messaggio}} </div>
    <?php } ?>
    <?php echo $utenti->appends(Input::except('page'))->render() ?>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script charset="utf-8" type="text/javascript" src="{{asset('/js/amicizia.js')}}" ></script>
@endsection