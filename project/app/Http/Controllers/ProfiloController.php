<?php


namespace App\Http\Controllers;
use App\Media;
use App\Post;
use App\Reazione;
use App\Commento;
use App\Utente;
use App\Notifica;
use App\Amicizia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Session;
use Response;
use DB;

class ProfiloController extends Controller
{

	//Visualizzo profili utente
   	public function index() {
		
		//Controllo sul login dell'utente
		$id = Auth::id();
		$boolean_amici=0;
        $boolean_bottoni=0;
		$requestID = request('utenteID');
		
		if($id === null){
			return redirect()->action('CreateController@index');
		}
		
		
		$userID = $id;
		$user=Utente::find($userID);
		if ($requestID != null){
			
			$id = $requestID;

			
		}
		
		
		
		
		$utente = DB::table('utente')->where('utenteID', $id)->first();
		//recupero le informazioni dell'utente del profilo
		
		
		
		$data	=	explode("-",$utente->dataNascita);
		
		if($utente->sesso == "0"){
			$sesso = "Maschio";
		} else {
			$sesso = "Femmina";
		}

        $post = DB::select(DB::raw("SELECT sum(flag) as likes, p.attivo, p.postID, p.utenteID, u.nome, u.cognome, u.immagine, "
				. "any_value(m.percorso) as percorso,p.created_at, p.contenuto 
				FROM utente as u 
				join post as p ON u.utenteID = p.utenteID 
				left join "
				. "media as m on p.postID = m.postID 
				left join reazione as r on p.postID = r.postID WHERE p.attivo = 1 and p.utenteID = $id "
				. "GROUP BY postID ORDER BY p.created_at DESC; "));


			
			// userID è l'utente autenticato, id è l'utente del profilo
			$likes = DB::select(DB::raw("SELECT reazione.reazioneID, post.postID FROM reazione left join post on post.postID=reazione.postID where reazione.utenteID=$userID and post.utenteID=$id and reazione.flag=1;"));
			
		//controllo se l'utente autenticato è amico dell'utente proprietario del profilo
			if($userID==$id)
			{
				$boolean_amici=1; //l'utente autenticato e il proprietario del profilo coincidono
                $boolean_bottoni=1;
			}
			else{
				$result = Amicizia::where(function ($query) use ($userID, $id){
                			$query ->where('utenteID1', '=', $id)
                   			 ->orWhere('utenteID1', '=', $userID);
           						 })
            				->where(function ($query) use ($userID, $id){
                			$query ->where('utenteID2', '=', $id)
                    			->orWhere('utenteID2', '=', $userID);
            					})
            				->where('stato','=','accettata')
            				->first();
            	if($result==null){
            		$boolean_amici=0;
            	}
            	else{
            		$boolean_amici=1;
            	}


			}
			

		return view('profilo.profilo', compact('utente','data','sesso','post','userID', 'likes', 'user', 'boolean_amici', 'boolean_bottoni'));
	}
	
	public function storeImage (Request $request) {
		
		$id = Auth::id();
		
		if($request->file('image')) {
            $utente = DB::table('utente')->select('utenteID')->where('utenteID', $id)->first();
            DB::table('utente')
                ->where('utenteID', $id)
                ->update(['immagine' => '/storage/app/userImages/user'.$utente->utenteID]);
            Storage::put("/userImages/user".$utente->utenteID, file_get_contents($request->file('image')->getRealPath()));
        }
        
        //return redirect('/profilo');
         return redirect()->action('ProfiloController@index');
		
	}
	public function store(Request $request) {
    	/* VALIDAZIONE INPUT LATO SERVER -> TEST */
        if($request->control == 1) {
            $this->validate(request(), [
                'post' => 'required|min:3'
            ]); 

            $id = Auth::id();
            if($id == null) {
                $message = "UTENTE NON AUTENTICATO";
                return view('accesso.login',compact('message'));
            }

            /* creo il post */ 
            $post = new Post;
            $post->utenteID = $id;
            $post->attivo=1;
            $testo = request('post');
            $testo = $post->checkSpam($testo);
            $post->contenuto = $testo;
            $post->save();

            /* Upload image */
            if($request->file('image')) {
                /* creo un nuovo media */
                $media = new Media;
                $media->postID = $post->postID;
                $media->percorso = '/storage/app/userMedia/utente'.$id.'/post'.$post->postID.'/'.$request->image->hashName();
                Storage::put('/userMedia/utente'.$id.'/post'.$post->postID.'/'.$request->image->hashName(), file_get_contents($request->file('image')->getRealPath()));

                $media->save();
            }
            return redirect('/profilo');
        } else if($request->control == 2) {
            $utenteID=Auth::id();
            $postID = $request->postID;
            
            //$queryReazione = DB::select(DB::raw("SELECT * from reazione where utenteID=$utenteID and postID=$postID;"));
            $queryReazione=Reazione::where('utenteID', '=', $utenteID)->where('postID', '=', $postID)->first();
            
            if($queryReazione == null) {
                $reazione = new Reazione;
                $reazione->utenteID = $utenteID;
                $reazione->postID = $postID;
                $reazione->flag = 1;
                $reazione->save();
                
            } else {
               $queryReazione->flag=1;
                $queryReazione->save();
                $reazione=$queryReazione;
                
                
            }
            $post_corrente=Post::find($postID);
            $autorePost=$post_corrente->utenteID;
            if($utenteID!=$autorePost)
            {
                
                Notifica::genera_notifica_reazione($autorePost, $reazione->reazioneID);
            }
        } else if($request->control == 3) {
            $utenteID=Auth::id();
            $postID = $request->postID;
            //$queryReazione = DB::select(DB::raw("SELECT * from reazione where utenteID=$utenteID and postID=$postID;"));
            $queryReazione = Reazione::where('utenteID', '=', $utenteID)->where('postID', '=', $postID)->first();
            if($queryReazione != null) {
                DB::table('reazione')->where('utenteID', $utenteID)->where('postID', $postID)->update(['flag' => 0]);
                
            }
        } else if($request->control == 4) {
            $postID = $request->postID;
            $comment = DB::select(DB::raw("SELECT u.utenteID, u.nome, u.cognome,u.immagine, c.contenuto, c.created_at "
                    . "FROM utente as u, post as p, commento as c "
                    . "WHERE u.utenteID=c.utenteID AND p.postID=c.postID AND c.postID=$postID AND c.attivo=1 ORDER BY c.created_at ASC;"));
            
            return Response::json($comment);
        } else if($request->control == 5) {
            $utenteID = Auth::id();
            $postID = $request->postID;
            
            $commento = new Commento;   
            $commento->utenteID = $utenteID;
            $commento->postID = $postID;
            $commento->contenuto = $request->contenuto;
            $commento->attivo = 1;
            $commento->save();
            /* invia notifica al proprietario del post che questo tizio ha inviato un commento */
            // devo generare una notifica per il proprietario del post solo se non è l'utente stesso che si è commentato un post
            
            $checkPost = Post::find($postID);
            if($checkPost != null) {
                if($utenteID != $checkPost->utenteID) {
                    $notifica= new Notifica;
                    $notifica->utenteID = $checkPost->utenteID;
                    $notifica->tipo='commento';
                    $notifica->tipoID=$commento->commentoID;
                    $notifica->letta=0;
                    $notifica->save();
                }
            }
        }
    }
	public function media () {
		
		//Controllo sul login dell'utente
		$userID = Auth::id();
		
		if($userID === null){
			return redirect()->action('CreateController@index');
		}
		
		$id = request('utenteID');

        //se l'utente autenticato è il proprietario del profilo potrà cambiare immagine del profilo
        $boolean_immagine=0;

        if($userID==$id){
            $boolean_immagine=1;
        }
		
		$utente = DB::table('utente')->where('utenteID', $id)->first();
		
		$media = DB::select(DB::raw("SELECT m.percorso FROM utente as u JOIN post as p ON u.utenteID = p.utenteID JOIN media as m "
				. "ON p.postID = m.postID WHERE p.attivo = 1 and p.utenteID = $id ORDER BY p.created_at DESC; "));
		
		$data	=	explode("-",$utente->dataNascita);
		
		
		if($utente->sesso == "0"){
			$sesso = "Maschio";
		} else {
			$sesso = "Femmina";
		}
		
		
		return view('profilo.media', compact('utente','data','sesso','media','userID', 'boolean_immagine'));
		
	}
	
	
}
