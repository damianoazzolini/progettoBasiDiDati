<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifica extends Model
{
    protected $table= 'notifica';
    protected $primaryKey = 'notificaID';

    static public function get_notifiche_amicizie_nonlette($utenteID)
    {
        $notifiche_amicizie_nonlette= static::where("utenteID",$utenteID)
                                	    ->where("tipo", "amicizia")
                                	    ->where("letta", 0)
                                	    ->get();
        return $notifiche_amicizie_nonlette;
    }

    static public function get_notifiche_amicizie_lette($utenteID)
    {

        $notifiche_amicizie_lette= static::where("utenteID",$utenteID)
                                	    ->where("tipo", "amicizia")
                                	    ->where("letta", 1)
                                	    ->get();
        return $notifiche_amicizie_lette;
    }

    public function relativa_a(){
        if($this->tipo==='commento'){
            return $this->hasOne('App\Commento', 'commentoID', 'tipoID');
        }
        elseif($this->tipo==='reazione'){
            return $this->hasOne('App\Reazione', 'reazioneID', 'tipoID');
        }
        elseif($this->tipo==='amicizia'){
            $num1=$this->tipoID;
            $num2=$this->utenteID;
            $righe=$this->hasMany('App\Amicizia', 'utenteID1', 'utenteID');
            $riga=$righe->where("utenteID2", $num1);
            foreach($riga as $r)
            {
                if($riga->utenteID1!==null)
                {
                    return $riga;
                }
            }
            $righe=$this->hasMany('App\Amicizia', 'utenteID1', 'tipoID');
            $riga=$righe->where("utenteID2", $num2);
            return $riga;
            
        }
    }
    static public function genera_notifica_amicizia($utenteID,$tipoID)
    {
        $notifica= static::where("utenteID",$utenteID)
                        ->where("tipo", "amicizia")
                        ->where("tipoID", $tipoID)
                        ->first();
        if($notifica!==null)
        {
            $notifica->letta=0;
            $notifica->save();
        }
        else{

            $notifica= new Notifica;
            $notifica->utenteID=$utenteID;
            $notifica->tipo='amicizia';
            $notifica->tipoID=$tipoID;
            $notifica->letta=0;
            $notifica->save();
        }

    }
    static public function genera_notifica_reazione($utenteID,$tipoID)
    {
        $notifica= static::where("utenteID",$utenteID)
                        ->where("tipo", "reazione")
                        ->where("tipoID", $tipoID)
                        ->first();
        if($notifica!==null)
        {
            $notifica->letta=0;
            $notifica->save();
        }
        else{

            $notifica= new Notifica;
            $notifica->utenteID=$utenteID;
            $notifica->tipo="reazione";
            $notifica->tipoID=$tipoID;
            $notifica->letta=0;
            $notifica->save();
        }

    }
}
