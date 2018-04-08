<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myHospital - Autenticazione</title>

    <!-- Bootstrap core CSS -->
    <link type="text/css" rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">
    <!-- Custom styles for this template -->
    <link type="text/css" rel="stylesheet" href="{{asset('/css/signin.css')}}">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post">
        <img class="mb-4" src="{{ asset('/images/logo.png') }}" alt="" width="210" height="140">
        <div>
          @if (session('status'))
          <div class="alert alert-secondary alert-dismissible fade show" role="alert">
              {{ session('status') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endif
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h1 class="h3 mb-3 font-weight-normal">Accedi</h1>
        <label for="inputEmail" class="sr-only">Inserisci Email</label>
        <input type="email" id="inputEmail" name="email" class="form-control" value="amministratore@amministratore.com" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" value="password" placeholder="Password" required>
        <!--<div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        </div>-->
      <button class="btn btn-lg btn-primary btn-block" type="submit">Entra</button>
    </form>
    <!--<div class="col-6">
        <div class="alert alert-secondary" role="alert">
            Gli utenti creati sono: <br>
            Paziente, paziente@paziente.com, password<br>
            Utente, utente@utente.com, password<br>
            Infermiere, infermiere@infermiere.com, password<br>
            Impiegato, impiegato@impiegato.com, password<br>
            Amministratore, amministratore@amministratore.com, password<br>
        </div>
    </div>-->

    <script charset="utf-8" type="text/javascript" src="{{asset('/js/jquery-3.js')}}" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script charset="utf-8" type="text/javascript" src="{{asset('/js/bootstrap.js')}}"></script>
    
  </body>
</html>