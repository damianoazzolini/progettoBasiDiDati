<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Reparto;
use App\Utente;
use App\Sala;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::select("SELECT sala.id as id, sala.identificativo as identificativoSala,
            sala.idReparto as idReparto, sala.descrizione as descrizione, sala.piano as piano,
            reparto.identificativo as identificativoReparto FROM sala
            JOIN reparto ON sala.idReparto = reparto.id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('sale',['sale' => $query, 'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $search = request('search');
        
        $query = DB::select("SELECT sala.id as id, sala.identificativo as identificativoSala,
            sala.idReparto as idReparto, sala.descrizione as descrizione, sala.piano as piano,
            reparto.identificativo as identificativoReparto FROM sala
            JOIN reparto ON sala.idReparto = reparto.id
            WHERE sala.identificativo LIKE '$search%'");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('sale',['sale' => $query, 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('aggiungiSala',['ruolo' => $ruolo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'identificativoSala' => 'required|min:2|max:64',
            'identificativoReparto' => 'required|min:2|max:64',
        ]);

        $identificativoSala = request('identificativoSala');
        $identificativoReparto = request('identificativoReparto');
        $idReparto = DB::select("SELECT id FROM reparto 
            WHERE reparto.identificativo = '$identificativoReparto'");
        if(empty($idReparto)){
            return redirect()->back()->with('status','Identificativo reparto non riconosciuto');
        }
        else {
            $idReparto = (int) $idReparto[0]->id;
            $piano = (int) request('piano');
            $descrizione = request('descrizione');

            DB::statement("INSERT INTO sala (identificativo, idReparto, descrizione, piano) VALUES ('$identificativoSala', '$idReparto', '$descrizione', '$piano')");
            $ruolo = Utente::trovaRuolo(Auth::id());

            return redirect('/sale')->with('status','Sala creata con successo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        DB::statement("DELETE FROM sala WHERE id = $id");

        return redirect('/sale')->with('status','Sala cancellata con successo');
    }

    public static function repartoAutocomplete(){
        $search = request('term');
        $results = array();
        $reparti = DB::select("SELECT identificativo FROM reparto WHERE identificativo LIKE '$search%'");
        foreach ($reparti as $reparto) $results[] = ['value' => $reparto->identificativo];
        if(count($results)) return $results;
        else return ['value'=>'Nessun reparto trovato'];
    }
}
