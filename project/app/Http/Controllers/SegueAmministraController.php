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

        if ($type != 'seguite' && $type != 'tutte') return redirect()->action('SegueAmministraController@index');
        else if ($type == 'seguite') $pagine = SegueAmministra::search_seguite($search);
        else $pagine = SegueAmministra::search_pages($search);
        if($pagine == null) $empty = 1; else $empty = 0;
        
        $messaggio = "";
        if ($empty){
            if($type == 'tutte') $messaggio = "La ricerca di " . strtoupper($search) . " fra tutte le pagine di Harambe non ha prodotto risultati";
            else if ($type == 'seguite') $messaggio = "La ricerca di " . strtoupper($search) . " fra le pagine che segui non ha prodotto risultati";
        }
        return view('pagina.pagine', ['pagine' => SegueAmministra::paginate($pagine,'10'), 'empty' => $empty, 'messaggio' => $messaggio]);
    }
}
