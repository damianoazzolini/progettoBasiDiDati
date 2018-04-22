<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ruolo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Utente extends Model
{
    protected $table = 'utente';

    public function roles()
    {
        return $this->belongsToMany('App\Role','utente_role','user_id','role_id');
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || 
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) || 
                abort(401, 'This action is unauthorized.');
    }

  
    public function hasAnyRole($roles) {
        //return null !== $this->roles()->whereIn('nome', $roles)->first();
        if(is_array($roles)) {
            foreach($roles as $role) {
                if($this->hasRole($role)) {
                    return true;
                }
            }
        }
        else{
            if($this->hasRole($roles)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole($role) {
        //return null !== $this->roles()->where('nome', $role)->first();
        if($this->roles()->where('name',$role)->first()) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function trovaRuolo($id) {
        $ruoloID = DB::table('utente_role')->where('user_id', $id)->value('role_id');
        $ruolo = DB::table('roles')->where('id',$ruoloID)->value('name');
        return $ruolo;
    }
}
