<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Utente;
use App\Role;

class PrestazioneController extends Controller {
    public function index() {
        /*
        | id             | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
        | idReparto      | int(10) unsigned | NO   | MUL | NULL    |                |
        | idPaziente     | int(10) unsigned | NO   | MUL | NULL    |                |
        | idSala         | int(10) unsigned | NO   | MUL | NULL    |                |
        | identificativo | varchar(255)     | NO   |     | NULL    |                |
        | note           | text             | YES  |     | NULL    |                |
        | attivo         | tinyint(1)       | NO   |     | NULL    |                |
        | effettuata     | tinyint(1)       | NO   |     | NULL    |                |
        | created_at     | timestamp        | YES  |     | NULL    |                |
        | updated_at     | timestamp        | YES  |     | NULL    | 
        */
        $query = DB::select("SELECT * FROM prestazione");
        $ruolo = Utente::trovaRuolo(Auth::id());
        $reparti = [];
        $sale = [];
        $pazienti = [];
        $staff = [];
        $farmaci = [];

        foreach($query as $prestazione) {
            $queryReparto = DB::select("SELECT nome FROM reparto WHERE id = $prestazione->idReparto");
            $querySala = DB::select("SELECT identificativo FROM sala WHERE id = $prestazione->idSala");
            $queryPaziente = DB::select("SELECT nome,cognome,codiceFiscale,attivo FROM utente JOIN paziente ON utente.id = paziente.id");
            $queryStaff = DB::select("SELECT identificativo FROM staff JOIN staff_prestazione ON staff.id = staff_prestazione.idStaff 
                WHERE staff_prestazione.idPrestazione = $prestazione->id");
            $queryFarmaci = DB::select("SELECT nome FROM farmaco JOIN farmaco_prestazione ON farmaco_prestazione.idFarmaco = farmaco.id
                WHERE farmaco_prestazione.idPrestazione = $prestazione->id ");  
            array_push($reparti,$queryReparto);
            array_push($sale,$querySala);
            array_push($pazienti,$queryPaziente);
            array_push($staff,$queryStaff);
            array_push($farmaci,$queryFarmaco);
        }

        return view('elencoPrestazioni',[
            'prestazioni' => $query, 
            'reparti' => $reparti, 
            'sale' => $sale,
            'staff' => $staff,
            'farmaci' => $farmaci,
            'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $search = request('search');
        
        $query = DB::select("SELECT * FROM prestazione
            JOIN paziente ON utente.id = paziente.id
            WHERE utente.attivo = 1 AND
            (CONCAT(nome, ' ', cognome) LIKE '$search%' OR 
            CONCAT(cognome, ' ', nome) LIKE '$search%' OR
            codiceFiscale LIKE '$search%')");
        $ruolo = Utente::trovaRuolo(Auth::id());

        return view('prestazione',['pazienti' => $query, 'ruolo' => $ruolo]);
    }

    //mostro il form per creare/modificare una prestazione
    public function create() {
        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('aggiungiPrestazione',['ruolo' => $ruolo]);
    }

    //salvo i dati di una nuova prestazione
    public function store(Request $request) {
        return redirect('/elencoPrestazioni')->with('status','Prestazione creata con successo');        
    }

    //per il dettaglio prestazione
    public function show($id) {
        $query = DB::select("SELECT * FROM prestazione");
        $ruolo = Utente::trovaRuolo(Auth::id());
        $reparti = [];
        $sale = [];
        $pazienti = [];
        $staff = [];
        $farmaci = [];

        foreach($query as $prestazione) {
            $queryReparto = DB::select("SELECT nome FROM reparto WHERE id = $prestazione->idReparto");
            $querySala = DB::select("SELECT identificativo FROM sala WHERE id = $prestazione->idSala");
            $queryPaziente = DB::select("SELECT nome,cognome,codiceFiscale,attivo FROM utente JOIN paziente ON utente.id = paziente.id");
            $queryStaff = DB::select("SELECT identificativo FROM staff JOIN staff_prestazione ON staff.id = staff_prestazione.idStaff 
                WHERE staff_prestazione.idPrestazione = $prestazione->id");
            $queryFarmaci = DB::select("SELECT nome FROM farmaco JOIN farmaco_prestazione ON farmaco_prestazione.idFarmaco = farmaco.id
                WHERE farmaco_prestazione.idPrestazione = $prestazione->id ");  
            array_push($reparti,$queryReparto);
            array_push($sale,$querySala);
            array_push($pazienti,$queryPaziente);
            array_push($staff,$queryStaff);
            array_push($farmaci,$queryFarmaco);
        }

        return view('mostraPrestazione',[
            'prestazioni' => $query, 
            'reparti' => $reparti, 
            'sale' => $sale,
            'staff' => $staff,
            'farmaci' => $farmaci,
            'ruolo' => $ruolo]);
        
    }

    //modfico la prestazione
    public function edit($id) {
        
    }

    //aggiorno una prestazione
    public function update(Request $request, $id) {

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
