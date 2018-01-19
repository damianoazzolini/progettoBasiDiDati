<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notifica;
use App\Amicizia;
use App\Utente;
use Session;
use Illuminate\Support\Facades\Auth;
use DB;
class RichiesteamiciziaController extends Controller
{
    public function index(){
	
	$utenteID=Auth::id();

	if($utenteID===null){
            return redirect()->action('CreateController@index');
        
        }
	$array_richieste_amicizia_ricevute_nonlette=[];
	$array_richieste_amicizia_inviate_accettate_nonlette=[];
	$array_richieste_amicizia_ricevute_lette=[];
	$array_richieste_amicizia_inviate_insospeso=[];
	//Seleziona tutte le notifiche relative a una richiesta di amicizia ricevuta dall'utente autenticato che ha già letto ma ha lasciato in sospeso (non ha ancora accettato o rifiutato)
	$amicizia_ricevuta_sospesa_letta=DB::select(DB::raw("
					SELECT * FROM notifica 
					left join amicizia
				 	on tipoID=utenteID1 and utenteID=utenteID2 
					where 
					utenteID='$utenteID' and 
					tipo='amicizia' and 
					stato='sospesa' and 
					letta=1;"));
	//per ogni notifica estrae tutte le informazioni sull'utente che ha inviato la richiesta e le salva in un array
	foreach($amicizia_ricevuta_sospesa_letta as $arsp)
	{
	 	$utente3=Utente::find($arsp->tipoID);
	   	$array_richieste_amicizia_ricevute_lette[]=$utente3;   	
	}

	//Seleziona tutte le notifiche relative a una richiesta di amicizia ricevuta dall'utente autenticato che non ha ancora letto 
	$amicizia_ricevuta_sospesa=DB::select(DB::raw("
					SELECT * FROM notifica 
					left join amicizia
				 	on tipoID=utenteID1 and utenteID=utenteID2 
					where 
					utenteID='$utenteID' and 
					tipo='amicizia' and 
					stato='sospesa' and 
					letta=0;"));
	//per ogni notifica estrae tutte le informazioni sull'utente che ha inviato la richiesta e le salva in un array. Aggiorna la notifica a letta
	foreach($amicizia_ricevuta_sospesa as $ars)
	{
		$utente1=Utente::find($ars->tipoID);
		$array_richieste_amicizia_ricevute_nonlette[]=$utente1;
		$notifica=Notifica::find($ars->notificaID);
		$notifica->letta=1;
		$notifica->save();
	}    

	//Seleziona tutte le notifiche relative a una richiesta di amicizia inviata dall'utente autenticato che è stata accettata e per cui ho ricevuto una notifica di avvenuta conferma che non ho ancora letto
	$amicizia_inviata_accettata=DB::select(DB::raw("
					SELECT * FROM notifica 
					left join amicizia
				 	on tipoID=utenteID2 and utenteID=utenteID1 
					where 
					utenteID='$utenteID' and 
					tipo='amicizia' and 
					stato='accettata' and 
					letta=0;"));
	//per ogni notifica estrae tutte le informazioni sull'utente che ha inviato la richiesta e le salva in un array. Aggiorna la notifica a letta
	foreach($amicizia_inviata_accettata as $aia)
	{
	    $utente2=Utente::find($aia->tipoID);
	    $array_richieste_amicizia_inviate_accettate_nonlette[]=$utente2;
	   	$notifica=Notifica::find($aia->notificaID);
		$notifica->letta=1;
		$notifica->save();
	}
	
	//Seleziona tutte le richieste di amicizia inviate dall'utente autenticato che non sono ancora state accettate ne rifiutate, quindi che sono sospese. 
	$elenco_amicizie_inviate_sospese=Amicizia::get_amicizie_inviate_sospese($utenteID);
	//per ogni amicizia inviata sospesa estrae tutte le informazioni relative all'utente a cui è stata inviata la richiesta e le salva in un array
	foreach($elenco_amicizie_inviate_sospese as $ais)
	{
		 $utente4=Utente::find($ais->utenteID2);
	     $array_richieste_amicizia_inviate_insospeso[]=$utente4;
	}


	//Amici suggeriti
	$suggeriti=[];
	$suggeriti=app('App\Http\Controllers\HomeController')->suggestFriend();

	
	return view('notifiche.richieste_amicizia', compact(
							'array_richieste_amicizia_ricevute_nonlette',
							'array_richieste_amicizia_inviate_accettate_nonlette',
							'array_richieste_amicizia_ricevute_lette',
							'array_richieste_amicizia_inviate_insospeso'
							, 'suggeriti'
						));
    }


    public function store(){
    	$utenteID2=Auth::id();
    	
    	if($utenteID2===null){
            return redirect()->action('CreateController@index');
        
        }
    	
		
		$utenteID1=request('utenteID');
		$tipo=request('tipo');
		$stato=request('stato');
		
		if($stato==='Conferma'){
			$stato='accettata';
		}
		elseif($stato==='Elimina richiesta'){
			$stato='cancellata';
		}
		elseif ($stato==='Blocca') {
			$stato='bloccata2';
			// bloccata2 significa che utenteID2 ha bloccato utenteID1
		}
		elseif ($stato==='Annulla richiesta') {
			$stato='cancellata';

		}
		

		// DEVO AGGIORNARE LO STATO DELLA RIGA DELLA TABELLA CORRISPONDENTE
		if($tipo==='ricevuta'){
			$riga_da_aggiornare=Amicizia::get_amicizia_ricevuta_sospesa($utenteID1, $utenteID2);
		}
		elseif ($tipo==='inviata') {
			$riga_da_aggiornare=Amicizia::get_amicizia_ricevuta_sospesa($utenteID2, $utenteID1);
		}
		foreach($riga_da_aggiornare as $rda)
		{
			if($stato!=='cancellata')
			{

					$rda->stato=$stato;
					$rda->save();
			}
			elseif($stato==='cancellata')
			{
				// Il rifiuto di una richiesta di amicizia cancella la riga dal database
				Amicizia::where('utenteID1', $rda->utenteID1)
						-> where('utenteID2', $rda->utenteID2)
						->delete();
			} 
		}

		// SE E' STATA ACCETTATA UNA RICHIESTA DI AMICIZIA DEVO GENERARE LA NOTIFICA CHE AVVISI IL //	MITTENTE
		if($stato==='accettata' and $tipo==='ricevuta')
		{
			
			Notifica::genera_notifica_amicizia($utenteID1,$utenteID2);
		}

		$utente_modificato=$utenteID1;
		$info_utente=Utente::find($utente_modificato);
		
		//OUTPUT
		$output='';

		//RICHIESTA AMICIZIA ACCETTATA
		if($stato==='accettata' and $tipo==='ricevuta')
		{
				$output .= '<div class="userBox">
					<div class="userImage">
							<div id="cornice" style="width:60px;height:60px; background: url('.$info_utente->immagine.') 50% 0 / cover no-repeat; "></div>
		    				
		    		</div>
		    		<div class="userData">	
						Hai accettato la richiesta di amicizia di <a href="/profilo/id?utenteID='. $info_utente->utenteID.'">'.
		    			 $info_utente->nome.' '.$info_utente->cognome . ' </a></div></div>';



		}
		//RICHIESTA AMICIZIA RIFIUTATA
		if($stato==='cancellata' and $tipo==='ricevuta')
		{
				$output .= '<div class="userBox">
					<div class="userImage">
						<div id="cornice" style="width:60px;height:60px; background: url('.$info_utente->immagine.') 50% 0 / cover no-repeat; "></div>
		    				
		    		</div>
		    		<div class="userData">	
						Hai rifiutato la richiesta di amicizia di <a href="/profilo/id?utenteID='. $info_utente->utenteID.'">'. $info_utente->nome.' '.$info_utente->cognome . ' </div></div>';



		}
		//RICHIESTA AMICIZIA BLOCCATA
		if($stato==='bloccata2' and $tipo==='ricevuta')
		{
				$output .= '<div class="userBox">
					<div class="userImage">
					<div id="cornice" style="width:60px;height:60px; background: url('.$info_utente->immagine.') 50% 0 / cover no-repeat; "></div>
		    				
		    		</div>
		    		<div class="userData">	
						Hai bloccato <a href="/profilo/id?utenteID='. $info_utente->utenteID.'">'. $info_utente->nome.' '.$info_utente->cognome . ' </div></div>';



		}
		//RICHIESTA AMICIZIA ANNULLATA
		if($stato==='cancellata' and $tipo==='inviata')
		{
				$output .= '<div class="userBox">
					<div class="userImage">
					<div id="cornice" style="width:60px;height:60px; background: url('.$info_utente->immagine.') 50% 0 / cover no-repeat; "></div>
		    				
		    		</div>
		    		<div class="userData">	
						Hai annullato la richiesta di amicizia a <a href="/profilo/id?utenteID='. $info_utente->utenteID.'">'. $info_utente->nome.' '.$info_utente->cognome . ' </div></div>';



		}

		echo $output;
		
    }

}
