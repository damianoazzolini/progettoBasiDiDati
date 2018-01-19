<html>
    <head>
        <title>Benvenuto su Harambe</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="/js/ads.js"></script>
        <script charset="utf-8" type="text/javascript" src="{{asset('/js/login.js')}}" ></script>

        <script>
            function adBlockAction() {
                //alert("Disinstalla adblock!");
            }
        </script>

        <link rel="shortcut icon" href="{{ asset('/systemImages/favicon.ico') }}"/>
        <link type="text/css" rel="stylesheet" href="{{asset('/css/login.css')}}"/>
    </head>
    <body>
        <script>
            if( window.canRunAds === undefined ){
                adBlockAction();
            }
        </script>

        <div class="headerLogin">
            <div id="headerLeft">
                <div id="headerLogo"><img src="{{ asset('/systemImages/logo.png') }}"/></div>
            </div>

            <div id="headerRight">
                <form id="formLogin" action="/" method="POST">
                {{ csrf_field() }}
                    <div id="headerInputs">
                        <div class="loginField">Email:<br><input id="inputEmail" type="text" name="email"/>
                        	<div class="hiddenField" id="errorEmail"><b>Email non valida.</b></div>
                        </div>
                        <div class="loginField">Password:<br><input id="inputPassword" type="password" name="password"/>
                        	<div class="hiddenField" id="errorPassword"><b>Password troppo corta.</b></div>
                        </div>

                        <div class="loginField">
                            <br> Ricordami <input type="checkbox" style="margin-top:5px;" name="remember" value="true" checked>     
                        </div>

                        <div class="loginField">
                            <input type="submit" style="margin-top:15px;" value = "Accedi">
                        </div>
                    </div>
                </form> 

                <div id="headerInputs">
                    <div class="sottoMenu">
                        <div id="missing">
                            <a href="recuperaPassword"> Hai dimenticato la password?</a>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
        <div class="contentLogin">
            <div id="contentLoginLeft"><img src="{{ asset('/systemImages/harambe.png') }}"/></div>
            <div id="contentLoginRight">          
                <!--Stato registrazione -->		
                @if(session('status'))
                <div class="alert alert-success">
                    <h2>Complimenti!</h2>
                    Validazione avvenuta con successo.<br>
                    Inserisci le credenziali per accedere al sito.
                </div>
                @elseif(session('registration'))
                <h2>Complimenti!</h2>
                Per completare la registrazione clicka il link all'email che ti abbiamo appena mandato!
                
                @elseif(session('mailnotfound'))
                <h2>Email non trovata</h2>
                Email inserita non esistente. Si prega di riprovare     
                
                @elseif(session('recover'))
                <h2>Cambio password in corso!</h2>
                Ti abbiamo inviato una email all'indizzo inserito per il recupero password..
                
                
                @elseif(session('changepass'))
                <h2>Procedura di cambio password avvenuta con successo!</h2>
                La password è stata cambiata con successo!!
                
                @else
                <h2>Iscriviti</h2>
                <p>
                    Entra a far parte della comunity di <b>harambe</b>.<br>
                    Crea un account o accedi!
                </p>
                <p>Connettiti con amici, familiari e altre persone che conosci. Condivi post, scrivi commenti e invia messaggi.</p>
                
                <a href="registrazione"><div id="buttonRegistration"><b>Registrati</b></div></a>
                @endif
                
                <p>
                    {{ session('message') }}
                </p>
                
                @if($errors->any())
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                @endif

                <p id="adDetected"> <p>
            </div>
        </div>

        <div class="footerLogin">
            <div id="contentFooterLogin">
                <a href="sviluppatori"><div class="footerDivs">Sviluppatori</div></a>
                <div class="footerDivs">Progetto di Sistemi Web - AA 2017/2018</div>
                <div class="footerDivs">Harambe 2017</div>
            </div>
        </div>
    </body>
</html>