<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Amicizia;
use App\Utente;
use App\Notifica;
use App\SegueAmministra;
use DB;

class SegueAmministraController extends Controller
{
    public function index() {
        $pagine = SegueAmministra::get_pages();
        if($pagine == null) $empty = 1; else $empty = 0;
        return view('pagina.pagine', ['pagine' => SegueAmministra::paginate($pagine,'10'), 'empty' => $empty, 'messaggio' => 'Non segui o amministri pagine']);
    }

    public function button(Request $request) {
        $utenteID1 = Auth::id();
        $utenteID2 = request('value');
        $amicizia = Amicizia::find_friendship($utenteID1, $utenteID2);
        echo Amicizia::create_button($amicizia, $utenteID2);
    }

    public function nuova(Request $request) {
        $utenteID = Auth::id();
        $paginaID = request('value');
        if (SegueAmministra::find_segueAmministra($utenteID, $paginaID) == null)
            $result = SegueAmministra::new_segueAmministra($utenteID, $paginaID, 'segue');
        else
            $result = SegueAmministra::update_segueAmministra($utenteID, $paginaID, 'segue');
            //Notifica::genera_notifica_amicizia($utenteID2,$utenteID1);
            echo SegueAmministra::create_button($result, $paginaID);
    }

    public function cancella(Request $request) {
        $utenteID = Auth::id();
        $paginaID = request('value');
        SegueAmministra::delete_segueAmministra($utenteID, $paginaID);
        echo SegueAmministra::create_button(null, $paginaID);
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
