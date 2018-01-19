<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Amministratore;
use App\Seguace;
use App\Pagina;
//per poter utilizzare Auth
use Illuminate\Support\Facades\Auth;


class PaginaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($nome) {
        if($nome === null){
			return redirect()->back();
        }
        $paginaID = DB::table('pagina')->where('nome',$nome)->pluck('paginaID');

        if($paginaID === null) {
            return redirect('/home.home');
        }

        /* seleziono tutti i post con id della pagina attivi */
        $post = DB::table('post')->where('paginaID', $paginaID)->where('attivo','1')->first();
        $immagine = DB::table('pagina')->where('paginaID',$paginaID)->where('attivo','1')->pluck('immagine');
        $descrizione = DB::table('pagina')->where('paginaID',$paginaID)->where('attivo','1')->pluck('descrizione');
        $seguaciPagina = DB::table('seguace')->where('paginaID',$paginaID)->first();
        $amministratoriPagina = DB::table('amministratore')->where('paginaID',$paginaID)->first();

        return view('pagina.pagina', compact('nome','immagine','descrizione','seguaciPagina','amministratoriPagina','post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        /*
        $this->validate(request(), [
            'nome' => 'required|min:3',
            'descrizione' => 'required|min:3',
        ]);
        */
        
        if($request->nome === null || $request->descrizione === null) {
            return redirect('/pagina.creaPagina')->withErrors('Nome e descrizione non possono essere vuoti.');
        }

        $pagina = new Pagina;
        $pagina->nome = $request->nome;
        $pagina->descrizione = $request->descrizione;
        $pagina->immagine = $request->image;
        $pagina->attivo = 1;

        $pagina->save();
        return $this->index($pagina->nome);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate(request(), [
            'contenuto' => 'required'
        ]);

        $post = new Post;    
        //fix
        $post->paginaID = $paginaID;
    
    }

    public function display() {
        return view('pagina.creaPagina');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
