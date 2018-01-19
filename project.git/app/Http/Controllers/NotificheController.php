<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utente;
use App\Notifica;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificheController extends Controller
{
    public function index(){

    	$utenteID=Auth::id();
       
    	if($utenteID===null){
            return redirect()->action('CreateController@index');
        
        }
        
    	$utente=Utente::find($utenteID);

    	// tutte le notifiche relative all'utente NON LETTE
    	$notifiche=$utente->notifiche()->get()->where('letta','=', '0')->sortByDesc('created_at');


    	$notifiche_nonlette=[];
    	
        Carbon::setLocale('it');
    	foreach($notifiche as $n){
    		if($n->tipo==='commento')
    		{ 
    			$comment=$n->relativa_a;
    			$user=$comment->utente;
    			$post=$comment->post;
    			$notifiche_nonlette[]=[
    						'notifica_ID'	=>	$n->notificaID, 
    						'notifica_createdat'=>	$n->created_at->toDateTimeString(), 
    						'notifica_updatedat'=>	$n->updated_at->toDateTimeString(), 
    						'notifica_ricevente'=>	$n->utenteID, 
    						'notifica_tipo'=>	$n->tipo,
    						'notifica_letta'=>	$n->letta, 
    						'commento_ID' =>	$comment->commentoID, 
    						'commento_createdat'=>	$comment->created_at->toDateTimeString(), 
    						'commento_updatedat'=>	$comment->updated_at->diffForHumans(),
    						'commento_contenuto'=>	$comment->contenuto,
    						'utente_mittenteID'=>	$user->utenteID,
							'utente_mittente_nome'=>	$user->nome,
    						'utente_mittente_cognome'=>	$user->cognome,
    						'utente_mittente_immagine'=>	$user->immagine,
    						'post_ID'=>	$post->postID,
    						'post_contenuto'=>$post->contenuto ];
    			
    		}
    		elseif($n->tipo==='reazione')
    		{
    			$reazione=$n->relativa_a;
    			$user=$reazione->utente;
    			$post=$reazione->post;
    			$notifiche_nonlette[]=[
    						'notifica_ID'	=>	$n->notificaID, 
    						'notifica_createdat'=>	$n->created_at->toDateTimeString(), 
    						'notifica_updatedat'=>	$n->updated_at->toDateTimeString(), 
    						'notifica_ricevente'=>	$n->utenteID, 
    						'notifica_tipo'=>	$n->tipo,
    						'notifica_letta'=>	$n->letta, 
    						'reazione_ID' =>	$reazione->reazioneID, 
    						'reazione_createdat'=>	$reazione->created_at->toDateTimeString(), 
    						'reazione_updatedat'=>	$reazione->updated_at->diffForHumans(),
    						'reazione_flag'=>	$reazione->flag,
    						'utente_mittenteID'=>	$user->utenteID,
							'utente_mittente_nome'=>	$user->nome,
    						'utente_mittente_cognome'=>	$user->cognome,
    						'utente_mittente_immagine'=>	$user->immagine,
    						'post_ID'=>	$post->postID,
    						'post_contenuto'=>$post->contenuto ];
    			
    		}

    	}
        
    	// le ultime 5 notifiche relative all'utente LETTE di tipo commento o reazione
        $notifiche1=$utente->notifiche()->where('letta','=', '1')->where(function ($query) {
                $query ->where('tipo', '=', 'commento')
                    ->orWhere('tipo', '=', 'reazione');
                     })->orderBy('created_at', 'DESC')->limit(5)->get();

               
        $notifiche_lette=[];
        
        Carbon::setLocale('it');
        foreach($notifiche1 as $n){
            if($n->tipo==='commento')
            { 
                $comment=$n->relativa_a;
                $user=$comment->utente;
                $post=$comment->post;
                $notifiche_lette[]=[
                            'notifica_ID'   =>  $n->notificaID, 
                            'notifica_createdat'=>  $n->created_at->toDateTimeString(), 
                            'notifica_updatedat'=>  $n->updated_at->toDateTimeString(), 
                            'notifica_ricevente'=>  $n->utenteID, 
                            'notifica_tipo'=>   $n->tipo,
                            'notifica_letta'=>  $n->letta, 
                            'commento_ID' =>    $comment->commentoID, 
                            'commento_createdat'=>  $comment->created_at->toDateTimeString(), 
                            'commento_updatedat'=>  $comment->updated_at->diffForHumans(),
                            'commento_contenuto'=>  $comment->contenuto,
                            'utente_mittenteID'=>   $user->utenteID,
                            'utente_mittente_nome'=>    $user->nome,
                            'utente_mittente_cognome'=> $user->cognome,
                            'utente_mittente_immagine'=>    $user->immagine,
                            'post_ID'=> $post->postID,
                            'post_contenuto'=>$post->contenuto ];
                
            }
            elseif($n->tipo==='reazione')
            {
                $reazione=$n->relativa_a;
                $user=$reazione->utente;
                $post=$reazione->post;
                $notifiche_lette[]=[
                            'notifica_ID'   =>  $n->notificaID, 
                            'notifica_createdat'=>  $n->created_at->toDateTimeString(), 
                            'notifica_updatedat'=>  $n->updated_at->toDateTimeString(), 
                            'notifica_ricevente'=>  $n->utenteID, 
                            'notifica_tipo'=>   $n->tipo,
                            'notifica_letta'=>  $n->letta, 
                            'reazione_ID' =>    $reazione->reazioneID, 
                            'reazione_createdat'=>  $reazione->created_at->toDateTimeString(), 
                            'reazione_updatedat'=>  $reazione->updated_at->diffForHumans(),
                            'reazione_flag'=>   $reazione->flag,
                            'utente_mittenteID'=>   $user->utenteID,
                            'utente_mittente_nome'=>    $user->nome,
                            'utente_mittente_cognome'=> $user->cognome,
                            'utente_mittente_immagine'=>    $user->immagine,
                            'post_ID'=> $post->postID,
                            'post_contenuto'=>$post->contenuto ];
                
            }

        }




    	foreach($notifiche_nonlette as $r){
    		//Per ogni notifica non letta devo aggiornare la corrispondente riga del DB in quanto una volta caricata la pagina la notifica diventa letta

                $notifica_da_aggiornare= Notifica::find($r['notifica_ID']);
                $notifica_da_aggiornare->letta=1;
                $notifica_da_aggiornare->save();

    		

    	}
		
    	return view('notifiche.notifiche', compact('notifiche_nonlette', 'notifiche_lette'));
    }

    public function loadData(Request $request){

        $utenteID=Auth::id();
       
        if($utenteID===null){
            return redirect()->action('CreateController@index');
        
        }
        
        $utente=Utente::find($utenteID);

        $output='';
        $id=$request->id;

        $stato=$request->stato;
        $ultimanotifica=$request->ultimanotifica;

        if($id!==null)
        {
        // le ultime 5 notifiche relative all'utente LETTE di tipo commento o reazione precedenti l'ultima visualizzata
        $notifiche=$utente->notifiche()->where('letta','=', '1')->where('notificaID','<',$id)->where(function ($query) {
                $query ->where('tipo', '=', 'commento')
                    ->orWhere('tipo', '=', 'reazione');
                     })->orderBy('created_at', 'DESC')->limit(5)->get();


        $notifiche_lette=[];
        
        Carbon::setLocale('it');
        if(!$notifiche->isEmpty())
        {

            foreach($notifiche as $n)
            {
                if($n->tipo==='commento')
                { 
                    $comment=$n->relativa_a;
                    $user=$comment->utente;
                    $post=$comment->post;
                    $notifiche_lette[]=[
                                'notifica_ID'   =>  $n->notificaID, 
                                'notifica_createdat'=>  $n->created_at->toDateTimeString(), 
                                'notifica_updatedat'=>  $n->updated_at->toDateTimeString(), 
                                'notifica_ricevente'=>  $n->utenteID, 
                                'notifica_tipo'=>   $n->tipo,
                                'notifica_letta'=>  $n->letta, 
                                'commento_ID' =>    $comment->commentoID, 
                                'commento_createdat'=>  $comment->created_at->toDateTimeString(), 
                                'commento_updatedat'=>  $comment->updated_at->diffForHumans(),
                                'commento_contenuto'=>  $comment->contenuto,
                                'utente_mittenteID'=>   $user->utenteID,
                                'utente_mittente_nome'=>    $user->nome,
                                'utente_mittente_cognome'=> $user->cognome,
                                'utente_mittente_immagine'=>    $user->immagine,
                                'post_ID'=> $post->postID,
                                'post_contenuto'=>$post->contenuto ];
                    
                }
                elseif($n->tipo==='reazione')
                {
                    $reazione=$n->relativa_a;
                    $user=$reazione->utente;
                    $post=$reazione->post;
                    $notifiche_lette[]=[
                                'notifica_ID'   =>  $n->notificaID, 
                                'notifica_createdat'=>  $n->created_at->toDateTimeString(), 
                                'notifica_updatedat'=>  $n->updated_at->toDateTimeString(), 
                                'notifica_ricevente'=>  $n->utenteID, 
                                'notifica_tipo'=>   $n->tipo,
                                'notifica_letta'=>  $n->letta, 
                                'reazione_ID' =>    $reazione->reazioneID, 
                                'reazione_createdat'=>  $reazione->created_at->toDateTimeString(), 
                                'reazione_updatedat'=>  $reazione->updated_at->diffForHumans(),
                                'reazione_flag'=>   $reazione->flag,
                                'utente_mittenteID'=>   $user->utenteID,
                                'utente_mittente_nome'=>    $user->nome,
                                'utente_mittente_cognome'=> $user->cognome,
                                'utente_mittente_immagine'=>    $user->immagine,
                                'post_ID'=> $post->postID,
                                'post_contenuto'=>$post->contenuto ];
                }
            }

            foreach($notifiche_lette as $n)
            {
                $output .='<div class="userBox">
                                <div class="userImage">
                                    <div id="cornice"
                style="width:60px;height:60px; background: url('.$n['utente_mittente_immagine'].') 50% 0 / cover no-repeat; "></div>
                                  
                                </div>';

                

                if($n['notifica_tipo']==='commento')
                {

                       $output .='<div class="userData">'.
                                    $n['utente_mittente_nome'].' '.$n['utente_mittente_cognome'].' ha commentato il tuo post ';
                        $output .='<a href="/posts/'. $n['post_ID'].'" style="text-decoration:underline;">';
                            if(strlen($n['post_contenuto'])> 10)
                            { 
                                $output .='"';
                                for($i=0; $i<=10; $i++)
                                {
                                    $output .= $n['post_contenuto'][$i];
                                 }
                                $output .= '..."';
                                
                             }   
                            else
                            {
                                $output .='"'.$n['post_contenuto'].'"';

                                 //dd($output);
                            }
                            $output .='</a>';
                            $output .='<div class="userDate">'.
                                $n['commento_updatedat'].'
                            </div>
                        </div>';
                       

                }

                elseif($n['notifica_tipo']==='reazione')   
                {
                    $output .='<div class="userData">'.
                            $n['utente_mittente_nome'].' '.$n['utente_mittente_cognome'].'  ha aggiunto una reazione al tuo post ';
                     $output .='<a href="/posts/'. $n['post_ID'].'" style="text-decoration:underline;">';

                           if(strlen($n['post_contenuto'])> 10)
                            { 
                                $output .='"';
                                for($i=0; $i<=10; $i++)
                                {
                                    $output .= $n['post_contenuto'][$i];
                                 }
                                $output .= '..."';
                                 
                             }   
                            else
                            {
                                $output .='"'.$n['post_contenuto'].'"';
                            
                            }
                            $output .='</a>';
                            $output .='<div class="userDate">'.
                                $n['reazione_updatedat'].'
                            </div>
                        </div>';
                }
                $output .='</div>';
                

            }
            $output .= '<div id="remove-row">
             <button id="btn-more" data-id="'. $n['notifica_ID'] .'"> Carica precedenti </button>
        </div>';
            
            echo $output;
            
        }

    }// chiude if id!=null
    elseif($stato!==null and $ultimanotifica!==null)
    {
        $notifiche_nl=$utente->notifiche()->where('letta','=', '0')->where('notificaID','>',$ultimanotifica)->where(function ($query) {
                $query ->where('tipo', '=', 'commento')
                    ->orWhere('tipo', '=', 'reazione');
                     })->orderBy('created_at', 'DESC')->get();

        $notifiche_nonlette=[];
        
        Carbon::setLocale('it');
        if(!$notifiche_nl->isEmpty())
        {

            foreach($notifiche_nl as $n)
            {
                if($n->tipo==='commento')
                { 
                    $comment=$n->relativa_a;
                    $user=$comment->utente;
                    $post=$comment->post;
                    $notifiche_nonlette[]=[
                                'notifica_ID'   =>  $n->notificaID, 
                                'notifica_createdat'=>  $n->created_at->toDateTimeString(), 
                                'notifica_updatedat'=>  $n->updated_at->toDateTimeString(), 
                                'notifica_ricevente'=>  $n->utenteID, 
                                'notifica_tipo'=>   $n->tipo,
                                'notifica_letta'=>  $n->letta, 
                                'commento_ID' =>    $comment->commentoID, 
                                'commento_createdat'=>  $comment->created_at->toDateTimeString(), 
                                'commento_updatedat'=>  $comment->updated_at->diffForHumans(),
                                'commento_contenuto'=>  $comment->contenuto,
                                'utente_mittenteID'=>   $user->utenteID,
                                'utente_mittente_nome'=>    $user->nome,
                                'utente_mittente_cognome'=> $user->cognome,
                                'utente_mittente_immagine'=>    $user->immagine,
                                'post_ID'=> $post->postID,
                                'post_contenuto'=>$post->contenuto ];
                    
                }
                elseif($n->tipo==='reazione')
                {
                    $reazione=$n->relativa_a;
                    $user=$reazione->utente;
                    $post=$reazione->post;
                    $notifiche_nonlette[]=[
                                'notifica_ID'   =>  $n->notificaID, 
                                'notifica_createdat'=>  $n->created_at->toDateTimeString(), 
                                'notifica_updatedat'=>  $n->updated_at->toDateTimeString(), 
                                'notifica_ricevente'=>  $n->utenteID, 
                                'notifica_tipo'=>   $n->tipo,
                                'notifica_letta'=>  $n->letta, 
                                'reazione_ID' =>    $reazione->reazioneID, 
                                'reazione_createdat'=>  $reazione->created_at->toDateTimeString(), 
                                'reazione_updatedat'=>  $reazione->updated_at->diffForHumans(),
                                'reazione_flag'=>   $reazione->flag,
                                'utente_mittenteID'=>   $user->utenteID,
                                'utente_mittente_nome'=>    $user->nome,
                                'utente_mittente_cognome'=> $user->cognome,
                                'utente_mittente_immagine'=>    $user->immagine,
                                'post_ID'=> $post->postID,
                                'post_contenuto'=>$post->contenuto ];
                }
            }

            foreach($notifiche_nonlette as $n)
            {
                $output .='<div class="userBox">
                                <div class="userImage">
                                <div id="cornice"
                style="width:60px;height:60px; background: url('.$n['utente_mittente_immagine'].') 50% 0 / cover no-repeat; "></div>
                                    
                                </div>';

                

                if($n['notifica_tipo']==='commento')
                {

                       $output .='<div class="userData"><a href="/profilo/id?utenteID='. $n['utente_mittenteID']. '">'.
                                    $n['utente_mittente_nome'].' '.$n['utente_mittente_cognome'].'</a> ha commentato il tuo post ';
                        $output .='<a href="/posts/'. $n['post_ID'].'" style="text-decoration:underline;">';
                            if(strlen($n['post_contenuto'])> 10)
                            { 
                                $output .='"';
                                for($i=0; $i<=10; $i++)
                                {
                                    $output .= $n['post_contenuto'][$i];
                                 }
                                $output .= '..."';
                                
                             }   
                            else
                            {
                                $output .='"'.$n['post_contenuto'].'"';

                                 //dd($output);
                            }
                            $output .='</a>';
                            $output .='<div class="userDate">'.
                                $n['commento_updatedat'].'
                            </div>
                        </div>';
                       

                }

                elseif($n['notifica_tipo']==='reazione')   
                {
                    $output .='<div class="userData"><a href="/profilo/id?utenteID='. $n['utente_mittenteID']. '">'.
                            $n['utente_mittente_nome'].' '.$n['utente_mittente_cognome'].'</a> ha aggiunto una reazione al tuo post ';
                     $output .='<a href="/posts/'. $n['post_ID'].'" style="text-decoration:underline;">';

                           if(strlen($n['post_contenuto'])> 10)
                            { 
                                $output .='"';
                                for($i=0; $i<=10; $i++)
                                {
                                    $output .= $n['post_contenuto'][$i];
                                 }
                                $output .= '..."';
                                 
                             }   
                            else
                            {
                                $output .='"'.$n['post_contenuto'].'"';
                            
                            }
                            $output .='</a>';
                            $output .='<div class="userDate">'.
                                $n['reazione_updatedat'].'
                            </div>
                        </div>';
                }
                $output .='</div>';
                

            }
            $result=array();
            $result['data1']=$output;
            $result['data2']=$notifiche_nonlette[0]['notifica_ID'];
            
            foreach($notifiche_nonlette as $r){
            //Per ogni notifica non letta devo aggiornare la corrispondente riga del DB in quanto una volta caricata la pagina la notifica diventa letta

                $notifica_da_aggiornare= Notifica::find($r['notifica_ID']);
                $notifica_da_aggiornare->letta=1;
                $notifica_da_aggiornare->save();
             }
            echo json_encode($result); 
            
        }

    }
    }

}
