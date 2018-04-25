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
use App\FarmacoPrestazione;
use App\Referto;

class PrestazioneController extends Controller {
    public function index() {
        //discrimino
        //paziente -> solo le sue
        //medico -> tutte
        //infermiere -> solo le sue
        //impiegato -> tutte
        //admin -> tutte

        $ruolo = Utente::trovaRuolo(Auth::id());
        $id = Auth::id();
        if($ruolo == "Amministratore" || $ruolo == "Medico" || $ruolo == "Impiegato") {
            $prestazioni = DB::select("SELECT id, idPaziente, attivo, effettuata, data, ora FROM prestazione WHERE attivo=1 ORDER BY created_at DESC");     
        }
        else if($ruolo == "Paziente") {
            $prestazioni = DB::select("SELECT id, idPaziente, attivo, effettuata, data, ora FROM prestazione WHERE attivo=1 AND idPaziente=$id");
        }
        else if($ruolo == "Infermiere") {
            $prestazioni = DB::select("SELECT id, idPaziente, attivo, effettuata, data, ora 
                FROM prestazione 
                JOIN staff_prestazione
                ON prestazione.id = staff_prestazione.idPrestazione
                WHERE prestazione.attivo=1 AND staff_prestazione.idStaff = $id");     
        }

        $pazienti = [];
        foreach ($prestazioni as $prestazione) {
            $queryPaziente = DB::select("SELECT nome,cognome FROM utente WHERE id=$prestazione->idPaziente");
            array_push($pazienti,$queryPaziente[0]);
        }
        
        return view('elencoPrestazioni',[
            'prestazioni' => $prestazioni,
            'pazienti' => $pazienti ,
            'ruolo' => $ruolo]);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
        ]);
        $search = request('search');

        $id = Auth::id();
        $ruolo = Utente::trovaRuolo(Auth::id());

        if($ruolo == "Amministratore" || $ruolo == "Medico" || $ruolo == "Impiegato" || $ruolo == "Infermiere") {
            $prestazioni = DB::select("SELECT * FROM prestazione
                JOIN utente ON utente.id = prestazione.idPaziente
                WHERE utente.attivo = 1 AND
                (CONCAT(nome, ' ', cognome) LIKE '$search%' OR 
                CONCAT(cognome, ' ', nome) LIKE '$search%' OR
                codiceFiscale LIKE '$search%')
                ORDER BY prestazione.created_at DESC");
        }
        $pazienti = [];
        foreach ($prestazioni as $prestazione) {
            $queryPaziente = DB::select("SELECT nome,cognome FROM utente WHERE id=$prestazione->idPaziente");
            array_push($pazienti,$queryPaziente[0]);
        }
       
        return view('elencoPrestazioni',['prestazioni' => $prestazioni,'pazienti' => $pazienti ,'ruolo' => $ruolo]);
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

        //inserisco anche un referto
        $referto = new Referto();
        $referto->idPaziente = $idUtente;
        $referto->id = $prestazione->id;
        $referto->esito = "Ancora da effettuare";
        $referto->save();

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
            ->where('staff_prestazione.idPrestazione',$id)
            ->select('staff.id')
            ->get();

        $queryStaff = [];//seleziono nome cognome dagli utenti con quell'id
        foreach($idStaff as $elementoStaff) {
            //$nomeCognome = DB::select("SELECT nome, cognome FROM utente WHERE id=$elementoStaff");
            $nomeCognome = DB::table('utente')->where('id',$elementoStaff->id)->select('nome','cognome','id')->first();
            array_push($queryStaff,$nomeCognome);
        }

        //$queryFarmaci = DB::select("SELECT nome FROM farmaco JOIN farmaco_prestazione ON farmaco_prestazione.idFarmaco = farmaco.id
        //    WHERE farmaco_prestazione.idPrestazione = $prestazione->id ");  
        
        $queryFarmaci = DB::table('farmaco')
            ->join('farmaco_prestazione','farmaco_prestazione.idFarmaco', '=', 'farmaco.id')
            ->where('farmaco_prestazione.idPrestazione',$prestazione->id)
            ->select('farmaco.nome')
            ->get();
            
        $queryReferto = [];
        if($ruolo != "Impiegato") {
            $queryReferto = DB::table('referto')
                ->where('id',$id)
                ->select('esito','note')
                ->first();
        }
        
        $idUtente = Auth::id();
        //medico può vedere in ogni caso la prestazione
        //infermiere solo a quelle a cui ha preso parte
        $presente = DB::table('staff_prestazione')
            ->where('idStaff',$idUtente)
            ->where('idPrestazione',$id)
            ->select('idStaff')
            ->first();

        if(($ruolo == "Infermiere" and $presente != []) || $ruolo == "Medico" || $ruolo == "Amministratore")
            $autorizzatoModficaFarmaci = true;
        else 
            $autorizzatoModficaFarmaci = false;

        if($ruolo == "Medico" || $ruolo == "Amministratore")
            $autorizzatoModificaPrestazione = true;
        else
            $autorizzatoModificaPrestazione = false;
       

        return view('mostraPrestazione',[
            'prestazione' => $prestazione, 
            'reparto' => $queryReparto, 
            'sala' => $querySala,
            'paziente' => $queryPaziente,
            'staff' => $queryStaff,
            'farmaci' => $queryFarmaci,
            'referto' => $queryReferto,
            'autorizzatoModificaPrestazione' => $autorizzatoModificaPrestazione,
            'autorizzatoModficaFarmaci' => $autorizzatoModficaFarmaci,
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
            ->where('staff_prestazione.idPrestazione',$id)
            ->select('staff.id')
            ->get();

        $queryStaff = [];//seleziono nome cognome dagli utenti con quell'id
        foreach($idStaff as $elementoStaff) {
            //$nomeCognome = DB::select("SELECT nome, cognome FROM utente WHERE id=$elementoStaff");
            $nomeCognome = DB::table('utente')->where('id',$elementoStaff->id)->select('nome','cognome')->first();
            array_push($queryStaff,$nomeCognome);
        }

        //$queryFarmaci = DB::select("SELECT nome FROM farmaco JOIN farmaco_prestazione ON farmaco_prestazione.idFarmaco = farmaco.id
        //    WHERE farmaco_prestazione.idPrestazione = $prestazione->id ");  
        
        $queryFarmaci = DB::table('farmaco')
            ->join('farmaco_prestazione','farmaco_prestazione.idFarmaco', '=', 'farmaco.id')
            ->where('farmaco_prestazione.idPrestazione',$prestazione->id)
            ->select('farmaco.nome')
            ->get();

        $queryReferto = DB::table('referto')
            ->where('id',$id)
            ->select('esito','note')
            ->first();

        return view('modificaPrestazione',[
            'prestazione' => $prestazione, 
            'reparto' => $queryReparto, 
            'sala' => $querySala,
            'paziente' => $queryPaziente,
            'staff' => $queryStaff,
            'farmaci' => $queryFarmaci,
            'referto' => $queryReferto,
            'ruolo' => $ruolo]);
    }

    //aggiorno una prestazione
    //posso cambiare identificativo, note
    public function update(Request $request, $id) {
        $identificativo = request('identificativo');//tipo
        $note = request('note');
        
        DB::statement("UPDATE prestazione SET identificativo = '$identificativo', 
                    note = '$note' WHERE id = $id");
        
        return redirect('/elencoPrestazioni')->with('status'.'Prestazione aggiornata');

    }

    public function destroy($id) {
        DB::table('prestazione')->where('id', $id)->update(['attivo' => 0]);
        return redirect('/elencoPrestazioni')->with('status','Prestazione cancellata con successo');  
    }

    //restituisco tutti gli elementi dello staff della prestazione
    public function showModificaStaff($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());
        $idStaff = DB::table('staff')
            ->join('staff_prestazione','staff.id','=','staff_prestazione.idStaff')
            ->where('staff_prestazione.idPrestazione',$id)
            ->select('staff.id')
            ->get();

        $queryStaff = [];//seleziono nome cognome dagli utenti con quell'id
        foreach($idStaff as $elementoStaff) {
            $nomeCognome = DB::table('utente')->where('id',$elementoStaff->id)->select('nome','cognome','id')->first();
            array_push($queryStaff,$nomeCognome);
        }

        return view('modificaStaffPrestazione',[
            'staff' => $queryStaff,
            'idPrestazione' => $id,
            'ruolo' => $ruolo
        ]);
    }

    public function addStaffPrestazione($id) {
        $idPrestazione = request('idPrestazione');
        $nomeStaff = request('nomeStaff');
        $cognomeStaff = request('cognomeStaff');

        $idStaff = DB::table('utente')
            ->join('staff','utente.id','=','staff.id')
            ->where('utente.nome',$nomeStaff)
            ->where('utente.cognome',$cognomeStaff)
            ->where('utente.attivo',1)
            ->pluck('utente.id')
            ->first();
        
        if($idStaff) {
            //controllo che non sia già presente
            $idStaffPrestazione = DB::table('staff_prestazione')
                ->where('idPrestazione',$idPrestazione)
                ->where('idStaff',$idStaff)
                ->pluck('idStaff')
                ->first();
            if($idStaffPrestazione == []) {
                $staff_prestazione = new StaffPrestazione();
                $staff_prestazione->idPrestazione = $idPrestazione;
                $staff_prestazione->idStaff = $idStaff;
                $staff_prestazione->save();
                return redirect()->back()->with('status','Aggiunto staff con successo');     
            }
            else
                return redirect()->back()->with('status', 'Componente dello staff già presente');
        }
        else {
            return redirect()->back()->with('status', 'Componente dello staff inesistente');
        }
    }

    public function deleteStaffPrestazione() {
        $idPrestazione = request('idPrestazione');
        $nomeStaff = request('nomeStaff');
        $cognomeStaff = request('cognomeStaff');

        $idStaff = DB::table('utente')
            ->where('nome',$nomeStaff)
            ->where('cognome',$cognomeStaff)
            ->where('attivo',1)
            ->pluck('id')
            ->first();
        
        $numeroElementiStaff = DB::table('staff_prestazione')
            ->where('idPrestazione',$idPrestazione)
            ->count();    
        
        if($idStaff && $numeroElementiStaff > 0) {
            DB::table('staff_prestazione')
                ->where('idStaff',$idStaff)
                ->where('idPrestazione',$idPrestazione)
                ->delete();

            return redirect()->back()->with('status','Rimosso staff con successo');
        }
        else {
            return redirect()->back()->with('status', 'Impossibile rimuovere elementi staff');
        }
    }

    public function showModificaFarmaci($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());
        $queryFarmaci = DB::table('farmaco')
            ->join('farmaco_prestazione','farmaco_prestazione.idFarmaco', '=', 'farmaco.id')
            ->where('farmaco_prestazione.idPrestazione',$id)
            ->select('farmaco.nome')
            ->get();

        return view('modificaFarmacoPrestazione',[
            'farmaci' => $queryFarmaci,
            'idPrestazione' => $id,
            'ruolo' => $ruolo
        ]);
    }

    public function addFarmacoPrestazione($id) {
        $idPrestazione = request('idPrestazione');
        $nomeFarmaco = request('nomeFarmaco');

        $idFarmaco = DB::table('farmaco')
            ->where('nome',$nomeFarmaco)
            ->pluck('id')
            ->first();
        
        if($idFarmaco) {
            $farmaco_prestazione = new FarmacoPrestazione();
            $farmaco_prestazione->idPrestazione = $idPrestazione;
            $farmaco_prestazione->idFarmaco = $idFarmaco;
            $farmaco_prestazione->save();

            return redirect()->back()->with('status','Aggiunto farmaco con successo');
        }
        else {
            return redirect()->back()->with('status', 'Farmaco inesistente');
        }
    }

    public function deleteFarmacoPrestazione() {
        $idPrestazione = request('idPrestazione');
        $nomeFarmaco = request('nomeFarmaco');

        $idFarmaco = DB::table('farmaco')
            ->where('nome',$nomeFarmaco)
            ->pluck('id')
            ->first();
        
        if($idFarmaco) {
            DB::table('farmaco_prestazione')
                ->where('idFarmaco',$idFarmaco)
                ->where('idPrestazione',$idPrestazione)
                ->delete();

            return redirect()->back()->with('status','Rimosso farmaco con successo');
        }
        else {
            return redirect()->back()->with('status', 'Impossibile rimuovere farmaco');
        }
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

    ///////REFERTO
    public function showFormReferto($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());
        $prestazione = DB::table('prestazione')->where('id',$id)->first();
        $queryReparto = DB::table('reparto')->where('id',$prestazione->idReparto)->pluck('nome')->first();
        $querySala = DB::table('sala')->where('id',$prestazione->idSala)->pluck('nome')->first();
        $idStaff = DB::table('staff')
            ->join('staff_prestazione','staff.id','=','staff_prestazione.idStaff')
            ->where('staff_prestazione.idPrestazione',$id)
            ->select('staff.id')
            ->get();

        $queryStaff = [];//seleziono nome cognome dagli utenti con quell'id
        foreach($idStaff as $elementoStaff) {
            //$nomeCognome = DB::select("SELECT nome, cognome FROM utente WHERE id=$elementoStaff");
            $nomeCognome = DB::table('utente')->where('id',$elementoStaff->id)->select('nome','cognome')->first();
            array_push($queryStaff,$nomeCognome);
        }

        $queryFarmaci = DB::table('farmaco')
            ->join('farmaco_prestazione','farmaco_prestazione.idFarmaco', '=', 'farmaco.id')
            ->where('farmaco_prestazione.idPrestazione',$prestazione->id)
            ->select('farmaco.nome')
            ->get();
            
        $paziente = DB::table('utente')
            ->where('id',$prestazione->idPaziente)
            ->select('nome','cognome','codiceFiscale')
            ->first();

        return view('referto',[
            'prestazione' => $prestazione,
            'paziente' => $paziente,
            'reparto' => $queryReparto,
            'sala' => $querySala,
            'farmaci' => $queryFarmaci,
            'staff' => $queryStaff,
            'ruolo' => $ruolo
        ]);
    }

    public function saveReferto() {
        $idPrestazione = request('idPrestazione');
        $esito = request('esito');
        $note = request('note');
        
        DB::statement("UPDATE referto SET esito = '$esito', 
                    note = '$note' WHERE id = '$idPrestazione'");
        DB::table('prestazione')->where('id', $idPrestazione)->update(['effettuata' => 1]);
        
        return redirect('/elencoPrestazioni')->with('status','Referto emesso con successo');       
    }

    public function visualizzaReferto($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());
        $referto = DB::table('referto')
            ->where('id',$id)
            ->select('esito','note')
            ->first();
        return view('mostraReferto',[
            'referto' => $referto,
            'ruolo' => $ruolo
        ]);
    }

}
