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

    public static function subscribe($nomePagina) {
        $paginaID = DB::table('pagina')->where('nome',$nomePagina)->where('attivo','1')->pluck('paginaID');
        SegueAmministra::new_segueAmministra(Auth::id(),$paginaID[0],'segue');
    }

    public static function getPage($paginaID) {

    }

    public static function getPostsFromPage($paginaID) {

    }

    public static function getPageDescription($paginaID) {
        return DB::table('pagina')->where('paginaID',$paginaID)->pluck('descrizione');
    }

    public static function getPageImage($paginaID) {
        return DB::table('pagina')->where('paginaID',$paginaID)->pluck('immagine');
    }
}
