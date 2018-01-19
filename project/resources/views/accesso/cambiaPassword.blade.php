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
                <h1>Cambio password</h1>             
                <form id="formConfirm" action="/recuperaPassword/cambiaPassword" method="POST">
                    {{ csrf_field() }}
                    <input id="inputCode" type="hidden" name="usercode" value="{{ app('request')->input('code') }}"/>
                     Inserisci la password fornita via email:<br>
                     <input type="password" name="oldpass"><br>
                     <p>Inserisci la nuova password:<br>
                     <input type="password" name="newpass"><br>
                     <p>Conferma la nuova password:<br>
                     <input type="password" name="newpassConfirm">    
                            <br>   
                            @foreach ($errors->all() as $error)
                            <li>
                            {{ $error }}
                            </li>
                            @endforeach
                     <p><input type="submit" value="Cambia password">
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
