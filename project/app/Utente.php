<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Notifiche;

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
}
