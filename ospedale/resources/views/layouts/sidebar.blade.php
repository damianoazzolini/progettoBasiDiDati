<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    font-family: "Lato", sans-serif;
}

.sidenav {
    height: 100%;
    width: 200px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    padding-top: 20px;
}

.sidenav a {
    padding: 6px 6px 6px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
}

.sidenav a:hover {
    color: #f1f1f1;
}

.main {
    margin-left: 200px; /* Same as the width of the sidenav */
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</head>
<body>

<div class="sidenav">
    <a href="/profilo">Profilo</a> <!-- paziente, medico, infermiere, impiegato -->
    <a href="/prestazioni">Prestazioni</a> <!-- paziente, medico, infermiere -->
    <a href="/myfarmaco">My Farmaco</a> <!-- paziente -->
    <a href="/registrazione">Registra nuovo paziente</a> <!-- medico, impiegato -->
    <a href="/cercaPaziente">Ricerca Paziente</a> <!-- medico, infermiere -->
    @if($ruolo != "Amministratore")
        <a href="/reparti">Reparti</a>
    @else
        <a href="/reparti">Non visibile all'admin</a>
    @endif

    @if($ruolo == "Amministratore")
        <a href="/reparti">Visibile solo all'admin</a>
    @endif
    
    <a href="/sala">Sale</a>
    <a href="/prenotaPrestazione">Prenota prestazione</a> <!-- impiegato -->
    <a href="/ricercaPrestazione">Ricerca prestazione</a> <!-- impiegato -->
    <a href="/gestionePersonale">Gestione personale</a> <!-- impiegato -->
    <a href="/farmacia">Farmacia</a> <!-- impiegato -->
    <a href="{{ url('/logout') }}"> Logout </a>
</div>

<div class="main">
    <h2>Sidenav Example</h2>
    <p>Ruolo: {{ $ruolo }}</p>
</div>
     
</body>
</html> 