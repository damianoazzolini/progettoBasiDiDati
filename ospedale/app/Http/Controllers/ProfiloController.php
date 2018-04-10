<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utente;
use DB;

class ProfiloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $id = Auth::id();
        $info = DB::select("SELECT * FROM utente
            WHERE utente.attivo = 1 AND utente.id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('profilo',['datiUtente' => $info[0], 'ruolo' => $ruolo]);
        //return view('mostraPaziente',['datiPaziente' => $query[0], 'ruolo' => $ruolo]);
        //$ruolo = Utente::trovaRuolo(Auth::id());
        //$info = Utente::all()->where('id',Auth::id());
        //return view('profilo',['info' => $info, 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)  {
        $id = Auth::id();
        $query = DB::select("SELECT * FROM utente
            WHERE utente.attivo = 1 AND utente.id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('modificaProfilo',['datiUtente' => $query[0], 'ruolo' => $ruolo]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $nome = request('nome');
        $cognome = request('cognome');
        $dataNascita = request('dataNascita');
        $sesso = request('sesso');
        if($sesso == 'uomo') {
            $sesso = '1';
        }
        else {
            $sesso = '0';
        }
        $codiceFiscale = request('codiceFiscale');
        $email = request('email');
        $telefono = request('telefono');
        $provincia = request('provincia');
        $stato = request('stato');
        $comune = request('comune');
        $via = request('via');
        $numeroCivico = (int)request('civico');
        $peso = (int)request('peso');
        $altezza = (int)request('altezza');
        $note = request('note');
       
        DB::statement("UPDATE utente SET nome = '$nome', cognome = '$cognome', dataNascita = '$dataNascita',
                    sesso = $sesso, codiceFiscale = '$codiceFiscale', email = '$email', telefono = '$telefono',
                    provincia = '$provincia', stato = '$stato', comune = '$comune', via = '$via', numeroCivico = '$numeroCivico' 
                    WHERE id = $id");

        return redirect('/profilo')->with('status','Profilo aggiornato con successo');
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
