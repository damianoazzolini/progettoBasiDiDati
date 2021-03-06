<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Utente;
use App\Paziente;
use DB;

class PazienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::select("SELECT * FROM utente
            JOIN paziente ON utente.id = paziente.id
            WHERE utente.attivo = 1 ORDER BY cognome");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('elencoPazienti',['pazienti' => $query, 'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $search = request('search');
        
        $query = DB::select("SELECT * FROM utente
            JOIN paziente ON utente.id = paziente.id
            WHERE utente.attivo = 1 AND
            (CONCAT(nome, ' ', cognome) LIKE '$search%' OR 
            CONCAT(cognome, ' ', nome) LIKE '$search%' OR
            codiceFiscale LIKE '$search%')");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('elencoPazienti',['pazienti' => $query, 'ruolo' => $ruolo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('aggiungiPaziente',['ruolo' => $ruolo]);
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
            'nome' => 'required|min:3',
            'cognome' => 'required|min:3',
            'email' => 'required|min:3|unique:utente',
            'password' => 'required|min:3',
        ]);
    	
        $utente = new Utente();
        $utente->nome = request('nome');
        $utente->cognome = request('cognome');
        $utente->dataNascita = request('dataNascita');
        $sesso = request('sesso');
        if($sesso == 'uomo') {
            $utente->sesso = '1';
        }
        else {
            $utente->sesso = '0';
        }
        $utente->codiceFiscale = request('codiceFiscale');
        $utente->email = request('email');
        $utente->password = bcrypt(request('password'));
        $utente->attivo = '1';
        $utente->telefono = request('telefono');
        $utente->provincia = request('provincia');
        $utente->stato = request('stato');
        $utente->comune = request('comune');
        $utente->via = request('via');
        $utente->numeroCivico = (int)request('civico');
        $utente->remember_token = 'empty';
        $utente->save();

        $role_paziente = Role::where('name','Paziente')->first();
        $utente->roles()->attach($role_paziente);

        $paziente = new Paziente();
        $paziente->id = $utente->id;
        $paziente->note = request('note');
        $paziente->altezza = request('altezza');
        $paziente->peso = request('peso');
        $paziente->save();

        return redirect('/elencoPazienti')->with('status','Utente creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = DB::select("SELECT * FROM utente
            JOIN paziente ON utente.id = paziente.id
            WHERE utente.attivo = 1 AND utente.id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        //farmaci assunti
        $farmaci = DB::table('farmaco')
            ->join('paziente_farmaco','farmaco.id','=','paziente_farmaco.idFarmaco')
            ->where('paziente_farmaco.idPaziente',$id)
            ->select('farmaco.id','farmaco.nome','farmaco.categoria')
            ->get();
        
        //prestazioni prenotate
        $prestazioni = DB::table('prestazione')
        ->where('idPaziente',$id)
        ->where('attivo',1)
        ->select('data','id','effettuata')
        ->get();

        return view('mostraPaziente',[
            'datiPaziente' => $query[0], 
            'farmaci' => $farmaci,
            'prestazioni' => $prestazioni,
            'ruolo' => $ruolo]);       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $query = DB::select("SELECT * FROM utente
            JOIN paziente ON utente.id = paziente.id
            WHERE utente.attivo = 1 AND utente.id = $id");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('modificaPaziente',['datiPaziente' => $query[0], 'ruolo' => $ruolo]);
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
        DB::statement("UPDATE paziente SET peso = $peso, altezza = $altezza, 
                    note = '$note' WHERE id = $id");
        DB::statement("UPDATE utente SET nome = '$nome', cognome = '$cognome', dataNascita = '$dataNascita',
                    sesso = $sesso, codiceFiscale = '$codiceFiscale', email = '$email', telefono = '$telefono',
                    provincia = '$provincia', stato = '$stato', comune = '$comune', via = '$via', numeroCivico = '$numeroCivico' 
                    WHERE id = $id");

        return redirect('/elencoPazienti')->with('status','Utente aggiornato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::statement("DELETE FROM paziente WHERE paziente.id = $id");
        DB::statement("DELETE FROM utente WHERE utente.id = $id");

        return redirect('/elencoPazienti')->with('status','Utente cancellato con successo');
    }
}
