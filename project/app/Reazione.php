<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Utente;
use App\Post;

class Reazione extends Model
{
    protected $table= 'reazione';
    protected $primaryKey = 'reazioneID';

    public function utente(){
    	return $this->belongsTo('App\Utente', 'utenteID', 'utenteID');
    }
     public function post(){
    	return $this->belongsTo('App\Post', 'postID', 'postID');
    }
}
