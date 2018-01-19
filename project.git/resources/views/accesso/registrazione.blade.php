<html>
    <head>
        <title>Registrazione</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script charset="utf-8" type="text/javascript" src="{{asset('/js/registration.js')}}" ></script>
        <link rel="shortcut icon" href="{{ asset('/systemImages/favicon.ico') }}"/>
        <link type="text/css" rel="stylesheet" href="{{asset('/css/registration.css')}}"/>
    </head>
    <body>
        
        
        <div class="headerRegistrationDevelopers">
            <div id="headerLogo"><a href="/"><img src="{{ asset('/systemImages/logo.png') }}"/></a></div>
        </div>
                
        <div class="contentRegistrationDevelopers">
            <div id="formContentRegistration">
                <h1>Registrazione</h1>

                <ul>
                @foreach ($errors->all() as $error)
                    <li>
                    {{ $error }}
                    </li>
                @endforeach
                </ul>
                
                <form id="formRegistration" action="registrazione" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <fieldset style="text-align: left;">
                        <legend>Inserisci i tuoi dati:</legend><br>
                        <div id="formContainerRegistrationLeft">
                            Nome:<br>
                            <input id="inputName" type="text" name="name"><br>
                            <div class="hiddenField" id="errorName">Il nome deve essere maggiore di 3 caratteri.</div>
                            <br>
                            Cognome:<br>
                            <input id="inputSurname" type="text" name="surname"><br>
                            <div class="hiddenField" id="errorSurname">Il cognome deve essere maggiore di 3 caratteri.</div>
                            <br>
                            Email:<br>
                            <input id="inputEmail" type="text" name="email"><br>
                            <div class="hiddenField" id="errorEmail">Email non valida.</div>
                            <br>
                            Password:<br>
                            <input id="inputPassword" type="password" name="password"><br>
                            <div class="hiddenField" id="errorPassword">La password deve essere maggiore di 5 caratteri.</div>
                            <br>
                            Conferma Password:<br>
                            <input id="inputConfirmPassword" type="password" name="confirmPassword"><br>
                            <div class="hiddenField" id="errorConfirmPassword">Le due password non coincidono.</div>
                            <br>
                            Data di nascita:<br>
                            <input id="inputDate" type="date" name="date"/><br>
                            <div class="hiddenField" id="errorDate">Data non valida.</div>
                            <br>
                            Sesso:<br>
                            <input id="inputSexMale" type="radio" name="sex" value="0" checked ><label for="inputSexMale">M</label>
                            <input id="inputSexFemale" type="radio" name="sex" value="1"><label for="inputSexFemale">F</label>
                        </div>
                        <div id="formContainerRegistrationRight">
                            Carica un'immagine profilo:<br>
                            <div id="divUpload">
                                <div id="close"></div>
                                <input id="inputImage" type="file" name="image"/>
                            </div>
                        </div>	
                    </fieldset>
                    <br>
                    <button id="submitRegistration" type="button"><b>Registrati</b></button>
                </form>
            </div>
        </div>
        
        <div class="footerRegistration">
            
        </div>
        
    </body>
</html>
