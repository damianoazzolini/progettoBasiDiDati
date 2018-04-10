<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\PazienteFarmaco;
use App\Farmaco;
use App\Utente;

class FarmacoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::select("SELECT * FROM farmaco");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('farmacia',['farmaci' => $query, 'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $search = request('search');
        
        $query = DB::select("SELECT * FROM farmaco
            WHERE nome LIKE '$search%' OR 
            categoria LIKE '$search%'");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('farmacia',['farmaci' => $query, 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('aggiungiFarmaco',['ruolo' => $ruolo]);
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
            'categoria' => 'required|min:2|max:64',
        ]);

        $nome = request('nome');
        $categoria = request('categoria');
        $descrizione = request('descrizione');

        $query = DB::select("INSERT INTO farmaco (nome, categoria, descrizione) VALUES ('$nome', '$categoria', '$descrizione')");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return redirect('/farmacia')->with('status','Farmaco creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $query = DB::select("SELECT * FROM farmaco WHERE id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('mostraFarmaco',['farmaco' => $query[0], 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = DB::select("SELECT * FROM farmaco WHERE id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('modificaFarmaco',['farmaco' => $query[0], 'ruolo' => $ruolo]);
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
        $categoria = request('categoria');
        $descrizione = request('descrizione');
        DB::statement("UPDATE farmaco SET nome = '$nome', categoria = '$categoria', 
                    descrizione = '$descrizione' WHERE id = $id");

        return redirect('/farmacia')->with('status','Farmaco aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::statement("DELETE FROM farmaco WHERE id = $id");

        return redirect('/farmacia')->with('status','Farmaco cancellato con successo');
    }
}
