<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchResult extends Model
{
    public $utenteID;
    public $nome;
    public $cognome;
    public $immagine;
    public $utenteID1;
    public $utenteID2;
    public $stato;

    static public function paginate($items,$perPage){
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $col = new Collection($items);
        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();
        return new LengthAwarePaginator($currentPageSearchResults, count($col), 
            $perPage, $currentPage,['path' => LengthAwarePaginator::resolveCurrentPath()]);
    }
}


