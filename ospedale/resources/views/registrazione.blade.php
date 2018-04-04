<html>
<body>

<h1> FORM REGISTRAZIONE </h1>

<form method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
    Nome:<br>
    <input type="text" name="nome" value="Nome"><br>
    Cognome:<br>
    <input type="text" name="cognome" value="Cognome"><br>
    Data di nascita:<br>
    <input type="date" name="dataNascita"><br>
    Sesso:<br>
    <input type="radio" name="sesso" value="uomo" checked> Uomo<br>
    <input type="radio" name="sesso" value="donna"> Donna<br>
    Codce fiscale:<br>
    <input type="text" name="codiceFiscale" value="C.F."><br>
    Email:<br>
    <input type="email" name="email"><br>
    Password:<br>
    <input type="password" name="password" value="Password"><br>
    Telefono:<br>
    <input type="text" name="telefono" value="Telefono"><br>
    Provincia:<br>
    <input type="text" name="provincia" value="Provincia"><br>
    Stato:<br>
    <input type="text" name="stato" value="Stato"><br>
    Comune:<br>
    <input type="text" name="comune" value="Comune"><br>
    Via:<br>
    <input type="text" name="via" value="Via"><br>
    Numero Civico:<br>
    <input type="text" name="civico" value="Civico"><br>
    Ruolo:<br>
    <input type="radio" name="ruolo" value="paziente" checked> Paziente<br>
    <input type="radio" name="ruolo" value="medico"> Medico<br>
    <input type="radio" name="ruolo" value="infermiere"> Infermiere<br>
    <input type="radio" name="ruolo" value="impiegato"> Impiegato<br>
    <input type="radio" name="ruolo" value="amministratore" > Amministratore<br>

    <input type="submit" value="Submit">
</form> 

</body>
</html>
