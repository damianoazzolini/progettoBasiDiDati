<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Commento;
use App\Reazione;
class Post extends Model
{
    protected $table= 'post';
    protected $primaryKey = 'postID';

    public function commenti(){
    	return $this->hasMany('App\Commento', 'postID', 'postID')->where('attivo','=','1');
    }
    public function reazioni(){
    	return $this->hasMany('App\Reazione', 'postID', 'postID')->where('flag','=','1');
    }

    private function probabilitaParola($parola,$samples,$labels) {
            
        $numberOfSamples = count($samples);

        $numeroElementiSpam = 0;
        $numeroElementiHam = 0;

        for($i = 0; $i < $numberOfSamples; $i++) {
            if($labels[$i] == 0) {
                $numeroElementiHam++;
            }
            else if($labels[$i] == 1) {
                $numeroElementiSpam++;
            }		
        }
    
        $probSpam = $numeroElementiSpam/$numberOfSamples;
        $probHam = $numeroElementiHam/$numberOfSamples;
        $parolaSpam = 0;
        $probSpamParola = 0;
        $occorrenzeParola = 0;
    
        for($i = 0; $i < $numberOfSamples; $i++) {
            if($labels[$i] == 1 && $samples[$i] == $parola) {
                $parolaSpam++;
            }
            if($samples[$i] == $parola) {
                $occorrenzeParola++;
            }
        }
    
        $probSpamParola = $parolaSpam/$numeroElementiSpam;
    
        if($occorrenzeParola > 0) {
            $probParola = $occorrenzeParola/$numberOfSamples;
            $probSpam = $probSpamParola*$probSpam/$probParola; 
        }
        else {
            $probSpam = 1;
        }
    
        return $probSpam;
    }

    public function checkSpam($stringa) {        
        //piccolo database di prova
        //il database deve essere unbiased cioè il numero di
        //elementi spam deve essere uguale al numero di elementi
        //non spam per non far nessuna assunzione a priori
        
        $samples = array(	'credito','credito','credito','credito',
                            'ciao','ciao','ciao','ciao',
                            'soldi','soldi',
                            'bene','bene','bene',
                            'nigeria','nigeria','nigeria','nigeria',
                            'viaggio','viaggio','viaggio');
        //1 spam, 0 ham                    
        $labels = array(	'1','1','1','0',
                            '0','1','0','0',
                            '1','1',
                            '0','0','0',
                            '1','1','1','0',
                            '0','0','0');
                            
        $numberOfSamples = count($samples);
        
        
        //$stringa = "Il re della Nigeria vuole regalarti dei soldi";
        $parole = explode(" ",$stringa);	
        
        $numeroParoleFrase = count($parole);
        
        $probNum = 1;
        $probDen = 1;
        $soglia = 0.5;
        
        for($i = 0; $i < $numeroParoleFrase; $i++) {
            $parole[$i] = strtolower($parole[$i]);
        }
        
        for($i = 0; $i < $numeroParoleFrase; $i++) {
            $tempProb = $this->probabilitaParola($parole[$i],$samples,$labels);
            $probNum = $probNum*$tempProb;
            if($tempProb != 1) {
                $probDen = $probDen*(1 - $tempProb);
            }
        }
        
        $probabilitaSpamComplessiva = $probNum/($probNum + $probDen);
             
        if($probabilitaSpamComplessiva > $soglia) {
            return "Il post è stato contrassegnato come spam";
        }
        else {
            return $stringa;
        }
    }
}
