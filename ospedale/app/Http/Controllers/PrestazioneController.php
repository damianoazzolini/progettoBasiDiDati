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
        //restituisco solo paziente data ora effettuata attiva
        $prestazioni = DB::select("SELECT id, idPaziente, attivo, effettuata, data, ora FROM prestazione WHERE attivo=1");
        $pazienti = [];
        foreach ($prestazioni as $prestazione) {
            $queryPaziente = DB::select("SELECT nome,cognome FROM utente WHERE id=$prestazione->id");
            array_push($pazienti,$queryPaziente[0]);
        }

        $ruolo = Utente::trovaRuolo(Auth::id());
        return view('elencoPrestazioni',['prestazioni' => $prestazioni,'pazienti' => $pazienti ,'ruolo' => $ruolo]);
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
               
        $queryReparto = DB::select("SELECT nome FROM reparto WHERE id = $prestazione->idReparto");
        $querySala = DB::select("SELECT identificativo FROM sala WHERE id = $prestazione->idSala");
        $queryPaziente = DB::select("SELECT nome,cognome,codiceFiscale,attivo FROM utente JOIN paziente ON utente.id = paziente.id");
        $idStaff = DB::select("SELECT id FROM staff JOIN staff_prestazione ON staff.id = staff_prestazione.idStaff 
            WHERE staff_prestazione.idPrestazione = $prestazione->id");
        $queryStaff = [];//seleziono nome cognome dagli utenti con quell'id
        foreach($idStaff as $elementoStaff) {
            $nomeCognome = DB::select("SELECT nome, cognome FROM utente WHERE id=$elementoStaff");
            array_push($queryStaff,$nomeCognome[0]);
        }

        $queryFarmaci = DB::select("SELECT nome FROM farmaco JOIN farmaco_prestazione ON farmaco_prestazione.idFarmaco = farmaco.id
            WHERE farmaco_prestazione.idPrestazione = $prestazione->id ");  
        
        return view('mostraPrestazione',[
            'prestazione' => $query, 
            'reparto' => $queryReparto, 
            'sala' => $querySala,
            'paziente' => $queryPaziente,
            'staff' => $queryStaff,
            'farmaci' => $queryFarmaci,
            'ruolo' => $ruolo]);
    }

    //modfico la prestazione
    public function edit($id) {
        
    }

    //aggiorno una prestazione
    public function update(Request $request, $id) {

    }

    public function destroy($id) {
        DB::table('prestazione')->where('id', $id)->update(['attivo' => 0]);
        return redirect('/elencoPrestazioni')->with('status','Prestazione cancellata con successo');  
    }
}
