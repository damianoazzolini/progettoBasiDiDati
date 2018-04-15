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

Route::get('/profilo','ProfiloController@show');
Route::get('/modificaProfilo/{id}', 'ProfiloController@edit');
Route::post('/modificaProfilo/{id}','ProfiloController@update');

Route::get('/elencoPrestazioni','PrestazioneController@index');
Route::post('/elencoPrestazioni','PrestazioneController@ricerca');
Route::get('/mostraPrestazione/{id}','PrestazioneController@show');
Route::get('/modificaPrestazione/{id}', 'PrestazioneController@edit');
Route::post('/modificaPrestazione/{id}', 'PrestazioneController@update');
Route::get('/cancellaPrestazione/{id}', 'PrestazioneController@destroy');
Route::get('/aggiungiPrestazione', 'PrestazioneController@create');
Route::post('/aggiungiPrestazione', 'PrestazioneController@store');

Route::get('/modificaStaffPrestazione/{id}','PrestazioneController@showModificaStaff');
Route::post('/modificaStaffPrestazione/{id}','PrestazioneController@addStaffPrestazione');
Route::post('/deleteStaffPrestazione','PrestazioneController@deleteStaffPrestazione');

Route::get('/modificaFarmacoPrestazione/{id}','PrestazioneController@showModificaFarmaci');
Route::post('/modificaFarmacoPrestazione/{id}','PrestazioneController@addFarmacoPrestazione');
Route::post('/deleteFarmacoPrestazione','PrestazioneController@deleteFarmacoPrestazione');

Route::get('/effettuaPrestazione/{id}','PrestazioneController@effettuaPrestazione');
Route::get('/prestazioniReparto/ajax', 'PrestazioneController@repartoAutocomplete');
Route::get('/prestazioniSala/ajax', 'PrestazioneController@salaAutocomplete');
//Route::get('/prestazioniCodiceFiscale/ajax', 'PrestazioneController@cfAutocomplete');

//Route::get('/myfarmaco','FarmacoController@show');

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
Route::post('/elencoPazienti', 'PazienteController@ricerca');
Route::get('/mostraPaziente/{id}', 'PazienteController@show');
Route::get('/modificaPaziente/{id}', 'PazienteController@edit');
Route::post('/modificaPaziente/{id}', 'PazienteController@update');
Route::get('/cancellaPaziente/{id}', 'PazienteController@destroy');
Route::get('/aggiungiPaziente', 'PazienteController@create');
Route::post('/aggiungiPaziente', 'PazienteController@store');
Route::get('/farmacia', 'FarmacoController@index');
Route::post('/farmacia', 'FarmacoController@ricerca');
Route::get('/mostraFarmaco/{id}', 'FarmacoController@show');
Route::get('/modificaFarmaco/{id}', 'FarmacoController@edit');
Route::post('/modificaFarmaco/{id}', 'FarmacoController@update');
Route::get('/cancellaFarmaco/{id}', 'FarmacoController@destroy');
Route::get('/aggiungiFarmaco', 'FarmacoController@create');
Route::post('/aggiungiFarmaco', 'FarmacoController@store');
Route::get('/reparti', 'RepartoController@index');
Route::post('/reparti', 'RepartoController@ricerca');
Route::get('/mostraReparto/{id}', 'RepartoController@show');
Route::get('/modificaReparto/{id}', 'RepartoController@edit');
Route::post('/modificaReparto/{id}', 'RepartoController@update');
Route::get('/cancellaReparto/{id}', 'RepartoController@destroy');
Route::get('/aggiungiReparto', 'RepartoController@create');
Route::post('/aggiungiReparto', 'RepartoController@store');
Route::get('/sale', 'SalaController@index');
Route::post('/sale', 'SalaController@ricerca');
Route::get('/sale/ajax', 'SalaController@repartoAutocomplete');
Route::get('/mostraSala/{id}', 'SalaController@show');
Route::get('/modificaSala/{id}', 'SalaController@edit');
Route::post('/modificaSala/{id}', 'SalaController@update');
Route::get('/cancellaSala/{id}', 'SalaController@destroy');
Route::get('/aggiungiSala', 'SalaController@create');
Route::post('/aggiungiSala', 'SalaController@store');
Route::get('/myfarmaci', 'FarmacoPrestazioneController@index');
Route::post('/myfarmaci', 'FarmacoPrestazioneController@ricerca');
Route::get('/cancellaMyFarmaco/{id}', 'FarmacoPrestazioneController@destroy');
Route::get('/aggiungiMyFarmaco', 'FarmacoPrestazioneController@create');
Route::post('/aggiungiMyFarmaco', 'FarmacoPrestazioneController@store');
Route::get('/myfarmaci/ajaxCategoria', 'FarmacoPrestazioneController@categoriaAutocomplete');
Route::get('/myfarmaci/ajaxNome', 'FarmacoPrestazioneController@nomeAutocomplete');