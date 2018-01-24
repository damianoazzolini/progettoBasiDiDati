@extends('layouts.master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script charset="utf-8" type="text/javascript" src="{{asset('/js/registration.js')}}" ></script>
<link rel="shortcut icon" href="{{ asset('/systemImages/favicon.ico') }}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/registration.css')}}"/>


@section ('content')                
<div class="contentRegistrationDevelopers">
    <div id="formContentRegistration">
        <h1>Crea Pagina</h1>

        <ul>
        @foreach ($errors->all() as $error)
            <li>
            {{ $error }}
            </li>
        @endforeach
        </ul>
        
        <form id="formRegistration" action="registraPagina" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset style="text-align: left;">
                <legend>Inserisci i tuoi dati:</legend><br>
                <div id="formContainerRegistrationLeft">
                    Nome:<br>
                    <input id="inputName" type="text" name="nome"><br>
                    <div class="hiddenField" id="errorName">Il nome deve essere maggiore di 3 caratteri.</div>
                    <br>
                    Descrizione:<br>
                    <input id="descrizione" type="text" name="descrizione" cols="40" rows="5"><br>
                    <br>
                    Tipo:<br>
                    <input id="tipo" type="text" name="tipo"><br>

                    <input type="hidden" nome="utenteID" value="{{ Auth::id() }}">
                </div>
                
                <div id="formContainerRegistrationRight">
                    Carica un'immagine per la pagina:<br>
                    <div id="divUpload">
                        <div id="close"></div>
                        <input id="inputImage" type="file" name="image"/>
                    </div>
                </div>	
            </fieldset>
            <br>
            <input type="submit" value="Crea Pagina">
        </form>
    </div>
</div>

@endsection