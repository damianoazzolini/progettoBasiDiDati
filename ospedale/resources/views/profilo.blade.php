@extends('layouts.sidebar')

@section('content')
<h1> PROFILO </h1>

{{--
Mostro le info come form così se voglio modificare i dati 
posso fare semplicemente submit
--}}

@foreach($info as $inf)
<form method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    Nome:<br>
    <input type="text" name="nome" value="{{$inf->nome}}"><br>
    Cognome:<br>
    <input type="text" name="cognome" value="{{$inf->cognome}}"><br>
    Data di nascita:<br>
    <input type="date" name="dataNascita" value="{{$inf->dataNascita}}"><br>
    Sesso:<br>
    <input type="radio" name="sesso" value="uomo" {{$inf->sesso == '1' ? 'checked' : ''}}> Uomo<br>
    <input type="radio" name="sesso" value="donna" {{$inf->sesso == '0' ? 'checked' : ''}}> Donna<br>
    Codce fiscale:<br>
    <input type="text" name="codiceFiscale" value="{{$inf->codiceFiscale}}"><br>
    Email:<br>
    <input type="email" name="email" value="{{$inf->email}}"><br>
    Telefono:<br>
    <input type="text" name="telefono" value="{{$inf->telefono}}"><br>
    Provincia:<br>
    <input type="text" name="provincia" value="{{$inf->provincia}}"><br>
    Stato:<br>
    <input type="text" name="stato" value="{{$inf->stato}}"><br>
    Comune:<br>
    <input type="text" name="comune" value="{{$inf->comune}}"><br>
    Via:<br>
    <input type="text" name="via" value="{{$inf->via}}"><br>
    Numero Civico:<br>
    <input type="text" name="civico" value="{{$inf->numeroCivico}}"><br>
    Ruolo:<br>
    <input type="checkbox" {{ $ruolo == 'Paziente' ? 'checked' : ''}} name="ruolo_paziente" disabled>Paziente<br>
    <input type="checkbox" {{ $ruolo == 'Medico' ? 'checked' : ''}} name="ruolo_medico" disabled>Medico<br>
    <input type="checkbox" {{ $ruolo == 'Infermiere' ? 'checked' : ''}} name="ruolo_nfermiere" disabled>Infermiere<br>
    <input type="checkbox" {{ $ruolo == 'Impiegato' ? 'checked' : ''}} name="ruolo_impiegato" disabled>Impiegato<br>
    <input type="checkbox" {{ $ruolo == 'Amministratore' ? 'checked' : ''}} name="ruolo_amministratore" disabled>Amministratore<br>

    <input type="submit" value="Submit">
</form> 
@endforeach

{{ print_r($info) }}


@endsection

{{--

id             | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| nome           | varchar(255)     | NO   |     | NULL    |                |
| cognome        | varchar(255)     | NO   |     | NULL    |                |
| dataNascita    | date             | NO   |     | NULL    |                |
| sesso          | tinyint(1)       | NO   |     | NULL    |                |
| codiceFiscale  | varchar(255)     | NO   | UNI | NULL    |                |
| email          | varchar(255)     | NO   | UNI | NULL    |                |
| password       | varchar(255)     | NO   |     | NULL    |                |
| telefono       | varchar(255)     | NO   |     | NULL    |                |
| attivo         | tinyint(1)       | NO   |     | NULL    |                |
| provincia      | varchar(255)     | NO   |     | NULL    |                |
| stato          | varchar(255)     | NO   |     | NULL    |                |
| comune         | varchar(255)     | NO   |     | NULL    |                |
| via            | varchar(255)     | NO   |     | NULL    |                |
| numeroCivico   | int(11)          | NO   |     | NULL    |                |
| created_at     | timestamp        | YES  |     | NULL    |                |
| updated_at     | timestamp        | YES  |     | NULL    |                |
| remember_token | text             | YES  |     | NULL    |             

 --}}