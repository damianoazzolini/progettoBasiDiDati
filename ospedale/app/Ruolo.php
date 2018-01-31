<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Utente;

class Ruolo extends Model
{
    protected $table = 'ruolo';

    public function users()
    {
        return $this->belongsToMany(Utente::class);
    }
}
