<html>
    <head>
        <title>Conferma email</title>
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
                <h1>Conferma email</h1>
                Grazie per la registrazione. Ti abbiamo inviato un'email di conferma all'indirizzo indicato.
                
                <form id="formConfirm" action="/registrazione/conferma" method="POST">
                    {{ csrf_field() }}
                    <div id="divConfirmRegistration">
                        <br><br>
                        <button type ="submit" id="confirmRegistration"><b>Conferma email</b></button>
                        <br><br>
                    </div>
                    <input id="inputCode" type="hidden" name="usercode" value="{{ app('request')->input('code') }}"/>
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