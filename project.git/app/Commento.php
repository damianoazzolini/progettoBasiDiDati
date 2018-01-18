<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Utente;
use App\Post;
class Commento extends Model
{
    protected $table= 'commento';
    protected $primaryKey = 'commentoID';
    
    public function utente(){
    	
    	return $this->belongsTo('App\Utente', 'utenteID', 'utenteID');
    
    }
    public function post(){
    	return $this->belongsTo('App\Post', 'postID', 'postID');
    }
}
