<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model {
    protected $table = 'pagina';
    protected $primaryKey = 'paginaID';
    public $timestamps = false; //togliere per aggiungere timestamp

}
