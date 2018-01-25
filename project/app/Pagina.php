<?php

namespace App;

use DB;
use SegueAmministra;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Pagina extends Model {
    protected $table = 'pagina';
    protected $primaryKey = 'paginaID';
    public $timestamps = false; 

    public static function newPage($nome,$tipo,$immagine,$descrizione) {
        if($immagine === null) {
            $immagine = 'default'; //fixare ASAP
        }
        
        $pagina = new Pagina;
        $pagina->nome = $nome;
        $pagina->descrizione = $descrizione;
        $pagina->immagine = $immagine;
        $pagina->tipo = $tipo;
        $pagina->attivo = 1;
        $pagina->save();
    }

    public static function subscribe($nome) {
        $paginaID = getPageID($nome);
        SegueAmministra::new_segueAmministra(Auth::id(),$paginaID[0],'segue');
    }

    public static function getPostsFromPageID($paginaID) {
        return DB::select(DB::raw("SELECT sum(flag) as likes, p.attivo, p.postID, p.utenteID, u.nome, u.cognome, u.immagine, "
        . "any_value(m.percorso) as percorso,p.created_at, p.contenuto 
        FROM utente as u 
        join post as p ON u.utenteID = p.utenteID 
        left join "
        . "media as m on p.postID = m.postID 
        left join reazione as r on p.postID = r.postID WHERE p.attivo = 1 and p.paginaID = $paginaID "
        . "GROUP BY postID ORDER BY p.created_at DESC; "));
        //return DB::table('post')->where('attivo','1')->where('paginaID',$paginaID);
    }

    public static function getPageDescription($paginaID) {
        return DB::table('pagina')->where('paginaID',$paginaID)->pluck('descrizione');
    }

    public static function getPageImage($paginaID) {
        return DB::table('pagina')->where('paginaID',$paginaID)->pluck('immagine');
    }

    public static function getPageType($paginaID) {
        return DB::table('pagina')->where('paginaID',$paginaID)->pluck('tipo');
    }

    public static function getPageID($nome) {
        $arr = DB::table('pagina')->where('nome',$nome)->where('attivo','1')->pluck('paginaID');
        return $arr[0];
    }

    public static function getPageName($id) {
        return DB::table('pagina')->where('paginaId',$id)->where('attivo','1')->pluck('nome');
    }

    public static function getListOfPageAdministrated($utenteID) {
        $elencoID = DB::table('segueAmministra')->where('utenteID',$utenteID)->pluck('paginaID');
        
        $i = 0;
        $elencoNomi = [];

        foreach($elencoID as $corrente) {
            $elencoNomi[$i] = Pagina::getPageName($corrente);
            $i++;
        }

        return $elencoNomi;
    }

    public static function isSubscribed($nome) {
        $paginaID = Pagina::getPageID($nome);
        //mettere controllo se utente attivo
        $stato = DB::table('segueAmministra')->where('paginaID',$paginaID)->where('utenteID', Auth::id())->pluck('stato');
        if($stato === null) {
            return 0;
        }
        else {
            return 1;
        }
    }
}
