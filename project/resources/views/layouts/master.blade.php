
<!DOCTYPE html>
<head>
	<title>Harambe</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Type" content="json; charset=UTF-8">
	<link type="text/css" rel="stylesheet" href="{{asset('/css/home.css')}}"/> 
	<link rel="shortcut icon" href="{{ asset('/systemImages/favicon.ico') }}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('/css/layout.css')}}"/>    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
       
	@yield('scripts')
</head>
<body>
	@include('layouts.menu')
	@yield('content')
		
</body>
</html>
