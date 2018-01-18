@extends('layouts.master')

<p id="nomePagina"> NOME {{$nome}} </p> 
<p id="immaginePagina"> IMMAGINE {{$immagine}} </p>
<p id="descrizionePagina"> DESCRIZIONE {{$descrizione}} </p>

<form action="#" method="POST" id="formPostPagina">
    {{ csrf_field() }}
    <textarea id='postTextarea' name="post" cols="40" rows="5" spellcheck="false" placeholder="Pubblica qualcosa"></textarea>
    <input type="file" name="image">
    <input type="hidden" name="control" value="1"> 
    <button type="button" id="postButton"><b>Post</b></button>
</form>

<p id="elencoPostPagina"> 

@foreach ($post as $pubblicato)

@endforeach  

</p>

<p><a href="#"> Amministratori </a></p>
<p><a href="#"> Utenti </a></p>
<p><a href="#"> Abbandona </a></p>

