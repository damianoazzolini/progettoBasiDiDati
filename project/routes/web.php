<?php

/* Profili */
Route::get('/profilo', 'ProfiloController@index');
Route::get('/welcome', function () {
    return view('welcome');
});
Route::post('/profilo','ProfiloController@store')->middleware('revalidate');
Route::get('/profilo/id','ProfiloController@index')->middleware('revalidate');
Route::get('/profilo/media/id','ProfiloController@media')->middleware('revalidate');
Route::post('/profilo/storeImage','ProfiloController@storeImage');

/* Pagine */
Route::get('/pagina/id','PaginaController@index');
Route::post('/pagina/id','PaginaController@store');
Route::post('/pagina','PaginaController@display');
Route::post('/pagina/create','PaginaController@create');

/* Login + registrazione */
Route::get('/', 'CreateController@index')->middleware('guest');
Route::post('/','CreateController@login')->middleware('guest');
Route::get('/sviluppatori', 'CreateController@developers');
Route::get('/registrazione', 'CreateController@create');
Route::post('/registrazione', 'CreateController@store');
Route::get('/registrazione/conferma', function () {
    return view('accesso.confermaRegistrazione');
});
Route::post('/registrazione/conferma', 'CreateController@confirm');
Route::get('/recuperaPassword', function () {
    return view('accesso.recuperaPassword');
});
Route::post('/recuperaPassword', 'CreateController@recoversPassword');
Route::get('/recuperaPassword/cambiaPassoword', function () {
    return view('accesso.cambiaPassword');
});
Route::post('/recuperaPassword/cambiaPassword', 'CreateController@changePassword');


/* Richieste di amicizia e Notifiche */
Route::get('/richieste_amicizia', 'RichiesteamiciziaController@index')->middleware('revalidate');
Route::post('/richieste_amicizia', 'RichiesteamiciziaController@store')->middleware('revalidate');
Route::get('/notifiche', 'NotificheController@index')->middleware('revalidate');
Route::post('/notifiche', 'NotificheController@loadData')->middleware('revalidate');

/* Home */
Route::get('/home', 'HomeController@create')->middleware('revalidate');
Route::get('/home', 'HomeController@show')->middleware('revalidate');
Route::post('/home', 'HomeController@post')->middleware('revalidate');
Route::post('/logout', 'HomeController@logout')->middleware('revalidate');

/* Amicizia*/
Route::get('/amici', 'AmiciziaController@index')->middleware('revalidate');
Route::get('/amici/button', 'AmiciziaController@button')->middleware('revalidate');
Route::get('/amici/nuova', 'AmiciziaController@nuova')->middleware('revalidate');
Route::get('/amici/blocca/', 'AmiciziaController@blocca')->middleware('revalidate');
Route::get('/amici/accetta/', 'AmiciziaController@accetta')->middleware('revalidate');
Route::get('/amici/cancella/', 'AmiciziaController@cancella')->middleware('revalidate');
Route::get('/amici/ricerca', 'AmiciziaController@ricerca')->middleware('revalidate');

/* Post*/
Route::get('/posts/{id}', 'PostController@show');
Route::post('/posts/', 'PostController@store');


/* Chat */
Route::get('/chat', 'ChatController@show')->middleware('revalidate');
Route::post('/chat', 'ChatController@post')->middleware('revalidate');
