<?php

namespace App;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SegueAmministra extends Model
{
    protected $table= 'segueAmministra';
    protected $primaryKey=array('utenteID', 'paginaID');
    public $incrementing=false;

    static public function get_pages(){
        $id = Auth::id();
        $db = DB::select("SELECT * FROM pagina, segueAmministra
            WHERE segueAmministra.utenteID = $id 
            AND pagina.paginaID = segueAmministra.paginaID
            AND pagina.attivo = 1");
        return $db;
    }

    static public function find_segueAmministra($utenteID, $paginaID){
        $db = SegueAmministra::where('utenteID', '=', $utenteID)
            ->where('paginaID', '=', $paginaID)  
            ->first();
        return $db;
    }

    static public function new_segueAmministra($utenteID, $paginaID, $stato){
        $record = new SegueAmministra;
        $record->utenteID = $utenteID;
        $record->paginaID = $paginaID;
        $record->stato = $stato;
        $record->save();
        return $record;
    } 

    static public function delete_segueAmministra($utenteID, $paginaID){
        SegueAmministra::where('utenteID', $utenteID)
        ->where('paginaID', $paginaID)
        ->delete();
    }
        
    static public function update_segueAmministra($utenteID, $paginaID, $stato){
        SegueAmministra::where('utenteID', $utenteID)
        ->where('paginaID', $paginaID)
        ->update(['stato' => $stato]);
        return SegueAmministra::find_segueAmministra($utenteID, $paginaID);
    }

    static public function create_button($record, $paginaID){
        if($record == null){
            return '<button value="'. $paginaID .'" class="bottone pagina nuova" id="button-nuova'. $paginaID .'">Segui</button>';
        }
        else if($record->stato == 'segue') { 
            return '<button value="'. $paginaID .'" class="bottone pagina elimina" id="button-elimina'. $paginaID .'">Non seguire</button>';
        }
    }

    static public function search_users($search){
        $id = Auth::id();
        $db = DB::select("SELECT * FROM utente 
            LEFT JOIN (SELECT * FROM amicizia 
			    WHERE utenteID1 = $id OR utenteID2 = $id) AS filtered 
                ON (utenteID = utenteID1 OR utenteID = utenteID2) 
            WHERE (CONCAT(nome, ' ', cognome) LIKE '$search%' OR 
            CONCAT(cognome, ' ', nome) LIKE '$search%')
            AND utenteID != $id 
            AND attivo = 1
            AND (stato IS NULL OR stato = 'accettata' OR stato = 'sospesa' 
                OR (utenteID1 = $id AND stato = 'bloccata1') 
                OR (utenteID2 = $id AND stato = 'bloccata2'))
            ORDER BY filtered.updated_at DESC");
        $db_updated = Amicizia::update_stato($db,$id);
        return $db_updated;
    }

    static public function search_friend($search){
        $id = Auth::id();
        $db = DB::select("SELECT * FROM utente 
            LEFT JOIN (SELECT * FROM amicizia 
			    WHERE utenteID1 = $id OR utenteID2 = $id) AS filtered 
                ON (utenteID = utenteID1 OR utenteID = utenteID2) 
            WHERE (CONCAT(nome, ' ', cognome) LIKE '$search%' OR 
            CONCAT(cognome, ' ', nome) LIKE '$search%')
            AND utenteID != $id 
            AND attivo = 1
            AND stato = 'accettata' 
            ORDER BY filtered.updated_at DESC");
        $db_updated = Amicizia::update_stato($db,$id);
        return $db_updated;
    }

    static public function paginate($items,$perPage){
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($items);
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        return new LengthAwarePaginator($currentPageSearchResults, count($col), 
            $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()]);
    }
}
