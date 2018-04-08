<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();
Route::get('/', 'LoginController@showLogin');
Route::post('/','LoginController@login');
Route::get('/logout', 'LoginController@logout');
Route::get('/registrazione', 'LoginController@showRegistrazione');
Route::post('/registrazione', 'LoginController@store');
Route::get('/profilo','DashboardController@showProfilo');
Route::get('/myfarmaco','FarmacoController@show');

Route::get('/dashboard', [
    'uses' => 'DashboardController@show'//,
    //'middleware' => 'roles',
    //'roles' => ['Paziente','Medico','Infermiere','Impiegato','Amministratore']
]); //in roles specifico i ruoli che possono accedere ad una determinata risorsa
Route::post('/dashboard', [
    'uses' => 'DashboardController@assegnaRuolo'//,
    //'middleware' => 'roles',
    //'roles' => ['Amministratore']
]);
Route::get('/elencoPazienti', 'PazienteController@index');