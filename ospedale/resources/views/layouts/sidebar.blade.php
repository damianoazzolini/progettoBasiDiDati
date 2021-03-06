<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myHospital</title>

    <!-- Bootstrap core CSS -->
    <link type="text/css" rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">

    <!-- Custom styles for this template -->
    <link type="text/css" rel="stylesheet" href="{{asset('/css/dashboard.css')}}">  
</head>

<!-- Definisco la larghezza massima della sidebar -->
<style>
.col-md-2{
max-width: 200px;
}

hr.style1{
    height: 1px;
    background-color:#555;
    margin-top: 10px;
    margin-bottom: 10px;
    width: 90%;
}
</style>

<body>
    </br>
    </br>
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
            <img class="img-fluid" src="{{ asset('/images/logo.png') }}" alt="" width="210" height="140">
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/dashboard">
            <i class="fas fa-home"></i>
                Home
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/profilo">
                <i class="fas fa-user"></i>                
                Profilo
            </a>
            </li>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ url('/logout') }}">
                <i class="fas fa-sign-out-alt"></i>                
                Logout
            </a>
            </li>
            <hr class="style1">
            <li class="nav-item">
            <a class="nav-link" href="/elencoPrestazioni">
                <i class="fas fa-notes-medical"></i>                
                Prestazioni
            </a>
            </li>

            @if($ruolo == "Paziente")
                <li class="nav-item">
                <a class="nav-link" href="/myfarmaci">
                    <i class="fas fa-pills"></i> 
                    Farmaci assunti
                </a>
            @endif
            </li>
            @if($ruolo == "Impiegato" || $ruolo == "Amministratore")
                <li class="nav-item">
                <a class="nav-link" href="/farmacia">
                    <i class="fas fa-flask"></i> 
                    Farmacia
                </a>
                </li>
            @endif

            @if($ruolo == "Medico" || $ruolo == "Impiegato" || $ruolo == "Infermiere" || $ruolo == "Amministratore")
                <li class="nav-item">
                <a class="nav-link" href="/elencoPazienti">
                    <i class="fas fa-bed"></i> 
                    Pazienti
                </a>
                </li>
            @endif

            @if($ruolo == "Amministratore" || $ruolo == "Impiegato")
                <li class="nav-item">
                <a class="nav-link" href="/elencoStaff">
                    <i class="fas fa-user-md"></i> 
                    Staff
                </a>
                </li>
            @endif

            @if($ruolo == "Amministratore")            
                <li class="nav-item">
                <a class="nav-link" href="/reparti">
                    <i class="fas fa-hospital"></i> 
                    Reparti
                </a>
                </li>
            @endif

            @if($ruolo == "Amministratore")            
                <li class="nav-item">
                <a class="nav-link" href="/sale">
                    <i class="fas fa-tags"></i> 
                    Sale
                </a>
                </li>
            @endif
        
        </ul>
        </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4"><div style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
        @yield('content')
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script charset="utf-8" type="text/javascript" src="{{asset('/js/jquery-3.js')}}" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script charset="utf-8" type="text/javascript" src="{{asset('/js/popper.js')}}"></script>
    <script charset="utf-8" type="text/javascript" src="{{asset('/js/bootstrap.js')}}"></script>
    @yield('scripts')

    <!-- Icons -->
    <script charset="utf-8" type="text/javascript" src="{{asset('/js/fontawesome-all.js')}}"></script>

</body>
</html>