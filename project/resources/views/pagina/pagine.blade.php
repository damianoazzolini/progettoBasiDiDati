@extends('layouts.master')

@section('content')
<div class="contentPages">
    <h2> Gestisci pagine </h2>
    <div class="searchContainer">
        <div class="searchBox">
            <form action="/pagine/ricerca" method="GET">
                {{ csrf_field() }}
                Cerca tra le pagine che segui <br>
                <input type="text" name="search" class="testo pagine"><br>
                <input type="hidden" name="type" value="seguite">
                <input type="submit" value="Cerca" class="bottone">
            </form>
        </div>
        <div class="searchBox">
            <form action="/pagine/ricerca" method="GET">
                {{ csrf_field() }}
                Ricerca tra tutte le pagine di Harambe <br>
                <input type="text" name="search" class="testo pagine"><br>
                <input type="hidden" name="type" value="tutte">
                <input type="submit" value="Cerca" class="bottone">
            </form>
        </div>
    </div>
    <?php foreach ($pagine as $pagina){ ?>
        <div class = "pagesBox">
            <img src= {{$pagina->immagine}} class="pageImage"/>
            <div class="pageName">
                <a href="/pagina/id?paginaID={{$pagina->paginaID}}">{{$pagina->nome}}</a>
                <p class="description">{{$pagina->tipo}}</p>
            </div>
            <div>
                <div id="div-pagesBox-button{{$pagina->paginaID}}">
                    <?php if($pagina->stato == null){ ?>
                        <button value="{{$pagina->paginaID}}" class="bottone pagina nuova" id="button-nuova{{$pagina->paginaID}}">Segui</button>
                    <?php } ?>
                    <?php if($pagina->stato == 'segue'){ ?>
                        <button value="{{$pagina->paginaID}}" class="bottone pagina elimina" id="button-elimina{{$pagina->paginaID}}">Non seguire</button>
                    <?php } ?>
                    <?php if($pagina->stato == 'amministra'){ ?>
                        <p> Amministratore </p>
                    <?php } ?>
                </div>
                <div id="div-pagesBox-message{{$pagina->paginaID}}" class="message">
                </div>
            </div>
        </div>
    <?php } ?> 
    <?php if ($empty) { ?>
    <div class="testoErrore"> {{$messaggio}} </div>
    <?php } ?>
    <?php echo $pagine->appends(Input::except('page'))->render() ?>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script charset="utf-8" type="text/javascript" src="{{asset('/js/pagine.js')}}" ></script>
@endsection