<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\PazienteFarmaco;
use App\Farmaco;
use App\Utente;

class FarmacoPrestazioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $query = DB::select("SELECT * FROM paziente_farmaco
            JOIN farmaco ON farmaco.id = paziente_farmaco.idFarmaco
            WHERE paziente_farmaco.idPaziente = $id");
        $ruolo = Utente::trovaRuolo($id);

        return view('myfarmaci',['farmaci' => $query, 'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $id = Auth::id();
        $search = request('search');
        $query = DB::select("SELECT * FROM paziente_farmaco
            JOIN farmaco ON farmaco.id = paziente_farmaco.idFarmaco
            WHERE paziente_farmaco.idPaziente = $id
            AND (nome LIKE '$search%' OR 
            categoria LIKE '$search%')");
        $ruolo = Utente::trovaRuolo($id);

        return view('myfarmaci',['farmaci' => $query, 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('aggiungiMyFarmaco',['ruolo' => $ruolo]);
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
            'nome' => 'required|min:2|max:64',
        ]);

        $idPaziente = Auth::id();
        $nome = request('nome');

        $farmaco = DB::select("SELECT id, categoria FROM farmaco WHERE nome = '$nome'");
        if($farmaco == null || $farmaco == [])
            return redirect()->back()->with('status', 'Ffarmaco inesistente');
        else {
            $idFarmaco = (int) $farmaco[0]->id;
            DB::statement("INSERT INTO paziente_farmaco (idPaziente, idFarmaco, created_at, updated_at) VALUES ('$idPaziente', '$idFarmaco',NOW(),NOW())");
            return redirect('/myfarmaci')->with('status','Farmaco aggiunto con successo');
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
        $idPaziente = Auth::id();
        DB::statement("DELETE FROM paziente_farmaco WHERE idPaziente = $idPaziente AND idFarmaco = $id");

        return redirect('/myfarmaci')->with('status','Farmaco rimosso con successo');
    }


    public static function categoriaAutocomplete(){
        $search = request('term');
        $results = array();
        $reparti = DB::select("SELECT DISTINCT categoria FROM farmaco WHERE categoria LIKE '$search%'");
        foreach ($reparti as $reparto) $results[] = ['value' => $reparto->categoria];
        if(count($results)) return $results;
        else return ['value'=>'Nessuna categoria trovata'];
    }

    public static function nomeAutocomplete(){
        $search = request('term');
        $categoria = request('categoria');
        $results = array();
        if(empty($categoria)) $reparti = DB::select("SELECT nome FROM farmaco WHERE nome LIKE '$search%'");
        else $reparti = DB::select("SELECT nome FROM farmaco WHERE nome LIKE '$search%' AND categoria = '$categoria'");
        foreach ($reparti as $reparto) $results[] = ['value' => $reparto->nome];
        if(count($results)) return $results;
        else return ['value'=>'Nessun farmaco trovato'];
    }
}
