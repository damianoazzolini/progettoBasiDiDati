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
        $query = DB::select("SELECT sala.id as id, sala.nome as nomeSala,
            sala.descrizione as descrizione, sala.piano as piano,
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
        
        $query = DB::select("SELECT sala.id as id, sala.nome as nomeSala,
            sala.descrizione as descrizione, sala.piano as piano,
            reparto.identificativo as identificativoReparto FROM sala
            JOIN reparto ON sala.idReparto = reparto.id
            WHERE sala.nome LIKE '$search%'");
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
            'nomeSala' => 'required|min:2|max:64',
            'identificativoReparto' => 'required|min:2|max:64',
        ]);

        $nomeSala = request('nomeSala');
        $identificativoReparto = request('identificativoReparto');
        $idReparto = DB::select("SELECT id FROM reparto 
            WHERE reparto.identificativo = '$identificativoReparto'");
        if(empty($idReparto)){
            return redirect()->back()->with('status','Identificativo reparto non riconosciuto');
        }
        else {
            $idReparto = (int) $idReparto[0]->id;
            $piano = (int) request('piano');
            $descrizioneSala = request('descrizioneSala');

            DB::statement("INSERT INTO sala (nome, idReparto, descrizione, piano) VALUES ('$nomeSala', '$idReparto', '$descrizioneSala', '$piano')");
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
        $query = DB::select("SELECT sala.id as id, sala.nome as nomeSala,
            sala.descrizione as descrizioneSala, sala.piano as piano,
            reparto.identificativo as identificativoReparto, reparto.nome as nomeReparto,  
            reparto.descrizione as descrizioneReparto FROM sala
            JOIN reparto ON sala.idReparto = reparto.id
            WHERE sala.id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('mostraSala',['sala' => $query[0], 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = DB::select("SELECT sala.id as id, sala.nome as nomeSala,
            sala.descrizione as descrizioneSala, sala.piano as piano,
            reparto.identificativo as identificativoReparto, reparto.nome as nomeReparto,  
            reparto.descrizione as descrizioneReparto FROM sala
            JOIN reparto ON sala.idReparto = reparto.id
            WHERE sala.id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('modificaSala',['sala' => $query[0], 'ruolo' => $ruolo]);
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
        $this->validate(request(), [
            'nomeSala' => 'required|min:2|max:64',
            'identificativoReparto' => 'required|min:2|max:64',
        ]);

        $nomeSala = request('nomeSala');
        $identificativoReparto = request('identificativoReparto');
        $idReparto = DB::select("SELECT id FROM reparto 
            WHERE reparto.identificativo = '$identificativoReparto'");
        if(empty($idReparto)){
            return redirect()->back()->with('status','Identificativo reparto non riconosciuto');
        }
        else {
            $idReparto = (int) $idReparto[0]->id;
            $piano = (int) request('piano');
            $descrizioneSala = request('descrizioneSala');

            DB::statement("UPDATE sala SET nome = '$nomeSala', idReparto = '$idReparto', 
                descrizione = '$descrizioneSala', piano = '$piano' WHERE id = $id");

            return redirect('/sale')->with('status','Sala aggiornata con successo');
        }
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
