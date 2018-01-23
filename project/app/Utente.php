<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Notifiche;
use DB;

class Utente extends Model  
{
    protected $table = 'utente';
   
    protected $primaryKey = 'utenteID';
    /*
    public $utenteID;
    public $created_at;
    public $updated_at;
    public $nome;
    public $cognome;
    public $email;
    public $password;
    public $attivo;
    public $data;
    public $sesso;
    public $immagine;
    public $codice;*/

    public function get_nome_completo() {
        return $this->nome . " ". $this->cognome;
    }

    public function notifiche(){
    	return $this->hasMany('App\Notifica', 'utenteID', 'utenteID');
    }

    public static function search_n_utenti($search, $number){
        $id = Auth::id();
        return DB::table('utente')
            ->select('nome', 'cognome')
            ->distinct()
            ->where(DB::raw('CONCAT(nome, " ", cognome)'), 'LIKE', $search.'%')
            ->orwhere(DB::raw('CONCAT(cognome, " ", nome)'), 'LIKE', $search.'%')
            ->where('attivo', '=', 1)
            ->where('utenteID', '!=', $id)
            ->take($number)->get();
    }
}
