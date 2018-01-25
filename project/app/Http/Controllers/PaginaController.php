<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Amministratore;
use App\Seguace;
use App\Pagina;
use App\SegueAmministra;
use Illuminate\Support\Facades\Auth;


class PaginaController extends Controller {
    public function index($nome) {
        $paginaID = Pagina::getPageID($nome);

        $post = Pagina::getPostsFromPageID($paginaID);
        $immagine = Pagina::getPageDescription($paginaID);
        $descrizione = Pagina::getPageDescription($paginaID);
        $tipo = Pagina::getPageType($paginaID);

        $isSubscribed = Pagina::isSubscribed($nome);

        return view('pagina.pagina', compact('post','immagine','descrizione','tipo','nome','isSubscribed'));
    }

    public function create(Request $request) {
        
        $this->validate(request(), [
            'nome' => 'required|min:3|unique:pagina',
            'descrizione' => 'required|min:3',
            //'image' => 'required', 
            'tipo' => 'required|min:3', 
        ]);

        Pagina::newPage($request->nome,$request->tipo,$request->immagine,$request->descrizione);

        $paginaID = Pagina::getPageID($request->nome);

        SegueAmministra::new_segueAmministra(Auth::id(),$paginaID,'amministratore');

        $post = Pagina::getPostsFromPageID($paginaID);
        $immagine = Pagina::getPageDescription($paginaID);
        $descrizione = Pagina::getPageDescription($paginaID);
        $tipo = Pagina::getPageType($paginaID);

        return $this->index($request->nome);
    }

    public function mostraPagina() {
        return $this->index(request('nome'));
    }

    public function display() {
        return view('pagina.creaPagina');
    }

    public function subscribe(Request $request) {
        Pagina::subscribe($request->nomePagina);
        return $this->index($request->nome);
    }

    public function store(Request $request) {
        $this->validate(request(), [
            'post' => 'required',
            'nomePagina' => 'required', 
        ]);
        Post::savePost(Auth::id(),$request->testo,$request->nomePagina,$request->image);
        return $this->index($request->nomePagina);
    }

    public function show($id) {
        //seleziono tutti i post della pagina
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
