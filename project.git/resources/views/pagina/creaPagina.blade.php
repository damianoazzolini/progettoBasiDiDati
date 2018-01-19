@extends('layouts.master')

@section('content')
<div class="contentHome">
<div class="creaPagina">
    <form action="pagina/create" method="POST" enctype="multipart/form-data" id="formPost">
        {{ csrf_field() }}
        <input type="text" placeholder="Nome Pagina" name="nome"></br>
        <input type="file" name="image"></br>
        <textarea cols="40" rows="5" placeholder="Descrizione Pagina" name="descrizione"></textarea></br>
        <input type="submit"><b>Post</b>
    
        <ul>
        @foreach ($errors->all() as $error)
            <li>
            {{ $error }}
            </li>
        @endforeach
        </ul>
    </form>
</div>
</div>
@endsection