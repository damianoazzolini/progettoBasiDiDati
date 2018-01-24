<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Amministratore;
use App\Seguace;
use App\Pagina;
use App\SegueAmministra;
use Illuminate\Support\Facades\Auth;


class PaginaController extends Controller
{
    /**
     * Display aì listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($paginaID) {
        if($paginaID === null){
			return redirect()->back();
        }

        $id = Auth::id();
        $persona = DB::table('segueAmministra')->where('paginaID',$paginaID)->where('utenteID',$id)->first();

        //se persona null non è iscritto quindi mostro solo tasto

        //else questa parte
        
        /* seleziono tutti i post con id della pagina attivi */
        $post = DB::table('post')->where('paginaID', $paginaID)->first();
        $immagine = DB::table('pagina')->where('paginaID',$paginaID)->pluck('immagine');
        $descrizione = DB::table('pagina')->where('paginaID',$paginaID)->pluck('descrizione');
        $tipo = DB::table('pagina')->where('paginaID',$paginaID)->pluck('tipo');
        $iscritti = DB::table('segueAmministra')->where('paginaID',$paginaID)->where('stato','iscritto')->first();
        $amministratore = DB::table('segueAmministra')->where('paginaID',$paginaID)->where('stato','amministratore')->first();

        return view('pagina.pagina', compact('nome','immagine','descrizione','post','tipo','iscritto','amministratore','paginaID'));
    }

    public function create(Request $request) {
        
        $this->validate(request(), [
            'nome' => 'required|min:3|unique:pagina',
            'descrizione' => 'required|min:3',
            //'image' => 'required', 
            'tipo' => 'required|min:3', 
        ]);

        Pagina::newPage($request->nome,$request->tipo,$request->immagine,$request->descrizione);

        $paginaID = DB::table('pagina')->where('nome',$request->nome)->where('attivo','1')->pluck('paginaID');

        SegueAmministra::new_segueAmministra(Auth::id(),$paginaID[0],'amministratore');

        return $this->index($paginaID);
    }

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

    public function subscribe(Request $request) {
        //chiamare la subscribe con la form con paginaID e utenteID come hidden field
        $iscritto = new SegueAmministra;
        $iscritto->paginaID = $request->paginaID;
        $iscritto->utenteID = $reqeust->utenteID; 
        $amministratore->stato = "iscritto";
        $amministratore->save();
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
