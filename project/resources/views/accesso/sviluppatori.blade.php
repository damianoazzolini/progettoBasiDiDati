<html>
    <head>
        <title>Sviluppatori</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script charset="utf-8" type="text/javascript" src="{{asset('/js/registration.js')}}" ></script>
        <link rel="shortcut icon" href="{{ asset('/systemImages/favicon.ico') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('/css/registration.css') }}"/>
    </head>
    <body>
        <div class="headerRegistrationDevelopers">
            <div id="headerLogo"><a href="/"><img src="{{ asset('/systemImages/logo.png') }}"/></a></div>
        </div>
                
        <div class="contentRegistrationDevelopers" style="text-align: center">
            <h1>Sviluppatori</h1>
            <div id="divContentTableDevelopers">
                <table class="tableDevelopers" id="tableDevelopersDesktop">
                    <tr>
                        <td><div class="divImage" id="ilaImg"></div></td>
                        <td><div class="divImage" id="damiImg"></div></td>
                        <td><div class="divImage" id="bertaImg"></div></td>
                    </tr>
                    <tr>
                        <td><div class="infoDeveloper"><b>Ilaria Sassoli</b></div></td>
                        <td><div class="infoDeveloper"><b>Damiano Azzolini</b></div></td>
                        <td><div class="infoDeveloper"><b>Alessandro Bertagnon</b></div></td>
                    </tr>
                    <tr>
                        <td><div class="divImage" id="bertasiImg"></div></td>
                        <td><div class="divImage" id="dekImg"></div></td>
                        <td><div class="divImage" id="fazziImg"></div></td>
                    </tr>
                    <tr>
                        <td><div class="infoDeveloper"><b>Francesco Bertasi</b></div></td>
                        <td><div class="infoDeveloper"><b>Dario Decarlo</b></div></td>
                        <td><div class="infoDeveloper"><b>Mattia Fazzi</b></div></td>
                    </tr>
                </table>
                <table class="tableDevelopers" id="tableDevelopersMobile">
                    <tr><td><div class="divImage" id="ilaImg"></div></td></tr>
                    <tr><td><div class="infoDeveloper"><b>Ilaria Sassoli</b></div></td></tr>
                    <tr><td><div class="divImage" id="damiImg"></div></td></tr>
                    <tr><td><div class="infoDeveloper"><b>Damiano Azzolini</b></div></td></tr>
                    <tr><td><div class="divImage" id="bertaImg"></div></td></tr>
                    <tr><td><div class="infoDeveloper"><b>Alessandro Bertagnon</b></div></td></tr>
                    <tr><td><div class="divImage" id="bertasiImg"></div></td></tr>
                    <tr><td><div class="infoDeveloper"><b>Francesco Bertasi</b></div></td></tr>
                    <tr><td><div class="divImage" id="dekImg"></div></td></tr>
                    <tr><td><div class="infoDeveloper"><b>Dario Decarlo</b></div></td></tr>
                    <tr><td><div class="divImage" id="fazziImg"></div></td></tr>
                    <tr><td><div class="infoDeveloper"><b>Mattia Fazzi</b></div></td></tr>
                </table>
            </div>
            
            <br><br>
            <a href="/"><button type="button" id="backHome"><b>Torna al Login</b></button></a>
            <br><br><br>
        </div>
    </body>
</html>
