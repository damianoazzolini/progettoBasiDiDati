<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Amicizia;
use App\Utente;
use App\Notifica;
use App\SearchResult;
use DB;

class AmiciziaController extends Controller
{   
    public function index() {
        $id = Auth::id();
        $db = DB::table('utente')
            ->where('utenteID', '!=', $id) 
            ->where('attivo', '=', '1') 
            ->get();
        
        $utenti = array();
        $empty = 1; // Se 1 la ricerca non ha prodotto risultati
    
        foreach ($db as $user){
            $result = null;
            $result = Amicizia::where(function ($query) use ($user, $id){
                $query ->where('utenteID1', '=', $id)
                    ->orWhere('utenteID1', '=', $user->utenteID);
            })
            ->where(function ($query) use ($user, $id){
                $query ->where('utenteID2', '=', $id)
                    ->orWhere('utenteID2', '=', $user->utenteID);
            })
            ->first();
            
            $utente = new SearchResult;
            $utente->utenteID = $user->utenteID;
            $utente->nome = $user->nome;
            $utente->cognome = $user->cognome;
            $utente->immagine = $user->immagine;

            if($result == null){
                $utente->utenteID1 = null;
                $utente->utenteID2 = null;
                $utente->stato = 'richiedi';
            }
            else{
                $utente->utenteID1 = $result->utenteID1;
                $utente->utenteID2 = $result->utenteID2;
                if($result->stato == 'sospesa' && $result->utenteID1 == $id) $utente->stato = 'annulla';
                else if($result->stato == 'sospesa' && $result->utenteID2 == $id) $utente->stato = 'accetta';
                else if($result->stato == 'accettata')$utente->stato = 'rimuovi';
                else if($result->stato == 'bloccata1' && $result->utenteID1 == $id) $utente->stato = 'sblocca';
                else if($result->stato == 'bloccata2' && $result->utenteID2 == $id) $utente->stato = 'sblocca';
            }
            // Mostro solamente le amicizie accettate (non quelle bloccate)
            if($result != null && $result->stato == 'accettata') { $utenti[] = $utente; $empty = 0; }
        }
        
        return view('amici.amici', ['utenti' => SearchResult::paginate($utenti,'10'), 'empty' => $empty, 'messaggio' => 'Non hai ancora stretto amicizie']);
    }

    public function button(Request $request) {
        $id = Auth::id();
        $utenteID2 = request('value');
    
        $result = Amicizia::where(function ($query) use ($id, $utenteID2){
            $query ->where('utenteID1', '=', $id)
                ->orWhere('utenteID1', '=', $utenteID2);
        })
        ->where(function ($query) use ($id, $utenteID2){
            $query ->where('utenteID2', '=', $id)
                ->orWhere('utenteID2', '=', $utenteID2);
        })
        ->first();

        if($result == null){
            $output = '<button value="'. $utenteID2 .'" class="bottone amicizia nuova" id="button-nuova' . $utenteID2 .'">Aggiugi agli amici</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($result->stato == 'sospesa' && $result->utenteID1 == $id) { 
            $output = '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina' . $utenteID2 .'">Annulla richiesta</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($result->stato == 'sospesa' && $result->utenteID2 == $id) {
            $output = '<button value="'. $utenteID2 .'" class="bottone amicizia accetta" id="button-accetta' . $utenteID2 .'">Accetta amicizia</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($result->stato == 'accettata') {
            $output = '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina' . $utenteID2 .'">Elimina amicizia</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($result->stato == 'bloccata1' && $result->utenteID1 == $id) {
            $output = '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina'. $utenteID2 .'">Sblocca utente</button>';
        }
        else if($result->stato == 'bloccata2' && $result->utenteID2 == $id) {
            $output = '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina'. $utenteID2 .'">Sblocca utente</button>';
        }
        
        echo $output;
        
    }

    public function nuova(Request $request) {
        // Prendo l'ID dell'utente autenticato
        $utenteID1 = Auth::id();
        // Prendo l'ID dell'utente a cui voglio chiedere l'amicizia dalla GET
        $utenteID2 = request('value');

        // Cerco se esiste già una amicizia tra i due utenti nel DB
        $amicizia = Amicizia::where(function ($query) use ($utenteID1, $utenteID2){
            $query ->where('utenteID1', '=', $utenteID1)
            ->orWhere('utenteID1', '=', $utenteID2);
        })
        ->where(function ($query) use ($utenteID1, $utenteID2){
            $query ->where('utenteID2', '=', $utenteID1)
            ->orWhere('utenteID2', '=', $utenteID2);
        })    
        ->first();

        // Se non è presente una amicizia fra i due utenti inserisco una nuova riga
        if ($amicizia == null){
        $amicizia = new Amicizia;
        $amicizia->utenteID1 = $utenteID1;
        $amicizia->utenteID2 = $utenteID2;
        $amicizia->stato = 'sospesa';
        $amicizia->save();

        Notifica::genera_notifica_amicizia($utenteID2,$utenteID1);
        }

        $output = '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina' . $utenteID2 .'">Annulla richiesta</button>
        <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';

        echo $output;
    }

    public function blocca(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');

        $amicizia = Amicizia::where(function ($query) use ($utenteID1, $utenteID2){
            $query ->where('utenteID1', '=', $utenteID1)
            ->orWhere('utenteID1', '=', $utenteID2);
        })
        ->where(function ($query) use ($utenteID1, $utenteID2){
            $query ->where('utenteID2', '=', $utenteID1)
            ->orWhere('utenteID2', '=', $utenteID2);
        })    
        ->first();

        if ($amicizia == null){
        $amicizia = new Amicizia;
        $amicizia->utenteID1 = $utenteID1;
        $amicizia->utenteID2 = $utenteID2;
        $amicizia->stato = 'bloccata1';
        $amicizia->save();
        } else {
            // bloccata1 -> l'utenteID1 blocca l'utenteID2
            Amicizia::where('utenteID1', $utenteID1)
            ->where('utenteID2', $utenteID2)
            ->update(['stato' => 'bloccata1']);
            
             // bloccata2 -> l'utenteID2 blocca l'utenteID1
            Amicizia::where('utenteID1', $utenteID2)
            ->where('utenteID2', $utenteID1)
            ->update(['stato' => 'bloccata2']);            
        }

        $output = '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina'. $utenteID2 .'">Sblocca utente</button>';

        echo $output;
    }

    public function accetta(Request $request) {
        $utenteID1 = Auth::id();

        $utenteID2 = request('value');
        $stato = 'accettata';

        // Aggiorno lo stato in accettata sul DB
        Amicizia::where('utenteID1', $utenteID1)
            ->where('utenteID2', $utenteID2)
            ->update(['stato' => $stato]);
            
        Amicizia::where('utenteID1', $utenteID2)
            ->where('utenteID2', $utenteID1)
            ->update(['stato' => $stato]);

        Notifica::genera_notifica_amicizia($utenteID1,$utenteID2);
            
        $output = '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina' . $utenteID2 .'">Elimina amicizia</button>
        <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';

        echo $output;
    }

    public function cancella(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');

        Amicizia::where('utenteID1', $utenteID1)
            ->where('utenteID2', $utenteID2)
            ->delete();
            
        Amicizia::where('utenteID1', $utenteID2)
            ->where('utenteID2', $utenteID1)
            ->delete();

        $output = '<button value="'. $utenteID2 .'" class="bottone amicizia nuova" id="button-nuova' . $utenteID2 .'">Aggiungi agli amici</button>
        <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';

        echo $output;
    }

    public function ricerca(Request $request) {
        // Prendo l'ID dell'utente autenticato
        $id = Auth::id();

        // Valido la richiesta (deve contenere almeno un carattere)
        $this->validate(request(), [
            'search' => 'required|min:1',
        ]);
        $search = request('search');
        $type = request('type');

        if ($type == 'amici' || $type == 'tutti') {
            $db = Utente::where(DB::raw('CONCAT(nome, " ", cognome)'), 'LIKE', '%'.$search.'%')
            ->where('utenteID', '!=', $id)  
            ->where('attivo', '=', '1')
            ->get();
        }
        else {
            // ERRORE
            return redirect()->action('AmiciziaController@index');
        }

        $utenti = array();
        $empty = 1; // Se 1 la ricerca non ha prodotto risultati
        $messaggio = "";
        
        foreach ($db as $user){
            $result = null;
            $result = Amicizia::where(function ($query) use ($user, $id){
                $query ->where('utenteID1', '=', $id)
                    ->orWhere('utenteID1', '=', $user->utenteID);
            })
            ->where(function ($query) use ($user, $id){
                $query ->where('utenteID2', '=', $id)
                    ->orWhere('utenteID2', '=', $user->utenteID);
            })
            ->first();

            $utente = new SearchResult;
            $utente->utenteID = $user->utenteID;
            $utente->nome = $user->nome;
            $utente->cognome = $user->cognome;
            $utente->immagine = $user->immagine;

            if($result == null){
                $utente->utenteID1 = null;
                $utente->utenteID2 = null;
                $utente->stato = 'richiedi';
            }
            else{
                $utente->utenteID1 = $result->utenteID1;
                $utente->utenteID2 = $result->utenteID2;
                if($result->stato == 'sospesa' && $result->utenteID1 == $id) $utente->stato = 'annulla';
                else if($result->stato == 'sospesa' && $result->utenteID2 == $id) $utente->stato = 'accetta';
                else if($result->stato == 'accettata')$utente->stato = 'rimuovi';
                else if($result->stato == 'bloccata1' && $result->utenteID1 == $id) $utente->stato = 'sblocca';
                else if($result->stato == 'bloccata2' && $result->utenteID2 == $id) $utente->stato = 'sblocca';
            }

            if ($type == 'amici' || $type == 'index'){
                if($result != null && $result->stato == 'accettata') { $utenti[] = $utente; $empty = 0; }
            }
            else if ($type == 'tutti'){
                if($result == null || 
                $utente->stato == 'sblocca' ||
                $result->stato == 'accettata' ||
                $result->stato == 'sospesa') { $utenti[] = $utente; $empty = 0; }
            }
        }

        // Creo il messaggio di errore
        if ($empty){
            if($type == 'tutti') $messaggio = "La ricerca di " . strtoupper($search) . " fra tutti gli utenti di Harambe non ha prodotto risultati";
            else if ($type == 'amici') $messaggio = "La ricerca di " . strtoupper($search) . " fra i tuoi amici non ha prodotto risutlati";
        }

        return view('amici.amici', ['utenti' => SearchResult::paginate($utenti,'10'), 'empty' => $empty, 'messaggio' => $messaggio]);
    }

}
