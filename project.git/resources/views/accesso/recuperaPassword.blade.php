<html>
    <head>
        <title>Recupera password</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script charset="utf-8" type="text/javascript" src="{{asset('/js/registration.js')}}" ></script>
        <link rel="shortcut icon" href="{{ asset('/systemImages/favicon.ico') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/css/registration.css') }}"/>
    </head>
    <body>        
        <div class="headerRegistrationDevelopers">
            <div id="headerLogo"><a href="/"><img src="{{ asset('/systemImages/logo.png') }}"/></a></div>
        </div>
        
        <div class="contentRegistrationDevelopers">
            <div id="formContentRegistration">
                <h1>Procedura di recupero password</h1>
				Inserisci l'indirizzo email del tuo accout
                
                <form id="formConfirm" action="/recuperaPassword" method="POST">
                    {{ csrf_field() }}
                     Email:<br>
                            <input id="inputEmail" type="text" name="email"><br>
                            <div class="hiddenField" id="errorEmail">Email non valida.</div>
                            <br>   
                            @foreach ($errors->all() as $error)
                            <li>
                            {{ $error }}
                            </li>
                            @endforeach
                            <input type="submit" value="Conferma email">
                </form>
                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
            </div>
        </div>
            
        <div class="footerRegistration">
        </div>
        
    </body>
</html>
