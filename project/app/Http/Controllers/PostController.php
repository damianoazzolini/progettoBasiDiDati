<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notifica;
use App\Amicizia;
use App\Utente;
use App\Commento;
use App\Reazione;
use App\Post;
use App\Media;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
	public function show($id)
	{
            $utenteID=Auth::id();
            //non autenticato
            if($utenteID===null){
                return redirect()->action('CreateController@index');
            }
            $post=Post::find($id);
            $eliminapost=0;
            //se il post non esiste redirect alla home
            if($post===null){
				return redirect()->action('CreateController@index');
            }
            //se il post è stato eliminato non lo mostro
            elseif($post->attivo=='0'){
		 		return redirect()->action('CreateController@index');
            }
            $autorePostID=$post->utenteID;
            if($utenteID===null){
                return redirect()->action('CreateController@index');                
            }
            else
            {
	            /*utente autenticato: tre possibilità:
	            1. è colui che ha scritto il post
	            2. è amico di colui che ha scritto il post
	            3. non è amico quindi non può vedere il post */
	            if($utenteID!==$autorePostID)
	            {
		        	$amicizia1=Amicizia::where("utenteID1",$utenteID)
				    			->where("utenteID2", $autorePostID)
				    			->where("stato", "accettata")
				    			->get();
				    		
		        	$amicizia2=Amicizia::where("utenteID1",$autorePostID)
				    			->where("utenteID2", $utenteID)
				    			->where("stato", "accettata")
				    			->get();
			    		
					if($amicizia1->isEmpty() and $amicizia2->isEmpty())
					{
					    return redirect()->action('CreateController@index');
					}
            	}
		    	// l'utente autenticato è colui che ha scritto il post, salvo una variabile che gli fornisce la possibilità di eliminare il post
            	else
           		{
					$eliminapost=1;
            	}	    	
        	}
	        $media=Media::where("postID", $id)->first();
	        
	        if($media===null)
	        {
	        	$percorso=null;
	        }
	        else
	        {
	        	$percorso=$media->percorso;
	        }

	        $autorePost=Utente::find($autorePostID);
	        //solo quelli attivi
	        $commenti=$post->commenti()->get()->sortBy('created_at');
	        $reazioni=$post->reazioni()->get();
	        $numeroreazioni=$reazioni->count();
	        Carbon::setLocale('it');
	        $orari =[];
	        $autori_commenti=[];
	        $autori_ID=[];
	        $autori_immagini=[];
	        $autori_reazioni=[];
	        $autori_reazioni_ID=[];
	        // mi dice se utente autenticato ha messo mi piace al post
	        $bool=0;
	        //per ogni commento mi salvo l'orario a cui è stato fatto e l'utente che lo ha scritto
	        foreach($commenti as $c)
	        {
	        	$orari[$c->commentoID]=$c->created_at->diffForHumans();
	        	$autore=Utente::find($c->utenteID);
	        	$autori_ID[$c->commentoID]=$autore->utenteID;
	        	$autori_commenti[$c->commentoID]=$autore->nome . ' '. $autore->cognome;
	        	$autori_immagini[$c->commentoID]=$autore->immagine;
	        }
	        foreach($reazioni as $r)
	        {
	        	if($r->utenteID===$utenteID)
	        	{
	        		$bool=1;
	        	}
	        	//per ogni reazione salvo l'autore della reazione
	        	$autore_reazione=Utente::find($r->utenteID);
	        	$autori_reazioni[$r->reazioneID]=$autore_reazione->nome . ' '. $autore_reazione->cognome;
	        	 $autori_reazioni_ID[$r->reazioneID]=$autore_reazione->utenteID;
	        }

	        //aggiunta tasto elimina commento: se il post è tuo li puoi eliminare tutti altrimenti puoi eliminare solo quelli che hai scritto tu
	        $elimina_commenti=[];
	        foreach($commenti as $c)
	        {
	        	if($utenteID===$autorePostID)
	        	{
	        		$elimina_commenti[$c->commentoID]=1;
	        	}
	        	elseif($utenteID===$c->utenteID)
	        	{
	        		$elimina_commenti[$c->commentoID]=1;
	        	}
	        	else
	        	{
	        		$elimina_commenti[$c->commentoID]=0;
	        	}


        	}
        	$time=$post->created_at->format('d-m-Y H:i');

			return view('post.post', compact('id', 'post', 'time','autorePost', 'commenti','reazioni','numeroreazioni','orari', 'bool', 'utenteID', 'autori_commenti','autori_ID', 'autori_immagini', 'autori_reazioni','autori_reazioni_ID','percorso', 'eliminapost', 'elimina_commenti'));
	}

	public function store(Request $request)
	{
		$utente=$request->utente; //utente che ha scritto il commento
		$post=$request->post; //id del post su cui è stato scritto il commento
		$contenuto=$request->contenuto; //contenuto del commento
		$stato=$request->stato; //stato
		$output='';
		
		 //inserimento di un commento
		
		if($stato=='inserimento_commento')
		{
		 	$this->validate(request(), [
            	'contenuto' => 'required|min:3'
    		]); 
		 	$commento=new Commento;
		 	$commento->utenteID=$utente;
		 	$commento->postID=$post;
		 	$commento->contenuto=$contenuto;
		 	$commento->attivo=1;
			$commento->save();

			// devo generare una notifica per il proprietario del post solo se non è l'utente stesso che si è commentato un post
			$post1=Post::find($post);
			$autorePostID1=$post1->utenteID;
			if($utente!=$autorePostID1){
				$notifica= new Notifica;
				$notifica->utenteID=$autorePostID1;
				$notifica->tipo='commento';
				$notifica->tipoID=$commento->commentoID;
				$notifica->letta=0;
				$notifica->save(); 
			}
			Carbon::setLocale('it');
			//mi servono nome e cognome dell'utente che ha scritto il commento
  			$autore_commento=Utente::find($utente);
  			$immagine_autore_commento=$autore_commento->immagine;
  			$nome_cognome=$autore_commento->nome . ' '. $autore_commento->cognome;
			$orario=$commento->created_at->diffForHumans();

			$result=array();
			$result['data1']= ' <div id="commento_ID'. $commento->commentoID.'" class="styleComment"><div class="userComment"><div class="userImageComment" style="background: url('.$immagine_autore_commento.') 50% 50% / contain no-repeat;"></div></div><div class="userNameComment">
				<img id="'. $commento->commentoID.'" class="commenti" src="'. asset('/systemImages/cancel-button.svg') .'" height="25px" border="0" style="float:right;margin-right: 5px;"><p><a href="/profilo/id?utenteID='. $autore_commento->utenteID.'"><b>'.$nome_cognome.'</b></a> '.$commento->contenuto. '<br/>'. $orario.'</p></div></div>';

                                      
                


  		
  			$result['data2']='<div id="remove-row-addcomment">
    					<input id="hiddenStato" type="hidden" name="stato" value="inserimento_commento"/>
					    <input id="hiddenUtente" type="hidden" name="utente" value="'.$utente.'"/>
					    <input id="hiddenPostID" type="hidden" name="post" value="'.$post.'"/>
					    <textarea class="commentTextarea" cols="40" rows="3" spellcheck="false" placeholder="Scrivi un commento..""></textarea>
					    <button class="submitComment" id="btn-comment">Invia</button>
						</div>';
  
		 	echo json_encode($result); 
		}
		elseif($stato=='inserimento_mipiace')
		{
		 	$numero_like=$request->numero_like; 
		
			// SE NEL DB E' GIA PRESENTE UN MI PIACE DELL'UTENTE A QUESTO POST MA ELIMINATO AGGIORNO QUELLA RIGA CON FLAG A 1 ALTRIMENTI AGGIUNGO RIGA NEL DB
			$reazione_da_cercare=Reazione::where('utenteID', '=', $utente)
		 							->where('postID', '=', $post)
		 							->where('flag', '=', '0')
		 							->first();
		 	if($reazione_da_cercare===null)
		 	{
				$reazione=new Reazione;
				$reazione->utenteID=$utente;
				$reazione->postID=$post;
				$reazione->flag=1;
				$reazione->save();
			}
			else
			{
			 	$reazione_da_cercare->flag=1;
		 		$reazione_da_cercare->save();
		 		$reazione=$reazione_da_cercare;
			}
		 	// devo generare una notifica per il proprietario del post solo se non è l'utente stesso che si è messo mi piace a un post
			$post2=Post::find($post);
			$autorePostID2=$post2->utenteID;
			if($utente!=$autorePostID2)
			{
				
				Notifica::genera_notifica_reazione($autorePostID2, $reazione->reazioneID);
			}
			$autore_reazione=Utente::find($utente);
  			$nome_cognome2=$autore_reazione->nome . ' '. $autore_reazione->cognome;
			
			$numero_like=$numero_like+1;

			$result=array();
			$result['data1']=  '<div id="remove-row-addlike">'.$numero_like.'</div>';

           	$result['data2']=$nome_cognome2;
           	$result['data3']=' <div id="remove-banana-si">
                    <input id="btn-dislike" type="image" name="submit" src="'. asset('/systemImages/banana-si.png').'" height="25px" border="0" alt="Submit">
                     <input id="hiddenStatoDislike" type="hidden" name="stato" value="cancellazione_mipiace"/>
                      <input id="hiddenNumeroDislike" type="hidden" name="numero_dislike" value="'.$numero_like. '"/>
                    <input id="hiddenUtenteDislike" type="hidden" name="utente" value="'. $utente .'"/>
                    <input id="hiddenPostIDDislike" type="hidden" name="post" value="'. $post .'"/>
                 </div>';
            $result['data4']=$reazione->reazioneID;
            $result['data5']=$autore_reazione->utenteID;
            echo json_encode($result); 
		 }
		 elseif($stato=='cancellazione_mipiace')
		 {
		 		$numero_like=$request->numero_like; 
		 		//trovo la reazione di questo utente a quel post e la elimino cioè setto flag a 0
		 		$reazione_da_eliminare=Reazione::where('utenteID', '=', $utente)
		 							->where('postID', '=', $post)
		 							->where('flag', '=', '1')
		 							->first();
		 		$reazione_da_eliminare->flag=0;
		 		$reazione_da_eliminare->save();

		 		$result=array();
		 		$numero_like=$numero_like-1;
		 		$result['data1']=  '<div id="remove-row-addlike">'.$numero_like.'</div>';
		 		//passo id della reazione che ho eliminato come risultato in data2
		 		
				$result['data2']= $reazione_da_eliminare->reazioneID;

					$result['data3']=' <div id="remove-banana-no">
                    <input id="btn-like" type="image" name="submit" src="'. asset('/systemImages/banana-no.png').'" height="25px" border="0" alt="Submit">
                     <input id="hiddenStatoLike" type="hidden" name="stato" value="inserimento_mipiace"/>
                     <input id="hiddenNumeroLike" type="hidden" name="numero_like" value="'.$numero_like. '"/>
                    <input id="hiddenUtenteLike" type="hidden" name="utente" value="'. $utente .'"/>
                    <input id="hiddenPostIDLike" type="hidden" name="post" value="'. $post .'"/>
    
                   
                 </div>';
            
           echo json_encode($result); 
		}
		elseif($stato=="rimuovipost")
		{
		 	$postdarimuovere=Post::find($post);
		 	$postdarimuovere->attivo=0;
		 	$postdarimuovere->save();
		 	echo "ok";
		}
		elseif($stato=="eliminacommento")
		{
		 	$commento=$request->commento; 
		 	$commento_da_rimuovere=Commento::find($commento);
		 	$commento_da_rimuovere->attivo=0;
		 	$commento_da_rimuovere->save();
		 	echo "ok";
		}

	}
}