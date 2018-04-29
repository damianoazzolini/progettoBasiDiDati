<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Utente;
use App\Role;
use App\Staff;

class StaffController extends Controller {
    public function index()  {
        //restituisco tutti i membri dello staff
        $ruolo = Utente::trovaRuolo(Auth::id());
        $datiStaff = DB::select("SELECT utente.id, utente.nome, utente.cognome, 
            staff.identificativo as identificativoPersonale, 
            staff.idReparto as idReparto,
            reparto.identificativo as identificativoReparto 
            FROM utente
            JOIN staff ON utente.id = staff.id
            JOIN reparto ON reparto.id = staff.idReparto
            WHERE utente.attivo = '1'");

        return view('elencoStaff',[
            'datiStaff' => $datiStaff,
            'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $search = request('search');
        
        $query = DB::select("SELECT utente.id, utente.nome, utente.cognome, 
        staff.identificativo as identificativoPersonale, 
        staff.idReparto as idReparto,
        reparto.identificativo as identificativoReparto 
        FROM utente
        JOIN staff ON utente.id = staff.id
        JOIN reparto ON reparto.id = staff.idReparto
        WHERE utente.attivo = '1' AND
            (CONCAT(utente.nome, ' ', utente.cognome) LIKE '$search%' OR 
            CONCAT(utente.cognome, ' ', utente.nome) LIKE '$search%')");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('elencoStaff',['datiStaff' => $query, 'ruolo' => $ruolo]);
    }

    public function create() {
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('aggiungiStaff',['ruolo' => $ruolo]);
    }

    public function store(Request $request) {
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

        $ruolo = request('ruolo');
        $role_paziente = Role::where('name',$ruolo)->first();
        $utente->roles()->attach($role_paziente);

        $identificativoReparto = request('identificativoReparto');
        $reparto = DB::select("SELECT * FROM reparto WHERE reparto.identificativo = '$identificativoReparto'");

        $staff = new Staff();
        $staff->id = $utente->id;
        $staff->idReparto = $reparto[0]->id;
        $staff->identificativo = request('identificativoPersonale');
        $staff->stipendio = request('stipendio');
        $staff->save();

        return redirect('/elencoStaff')->with('status','Nuovo membro dello staff creato con successo');
    }

    public function show($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());

        $datiUtente = DB::select("SELECT * FROM utente
            WHERE utente.attivo = '1' AND utente.id = $id");

        $queryStaff = DB::select("SELECT * FROM staff WHERE staff.id = $id");
        $idReparto = $queryStaff[0]->idReparto;

        $reparto = DB::select("SELECT * FROM reparto
            WHERE reparto.id = $idReparto");

        $ruoloStaff = Utente::trovaRuolo($datiUtente[0]->id);

        return view('mostraStaff',[
            'datiUtente' => $datiUtente[0], 
            'datiStaff' => $queryStaff[0],
            'reparto' => $reparto[0],
            'ruoloStaff' => $ruoloStaff,
            'ruolo' => $ruolo]);
    }

    public function edit($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());

        $datiUtente = DB::select("SELECT * FROM utente
            WHERE utente.attivo = '1' AND utente.id = $id");

        $queryStaff = DB::select("SELECT * FROM staff WHERE staff.id = $id");
        $idReparto = $queryStaff[0]->idReparto;

        $reparto = DB::select("SELECT * FROM reparto
            WHERE reparto.id = $idReparto");

        $ruoloStaff = Utente::trovaRuolo($datiUtente[0]->id);

        return view('modificaStaff',[
            'datiUtente' => $datiUtente[0], 
            'datiStaff' => $queryStaff[0],
            'reparto' => $reparto[0],
            'ruoloStaff' => $ruoloStaff,
            'ruolo' => $ruolo]);      
    }

    // discriminare se l'update la fa un impiegato o un admin (l'impiegato modifica
    // solo stipendio e reparto)
    public function update(Request $request, $id) {
        if(Utente::trovaRuolo(Auth::id()) == "Amministratore"){
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

            //Cancello il vecchio ruolo
            DB::statement("DELETE FROM utente_role WHERE user_id = $id");
            // Aggiungo il nuovo ruolo
            $ruolo = request('ruolo');
            $role_paziente = Role::where('name',$ruolo)->first();
            $role_id = $role_paziente->id;
            DB::statement("INSERT INTO utente_role (user_id, role_id) VALUES($id, $role_id)");
            
            // Aggiorno i dati sulla tabella utente
            DB::statement("UPDATE utente SET nome = '$nome', cognome = '$cognome', dataNascita = '$dataNascita',
                sesso = $sesso, codiceFiscale = '$codiceFiscale', email = '$email', telefono = '$telefono',
                provincia = '$provincia', stato = '$stato', comune = '$comune', via = '$via', numeroCivico = '$numeroCivico' 
                WHERE id = $id");
        }
        // Aggiorno i dati sulla tabella staff
        $identificativoReparto = request('identificativoReparto');
        $reparto = DB::select("SELECT * FROM reparto WHERE reparto.identificativo = '$identificativoReparto'");
        $idReparto = $reparto[0]->id;
        $identificativo = request('identificativoPersonale');
        $stipendio = request('stipendio');

        DB::statement("UPDATE staff SET stipendio = $stipendio, identificativo = '$identificativo', 
                idReparto = $idReparto WHERE id = $id");

        return redirect('/elencoStaff')->with('status','Membro dello staff aggiornato con successo');      
    }

    public function destroy($id) {
        DB::statement("DELETE FROM staff WHERE staff.id = $id");
        DB::statement("DELETE FROM utente WHERE utente.id = $id");

        return redirect('/elencoStaff')->with('status','Membro dello staff cancellato con successo');
    }
}
