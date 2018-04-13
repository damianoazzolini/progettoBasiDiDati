<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Reparto;
use App\Utente;

class RepartoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::select("SELECT * FROM reparto");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('reparti',['reparti' => $query, 'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $search = request('search');
        
        $query = DB::select("SELECT * FROM reparto
            WHERE nome LIKE '$search%' OR 
            identificativo LIKE '$search%'");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('reparti',['reparti' => $query, 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('aggiungiReparto',['ruolo' => $ruolo]);
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
            'identificativo' => 'required|min:2|max:64',
        ]);

        $nome = request('nome');
        $identificativo = request('identificativo');
        $descrizione = request('descrizione');

        DB::statement("INSERT INTO reparto (nome, identificativo, descrizione) VALUES ('$nome', '$identificativo', '$descrizione')");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return redirect('/reparti')->with('status','Reparto creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = DB::select("SELECT * FROM reparto WHERE id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('mostraReparto',['reparto' => $query[0], 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = DB::select("SELECT * FROM reparto WHERE id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('modificaReparto',['reparto' => $query[0], 'ruolo' => $ruolo]);
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
        $nome = request('nome');
        $identificativo = request('identificativo');
        $descrizione = request('descrizione');
        DB::statement("UPDATE reparto SET nome = '$nome', identificativo = '$identificativo', 
                    descrizione = '$descrizione' WHERE id = $id");

        return redirect('/reparti')->with('status','Reparto aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::statement("DELETE FROM reparto WHERE id = $id");

        return redirect('/reparti')->with('status','Reparto cancellato con successo');
    }
}
