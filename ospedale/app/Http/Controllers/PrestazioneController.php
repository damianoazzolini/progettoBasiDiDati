<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Utente;
use App\Role;
use App\Prestazione;
use App\StaffPrestazione;
use App\Staff;


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
        /* reparto sala data ora nomePaziente cognomePaziente codiceFiscale nomeStaff cognomeStaff note durata */
        //necessito di tutti i campi
        foreach ($request->except('_token') as $data => $value) {
            $valids[$data] = "required";
        }
        $request->validate($valids);
        
        $idReparto = DB::select("SELECT id FROM reparto WHERE nome = $request->nomeReparto");
        if($idReparto === null)
            return redirect()->back()->withErrors(['msg', 'Reparto inesistente']);
        
        //controllo che la sala sia ssegnata al reparto
        $descrizioneSala = DB::select("SELECT descrizione FROM sala WHERE idReparto = $idReparto");
        if($descrizioneSala === null)
            return redirect()->back()->withErrors(['msg', 'Sala non assegnata al reparto']);
        
        //controllo se il nome paziente esiste
        $idUtente = DB::select("SELECT id FROM utente 
            WHERE nome = $request->nomePaziente AND cognome = $request->cognomePaziente AND codiceFiscale = $request->codiceFiscale AND attivo = 1");
        if($idUtente === null)
            return redirect()->back()->withErrors(['msg', 'Utente inesistente']);
        
        //controllo se il paziente esiste
        $query = DB::select("SELECT altezza FROM paziente
            JOIN utente ON utente.id = paziente.id
            WHERE utente.attivo = 1 AND utente.id = $idUtente");
        if($query === null)
            return redirect()->back()->withErrors(['msg', 'Utente scelto non è un paziente']);

        //controllo se il componente dello staff esiste e che non sia un paziente
        $idStaff = DB::select("SELECT id FROM utente 
            WHERE nome = $request->nomeStaff AND cognome = $request->cognomeStaff AND attivo = 1 
            AND id NOT IN (SELECT id FROM paziente WHERE attivo = 1)");
        if($idStaff === null)
            return redirect()->back()->withErrors(['msg', 'Componente dello staff inesistente']);
        
        //controllo che non ci sia una prestazione alla stessa ora nella stessa sala dello stesso reparto
        $prestazione = DB::select("SELECT id FROM prestazione 
            WHERE idReparto = $idReparto AND idSala = $request->idSala AND ora = $request->ora AND data = $request->data");
        if($prestazione != null)
            return redirect()->back()->withErrors(['msg', 'Esiste già una prestazione alla stessa ora nella stessa sala alla stessa data']);
        
        //controllare se c'è una prestazione che finisce dopo che una è iniziata nella stessa sala   
        /*     
        $inizioPrestazione = DB::select("SELECT ora FROM prestazione 
            WHERE idReparto = $idReparto AND idSala = $request->idSala AND data = $request->data");
        $durataPrestazione = DB::select("SELECT durata FROM prestazione 
            WHERE idReparto = $idReparto AND idSala = $request->idSala AND data = $request->data");
        if($inizioPrestazione != null && $durataPrestazione != null) {
            for(int i = 0; i < count($inizioPrestazione)) {
            $endTime = DB::select(ADDTIME($inizioPrestazione[0],$durataPrestazione[0]));
            
        }
        */

        //inserisco la prestazione
        $prestazione = new Prestazione();
        $prestazione->idReparto = $idReparto;
        $prestazione->idSala = $Request->idSala;
        $prestazione->idPaziente = $idUtente;
        $prestazione->identificativo = $request->identificativo;
        $prestazione->note = $request->note;
        $prestazione->attivo = '1';
        $prestazione->effettuata = '0';
        $prestazione->data = $request->data;
        $prestazione->ora = $request->ora;
        $prestazione->durata = $request->durata;
        $prestazione->save();

        //inserisco staff prestazione
        $staff_prestazione = new StaffPrestazione();
        $staff_prestazione->idPrestazione = $prestazione->id;
        $staff_prestazione->idStaff = $idStaff;
        $staff_prestazione->save();

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
