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
        $utenti = Amicizia::get_friends();
        if($utenti == null) $empty = 1; else $empty = 0;
        return view('amici.amici', ['utenti' => Amicizia::paginate($utenti,'10'), 'empty' => $empty, 'messaggio' => 'Non hai ancora stretto amicizie']);
    }

    public function button(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');
        $amicizia = Amicizia::find_friendship($utenteID1, $utenteID2);
        echo Amicizia::create_button($amicizia, $utenteID2);
    }

    public function nuova(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');
        if (Amicizia::find_friendship($utenteID1, $utenteID2) == null) { 
            $amicizia = Amicizia::new_friendship($utenteID1, $utenteID2, 'sospesa');
            Notifica::genera_notifica_amicizia($utenteID2,$utenteID1);
            echo Amicizia::create_button($amicizia, $utenteID2);
        }
    }

    public function blocca(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');
        if(Amicizia::find_friendship($utenteID1, $utenteID2) == null)
            $amicizia = Amicizia::new_friendship($utenteID1, $utenteID2, 'bloccata1');
        else
            $amicizia = Amicizia::update_friendship($utenteID1, $utenteID2, 'blocca');
            echo Amicizia::create_button($amicizia, $utenteID2);
    }

    public function accetta(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');
        $amicizia = Amicizia::update_friendship($utenteID1, $utenteID2, 'accettata');
        Notifica::genera_notifica_amicizia($utenteID1,$utenteID2);
        echo Amicizia::create_button($amicizia, $utenteID2);
    }

    public function cancella(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');
        Amicizia::delete_friendship($utenteID1, $utenteID2);
        echo Amicizia::create_button(null, $utenteID2);
    }

    public function ricerca(Request $request) {
        $this->validate(request(), [
            'search' => 'required|min:2|max:64',
            'type' => 'required',
        ]);
        $search = request('search');
        $type = request('type');

        if ($type != 'amici' && $type != 'tutti') return redirect()->action('AmiciziaController@index');
        else if ($type == 'amici') $utenti = Amicizia::search_friend($search);
        else $utenti = Amicizia::search_users($search);
        if($utenti == null) $empty = 1; else $empty = 0;
        
        $messaggio = "";
        if ($empty){
            if($type == 'tutti') $messaggio = "La ricerca di " . strtoupper($search) . " fra tutti gli utenti di Harambe non ha prodotto risultati";
            else if ($type == 'amici') $messaggio = "La ricerca di " . strtoupper($search) . " fra i tuoi amici non ha prodotto risutlati";
        }
        return view('amici.amici', ['utenti' => Amicizia::paginate($utenti,'10'), 'empty' => $empty, 'messaggio' => $messaggio]);
    }

    public static function searchSuggest(){
        $id = Auth::id();
        $search = request('term');
        $results = array();
        $queries = Utente::search_n_utenti($search, 10);
        foreach ($queries as $query) $results[] = ['value' => $query->nome.' '.$query->cognome];
        if(count($results)) return $results;
        else return ['value'=>'Nessun elemento trovato'];
    }

}
