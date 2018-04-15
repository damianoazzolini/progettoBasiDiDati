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
            $queryPaziente = DB::select("SELECT nome,cognome FROM utente WHERE id=$prestazione->idPaziente");
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
       
        $request->validate([
            'identificativoReparto' => 'required',
            'identificativoSala' => 'required',
            'data' => 'required',
            'ora' => 'required',
            'durata' => 'required',
            'identificativo' => 'required',
            'nomePaziente' => 'required',
            'cognomePaziente' => 'required',
            'codiceFiscale' => 'required',
            'nomeStaff' => 'required',
            'cognomeStaff' => 'required',
        ]);

        
        //$idReparto = DB::select("SELECT id FROM reparto WHERE nome=$request->input('nomeReparto')");
        $idReparto = DB::table('reparto')->where('nome',$request->input('identificativoReparto'))->pluck('id')->first();
        if($idReparto == [])
            return redirect()->back()->with('status', 'Reparto inesistente');
        
        //controllo che la sala sia assegnata al reparto
        //$nomeSala = DB::select("SELECT nome FROM sala WHERE idReparto=$idReparto");
        $idSala = DB::table('sala')->where('idReparto',$idReparto)->pluck('id')->first();
        /*
        $found = false;
        foreach ($nomeSala as $sala) {
            if($nomeSala == $request->input('identificativoSala')) {
                $found = true;
                break;
            }
        }
        if($found == false)
            return redirect()->back()->with('status', 'Sala non assegnata al reparto');
        */

        //controllo se il nome paziente esiste
        $nome = request('nomePaziente');
        $cognome = request('cognomePaziente');
        $cf = request('codiceFiscale');
        $idUtente = DB::table('utente')->where('nome',$nome)->where('cognome',$cognome)->where('codiceFiscale',$cf)->where('attivo',1)->pluck('id')->first();
        //$idUtente = DB::select("SELECT id FROM utente 
        //    WHERE nome='$nome' AND cognome='$cognome' AND codiceFiscale='$cf' AND attivo=1");
        if($idUtente == null || $idUtente == [])
            return redirect()->back()->with('status', 'Utente inesistente');
        
        //controllo se il paziente esiste
        $query = DB::select("SELECT altezza FROM paziente
            JOIN utente ON utente.id = paziente.id
            WHERE utente.attivo = 1 AND utente.id=$idUtente");
        if($query === null || $query == [])
            return redirect()->back()->with('status', 'Utente scelto non è un paziente');

        //controllo se il componente dello staff esista
        $nomeStaff = request('nomeStaff');
        $cognomeStaff = request('cognomeStaff');
        /*
        $idStaff = DB::table('utente')
            ->where('nome',$nomeStaff)
            ->where('cognome',$cognomeStaff)
            ->where('attivo',1)
            ->whereNotIn('id', function($q) {
                $q->select('id')->from('paziente');
            })->first();
        */
        $idStaff = DB::table('utente')
            ->where('nome',$nomeStaff)
            ->where('cognome',$cognomeStaff)
            ->where('attivo',1)
            ->pluck('id')
            ->first();
            /*
        $idStaff = DB::select("SELECT id FROM utente 
            WHERE nome = '$nomeStaff' AND cognome = '$cognomeStaff' AND attivo=1 
            AND id NOT IN (SELECT id FROM paziente)");
        */
        if($idStaff == null || $idStaff == [])
            return redirect()->back()->with('status', 'Componente dello staff inesistente');
        
        //controllo che non ci sia una prestazione alla stessa ora nella stessa sala dello stesso reparto
        $dataPrestazione = request('data');
        $elencoPrestazioni = DB::table('prestazione')
            ->where('data',$dataPrestazione)
            ->where('idReparto',$idReparto)
            ->where('idSala',$idSala)
            ->select('ora','durata')
            ->get();

        foreach ($elencoPrestazioni as $prest) {
            $endTime = strtotime($prest->ora) + $prest->durata;
            if($endTime > request('ora'))
                return redirect()->back()->with('status', 'Slot orario già occupato');
        }

        //controllo che il medico non sia già occupato alla stessa ora

        //controllo che il paziente non sia già occupato alla stessa ora
        
        
        //inserisco la prestazione
        $prestazione = new Prestazione();
        $prestazione->idReparto = $idReparto;
        $prestazione->idSala = $idSala;
        $prestazione->idPaziente = $idUtente;
        $prestazione->note = request('note');
        $prestazione->attivo = '1';
        $prestazione->effettuata = '0';
        $prestazione->data = request('data');
        $prestazione->ora = request('ora');
        $prestazione->durata = request('durata');
        $prestazione->identificativo = request('identificativo');        
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
        $prestazione = DB::table('prestazione')->where('id',$id)->get()->first();
        $ruolo = Utente::trovaRuolo(Auth::id());
        
               
        //$queryReparto = DB::select("SELECT nome FROM reparto WHERE id = $prestazione->idReparto");
        $queryReparto = DB::table('reparto')->where('id',$prestazione->idReparto)->pluck('nome')->first();
        //$querySala = DB::select("SELECT nome FROM sala WHERE id = $prestazione->idSala");
        $querySala = DB::table('sala')->where('id',$prestazione->idSala)->pluck('nome')->first();
        //$queryPaziente = DB::select("SELECT nome,cognome,codiceFiscale,attivo FROM utente JOIN paziente ON utente.id = paziente.id");
        $queryPaziente = DB::table('utente')
            ->join('paziente','utente.id','=','paziente.id')
            ->select('utente.nome','utente.cognome','utente.codiceFiscale','utente.attivo')
            ->get();
        
        //$idStaff = DB::select("SELECT id FROM staff JOIN staff_prestazione ON staff.id = staff_prestazione.idStaff 
        //    WHERE staff_prestazione.idPrestazione = $prestazione->id");
        $idStaff = DB::table('staff')
            ->join('staff_prestazione','staff.id','=','staff_prestazione.idStaff')
            ->where('staff_prestazione.idPrestazione',$prestazione->id)
            ->select('staff.id')
            ->get();

        $queryStaff = [];//seleziono nome cognome dagli utenti con quell'id
        foreach($idStaff as $elementoStaff) {
            //$nomeCognome = DB::select("SELECT nome, cognome FROM utente WHERE id=$elementoStaff");
            $nomeCognome = DB::table('utente')->where('id',$elementoStaff->id)->pluck('nome','cognome')->first();
            array_push($queryStaff,$nomeCognome);
        }

        //$queryFarmaci = DB::select("SELECT nome FROM farmaco JOIN farmaco_prestazione ON farmaco_prestazione.idFarmaco = farmaco.id
        //    WHERE farmaco_prestazione.idPrestazione = $prestazione->id ");  
        
        $queryFarmaci = DB::table('farmaco')
            ->join('farmaco_prestazione','farmaco_prestazione.idFarmaco', '=', 'farmaco.id')
            ->where('farmaco_prestazione.idPrestazione',$prestazione->id)
            ->select('farmaco.nome')
            ->get();

        return view('mostraPrestazione',[
            'prestazione' => $prestazione, 
            'reparto' => $queryReparto, 
            'sala' => $querySala,
            'paziente' => $queryPaziente,
            'staff' => $queryStaff,
            'farmaci' => $queryFarmaci,
            'ruolo' => $ruolo]);
    }

    //modfico la prestazione - UGUALE A SHOW :(
    public function edit($id) {
        $prestazione = DB::table('prestazione')->where('id',$id)->get()->first();
        $ruolo = Utente::trovaRuolo(Auth::id());
        
               
        //$queryReparto = DB::select("SELECT nome FROM reparto WHERE id = $prestazione->idReparto");
        $queryReparto = DB::table('reparto')->where('id',$prestazione->idReparto)->pluck('nome')->first();
        //$querySala = DB::select("SELECT nome FROM sala WHERE id = $prestazione->idSala");
        $querySala = DB::table('sala')->where('id',$prestazione->idSala)->pluck('nome')->first();
        //$queryPaziente = DB::select("SELECT nome,cognome,codiceFiscale,attivo FROM utente JOIN paziente ON utente.id = paziente.id");
        $queryPaziente = DB::table('utente')
            ->join('paziente','utente.id','=','paziente.id')
            ->select('utente.nome','utente.cognome','utente.codiceFiscale','utente.attivo')
            ->get();
        
        //$idStaff = DB::select("SELECT id FROM staff JOIN staff_prestazione ON staff.id = staff_prestazione.idStaff 
        //    WHERE staff_prestazione.idPrestazione = $prestazione->id");
        $idStaff = DB::table('staff')
            ->join('staff_prestazione','staff.id','=','staff_prestazione.idStaff')
            ->where('staff_prestazione.idPrestazione',$prestazione->id)
            ->select('staff.id')
            ->get();

        $queryStaff = [];//seleziono nome cognome dagli utenti con quell'id
        foreach($idStaff as $elementoStaff) {
            //$nomeCognome = DB::select("SELECT nome, cognome FROM utente WHERE id=$elementoStaff");
            $nomeCognome = DB::table('utente')->where('id',$elementoStaff->id)->pluck('nome','cognome')->first();
            array_push($queryStaff,$nomeCognome);
        }

        //$queryFarmaci = DB::select("SELECT nome FROM farmaco JOIN farmaco_prestazione ON farmaco_prestazione.idFarmaco = farmaco.id
        //    WHERE farmaco_prestazione.idPrestazione = $prestazione->id ");  
        
        $queryFarmaci = DB::table('farmaco')
            ->join('farmaco_prestazione','farmaco_prestazione.idFarmaco', '=', 'farmaco.id')
            ->where('farmaco_prestazione.idPrestazione',$prestazione->id)
            ->select('farmaco.nome')
            ->get();

        return view('modificaPrestazione',[
            'prestazione' => $prestazione, 
            'reparto' => $queryReparto, 
            'sala' => $querySala,
            'paziente' => $queryPaziente,
            'staff' => $queryStaff,
            'farmaci' => $queryFarmaci,
            'ruolo' => $ruolo]);
    }

    //aggiorno una prestazione
    public function update(Request $request, $id) {

    }

    public function destroy($id) {
        DB::table('prestazione')->where('id', $id)->update(['attivo' => 0]);
        return redirect('/elencoPrestazioni')->with('status','Prestazione cancellata con successo');  
    }

    //SISTEMARE NON VA
    public static function salaAutocomplete(){
        $search = request('term');
        $reparto = request('reparto');
        $idReparto = DB::select("SELECT id FROM reparto WHERE nome='$reparto'");
        $results = array();
        $sale = DB::select("SELECT nome FROM sala WHERE nome LIKE '$search%'");// AND idReparto='$idReparto'");
        foreach ($sale as $sala) $results[] = ['value' => $sala->nome];
        if(count($results)) return $results;
        else return ['value'=>'Nessuna sala trovata'];
        
    }

    public static function repartoAutocomplete(){
        $search = request('term');
        $results = array();
        $reparti = DB::select("SELECT identificativo FROM reparto WHERE identificativo LIKE '$search%'");
        foreach ($reparti as $reparto) $results[] = ['value' => $reparto->identificativo];
        if(count($results)) return $results;
        else return ['value'=>'Nessun reparto trovato'];
    }

    public static function cfAutocomplete() {
        $nome = request('nome');
        $cognome = request('cognome');
        $results = array();
        $codici = DB::select("SELECT codiceFiscale FROM utente WHERE nome LIKE '$nome%' AND cognome LIKE '$cognome%'");
        foreach ($codici as $codice) $results[] = ['value' => $codice->cf];
        if(count($results)) return $results;
        else return ['value'=>'Nessun cf trovato'];
    }

    //INSERIRE AJAX PER IL CF
}
