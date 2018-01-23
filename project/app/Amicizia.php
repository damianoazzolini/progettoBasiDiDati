<?php

namespace App;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Amicizia extends Model
{
    protected $table= 'amicizia';
    protected $primaryKey=array('utenteID1', 'utenteID2');
    public $incrementing=false;

    public function save(array $options = array())
	{
    if(!is_array($this->getKeyName()))
        return parent::save($options);

    // Fire Event for others to hook
    if($this->fireModelEvent('saving') === false)
        return false;

    // Prepare query for inserting or updating
    $query = $this->newQueryWithoutScopes();

    // Perform Update
    if ($this->exists) {
        if (count($this->getDirty()) > 0) {
            // Fire Event for others to hook
            if ($this->fireModelEvent('updating') === false)
                return false;

            // Touch the timestamps
            if ($this->timestamps)
                $this->updateTimestamps();

            //
            // START FIX
            //

            // Convert primary key into an array if it's a single value
            $primary = (count($this->getKeyName()) > 1) ? $this->getKeyName() : [$this->getKeyName()];

            // Fetch the primary key(s) values before any changes
            $unique = array_intersect_key($this->original, array_flip($primary));

            // Fetch the primary key(s) values after any changes
            $unique = !empty($unique) ? $unique : array_intersect_key($this->getAttributes(), array_flip($primary));

            // Fetch the element of the array if the array contains only a single element
            $unique = (count($unique) <> 1) ? $unique : reset($unique);

            // Apply SQL logic
            $query->where($unique);

            //
            // END FIX
            //

            // Update the records
            $query->update($this->getDirty());

            // Fire an event for hooking into
            $this->fireModelEvent('updated', false);
        }

    // Perform Insert
    } else {
        // Fire an event for hooking into
        if ($this->fireModelEvent('creating') === false)
            return false;

        // Touch the timestamps
        if ($this->timestamps)
            $this->updateTimestamps();

        // Retrieve the attributes
        $attributes = $this->attributes;

        if ($this->incrementing && !is_array($this->getKeyName()))
            $this->insertAndSetId($query, $attributes);
        else
            $query->insert($attributes);

        // Set exists to true in case someone tries to update it during an event
        $this->exists = true;

        // Fire an event for hooking into
        $this->fireModelEvent('created', false);
    }

    // Fires an event
    $this->fireModelEvent('saved', false);

    // Sync
    $this->original = $this->attributes;

    // Touches all relations
    if (array_get($options, 'touch', true))
        $this->touchOwners();

    return true;
	}

    static public function get_amicizie_inviate_sospese($utenteID1) {
        $amicizie_inviate= static::where("utenteID1",$utenteID1)
                ->where("stato", "sospesa")
                ->get();
	return $amicizie_inviate;
    }
    static public function get_amicizia_ricevuta_sospesa($utenteID1, $utenteID2) {
        $amicizia_ricevuta= static::where("utenteID1",$utenteID1)
                ->where("utenteID2", $utenteID2)
                ->where("stato", "sospesa")
                ->get();
	return $amicizia_ricevuta;
    }
    static public function get_amicizia_inviata_accettata($utenteID1, $utenteID2) {
        $amicizia_inviata= static::where("utenteID1",$utenteID1)
                ->where("utenteID2", $utenteID2)
                ->where("stato", "accettata")
                ->get();
	return $amicizia_inviata;
    }

    static public function get_friends(){
        $id = Auth::id();
        $db = DB::select("SELECT * FROM utente, amicizia
            WHERE (amicizia.utenteID1 = $id OR amicizia.utenteID2 = $id)
            AND (utente.utenteID = amicizia.utenteID1 OR utente.utenteID = amicizia.utenteID2)
            AND utente.utenteID != $id
            AND utente.attivo = 1
            AND amicizia.stato = 'accettata'");
        $db_updated = Amicizia::update_stato($db,$id);
        return $db_updated;
    }

    static function update_stato($utenti, $id){
        foreach($utenti as $utente){
            if($utente->stato == null) $utente->stato = 'richiedi';
            else if($utente->stato == 'accettata') $utente->stato = 'rimuovi';
            else if($utente->stato == 'sospesa' && $utente->utenteID1 == $id) $utente->stato = 'annulla';
            else if($utente->stato == 'sospesa' && $utente->utenteID2 == $id) $utente->stato = 'accetta';
            else if($utente->stato == 'bloccata1' && $utente->utenteID1 == $id) $utente->stato = 'sblocca';
            else if($utente->stato == 'bloccata2' && $utente->utenteID2 == $id) $utente->stato = 'sblocca';
        }
        return $utenti;
    }

    static public function find_friendship($utenteID1, $utenteID2){
        $amicizia = Amicizia::where(function ($query) use ($utenteID1, $utenteID2){
            $query ->where('utenteID1', '=', $utenteID1)
            ->orWhere('utenteID1', '=', $utenteID2);
        })
        ->where(function ($query) use ($utenteID1, $utenteID2){
            $query ->where('utenteID2', '=', $utenteID1)
            ->orWhere('utenteID2', '=', $utenteID2);
        })    
        ->first();
        return $amicizia;
    }

    static public function new_friendship($utenteID1, $utenteID2, $stato){
        $amicizia = new Amicizia;
        $amicizia->utenteID1 = $utenteID1;
        $amicizia->utenteID2 = $utenteID2;
        $amicizia->stato = $stato;
        $amicizia->save();
        return $amicizia;
    } 

    static public function delete_friendship($utenteID1, $utenteID2){
        Amicizia::where('utenteID1', $utenteID1)
        ->where('utenteID2', $utenteID2)
        ->delete();
        Amicizia::where('utenteID1', $utenteID2)
        ->where('utenteID2', $utenteID1)
        ->delete();
    }
        
    static public function update_friendship($utenteID1, $utenteID2, $stato){
        // bloccata1 -> l'utenteID1 blocca l'utenteID2
        // bloccata2 -> l'utenteID2 blocca l'utenteID1
        if($stato == 'blocca') { $stato1 = 'bloccata1'; $stato2 = 'bloccata2'; }
        else { $stato1 = $stato; $stato2 = $stato; }
        Amicizia::where('utenteID1', $utenteID1)
        ->where('utenteID2', $utenteID2)
        ->update(['stato' => $stato1]);
        Amicizia::where('utenteID1', $utenteID2)
        ->where('utenteID2', $utenteID1)
        ->update(['stato' => $stato2]);
        return Amicizia::find_friendship($utenteID1, $utenteID2);
    }

    static public function create_button($amicizia, $utenteID2){
        $id = Auth::id();
        if($amicizia == null){
            return '<button value="'. $utenteID2 .'" class="bottone amicizia nuova" id="button-nuova' . $utenteID2 .'">Aggiugi agli amici</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($amicizia->stato == 'sospesa' && $amicizia->utenteID1 == $id) { 
            return '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina' . $utenteID2 .'">Annulla richiesta</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($amicizia->stato == 'sospesa' && $amicizia->utenteID2 == $id) {
            return '<button value="'. $utenteID2 .'" class="bottone amicizia accetta" id="button-accetta' . $utenteID2 .'">Accetta amicizia</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($amicizia->stato == 'accettata') {
            return '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina' . $utenteID2 .'">Elimina amicizia</button>
            <button value="'. $utenteID2 .'" class="bottone amicizia blocca" id="button-blocca'. $utenteID2 .'">Blocca utente</button>';
        }
        else if($amicizia->stato == 'bloccata1' && $amicizia->utenteID1 == $id) {
            return '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina'. $utenteID2 .'">Sblocca utente</button>';
        }
        else if($amicizia->stato == 'bloccata2' && $amicizia->utenteID2 == $id) {
            return '<button value="'. $utenteID2 .'" class="bottone amicizia elimina" id="button-elimina'. $utenteID2 .'">Sblocca utente</button>';
        }
    }

    static public function search_users($search){
        $id = Auth::id();
        $db = DB::select("SELECT * FROM utente 
            LEFT JOIN (SELECT * FROM amicizia 
			    WHERE utenteID1 = $id OR utenteID2 = $id) AS filtered 
                ON (utenteID = utenteID1 OR utenteID = utenteID2) 
            WHERE (CONCAT(nome, ' ', cognome) LIKE '$search%' OR 
            CONCAT(cognome, ' ', nome) LIKE '$search%')
            AND utenteID != $id 
            AND attivo = 1
            AND (stato IS NULL OR stato = 'accettata' OR stato = 'sospesa' 
                OR (utenteID1 = $id AND stato = 'bloccata1') 
                OR (utenteID2 = $id AND stato = 'bloccata2'))
            ORDER BY filtered.updated_at DESC");
        $db_updated = Amicizia::update_stato($db,$id);
        return $db_updated;
    }

    static public function search_friend($search){
        $id = Auth::id();
        $db = DB::select("SELECT * FROM utente 
            LEFT JOIN (SELECT * FROM amicizia 
			    WHERE utenteID1 = $id OR utenteID2 = $id) AS filtered 
                ON (utenteID = utenteID1 OR utenteID = utenteID2) 
            WHERE (CONCAT(nome, ' ', cognome) LIKE '$search%' OR 
            CONCAT(cognome, ' ', nome) LIKE '$search%')
            AND utenteID != $id 
            AND attivo = 1
            AND stato = 'accettata' 
            ORDER BY filtered.updated_at DESC");
        $db_updated = Amicizia::update_stato($db,$id);
        return $db_updated;
    }

    static public function paginate($items,$perPage){
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($items);
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        return new LengthAwarePaginator($currentPageSearchResults, count($col), 
            $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()]);
    }

}
