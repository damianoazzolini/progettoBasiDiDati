<html>
<body>

<div>
Gli utenti creati sono: <br>
Paziente, paziente@paziente.com, password<br>
Utente, utente@utente.com, password<br>
Infermiere, infermiere@infermiere.com, password<br>
Impiegato, impiegato@impiegato.com, password<br>
Amministratore, amministratore@amministratore.com, password<br>
</div>

<form method="post">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
    Email:<br>
    <input type="text" name="email" value="amministratore@amministratore.com"><br>
    Password (già password di default):<br>
    <input type="password" name="password" value="password"><br><br>
    <input type="submit" value="Submit">
</form> 

</body>
</html>