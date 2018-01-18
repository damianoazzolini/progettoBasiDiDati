<?php

namespace App\Http\Controllers;
use App\Media;
use App\Post;
use App\Reazione;
use App\Commento;
use App\Utente;
use App\Notifica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Session;
use Response;
use DB;

class HomeController extends Controller {
    public function create() {
        return view('home.home');
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        $message = "LOGOUT EFFETTUATO";
        return redirect()->action('CreateController@index')->with('message',$message);
    }

    public function post(Request $request) {
    	/* VALIDAZIONE INPUT LATO SERVER -> TEST */
        if($request->control == "sendPost") {
            $this->validate(request(), [
                'post' => 'required|min:3'
            ]); 

            $id = Auth::id();
            if($id == null) {
                $message = "UTENTE NON AUTENTICATO";
                return view('accesso.login',compact('message'));
            }

            /* uso utente di default in attesa di login*/
            //$utente = DB::table('utente')->where('email', 'Whess1986@armyspy.com')->first();
            /* creo il post */ 
            $post = new Post;
            $post->utenteID = $id;
            $post->attivo=1;
            $testo = request('post');
            //$testo = $this->checkSpam($testo);
            $testo = $post->checkSpam($testo);
            //$post->contenuto = request('post');
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
            return redirect('/home');
            
        } else if($request->control == "like") {
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
                //DB::table('reazione')->where('utenteID', $utenteID)->where('postID', $postID)->update(['flag' => 1]);
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
            
        } else if($request->control == "dislike") {
            $utenteID=Auth::id();
            $postID = $request->postID;
            //$queryReazione = DB::select(DB::raw("SELECT * from reazione where utenteID=$utenteID and postID=$postID;"));
            $queryReazione = Reazione::where('utenteID', '=', $utenteID)->where('postID', '=', $postID)->first();
            if($queryReazione != null) {
                DB::table('reazione')->where('utenteID', $utenteID)->where('postID', $postID)->update(['flag' => 0]);
            }
            
        } else if($request->control == "getComment") {
            $postID = $request->postID;
            $comment = DB::select(DB::raw("SELECT u.utenteID, u.nome, u.cognome,u.immagine, c.contenuto, c.created_at "
                    . "FROM utente as u, post as p, commento as c "
                    . "WHERE u.utenteID=c.utenteID AND p.postID=c.postID AND c.postID=$postID AND c.attivo=1 ORDER BY c.created_at ASC;"));
            
            return Response::json($comment);
            
        } else if($request->control == "submitComment") {
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
    
    //nuova query che considera solo utenti attivi 
    public function selectIdFromDb($utente) {
        $returnValue = DB::select(DB::raw(" 
            SELECT utenteID1 
            FROM amicizia AS a JOIN utente AS u 
            ON a.utenteID1 = u.utenteID
            WHERE a.utenteID2 = '$utente'
            AND u.attivo = 1
            AND a.utenteID2 NOT IN (
                SELECT utenteID1 
                FROM amicizia
                WHERE utenteID2 = a.utenteID2)            
            UNION
            SELECT utenteID2
            FROM amicizia AS a JOIN utente AS u
            ON a.utenteID2 = u.utenteID
            WHERE a.utenteID1 = '$utente'
            AND u.attivo = 1
            AND a.utenteID1 NOT IN (
                SELECT utenteID2 
                FROM amicizia
                WHERE utenteID1 = a.utenteID1)")); 
        
        return $returnValue;
    }

    public function suggestFriend() {
        $utenteDaProfilare = Auth::id();
        $maxNumberOfFriend = 20;
        $maxCommon = -1;
        $suggestCommon = -1;
        $suggestJaccard = -1;
        $jaccardValue = -1;
        $preferentialValue = -1;
        $suggestPreferential = -1;
        $arrayAmici = array();
        $amiciTarget = $this->selectIdFromDb($utenteDaProfilare);
        $i = 0;
        $aT = [];
        
        foreach($amiciTarget as $amico) {
            $aT[$i] = $amico->utenteID1;
            $i++;
        }

        $nFriendTarget = count($aT);
        $arrayID = DB::table('utente')->where('attivo','=','1')->pluck('utenteID');

        for ($x = 0; $x < $maxNumberOfFriend; $x++) {
            $elementoRand = $arrayID[rand(0,($arrayID->count() - 1))];
            if($elementoRand != $utenteDaProfilare && !in_array($elementoRand,$aT)) {
                $amiciTemp = $this->selectIdFromDb($elementoRand);
                $i = 0;
                $a = array();

                foreach($amiciTemp as $amico) {
                    $a[$i] = $amico->utenteID1;
                    $i++;
                }

                $nFriendCurrent = count($a);
                $intersection = array_intersect($a, $aT);
                $numberCommon = count($intersection);
                $total = $nFriendTarget + $nFriendCurrent;
                $jaccardTemp = -1;

                if($total > 0) {
                    $jaccardTemp = $numberCommon/$total;
                }
                $preferentialTemp = $nFriendTarget*$nFriendCurrent;
                if($preferentialTemp > $preferentialValue) {
                    $preferentialValue = $preferentialTemp;
                    $suggestPreferential = $elementoRand;
                }
                if($jaccardTemp > $jaccardValue) {
                    $jaccardValue = $jaccardTemp;
                    $suggestJaccard = $elementoRand;
                    
                }
                if($numberCommon > $maxCommon) {
                    $maxCommon = $numberCommon;
                    $suggestCommon =  $elementoRand;
                    $arrayAmici = $a;
                }
            }
        }
     
        $returnArray1 = [$suggestCommon,$suggestJaccard,$suggestPreferential];
        $unique = array_unique($returnArray1);
        $returnArray = array();
        $i = 0;

        foreach($unique as $u) {
            $returnArray[$i] = DB::select(DB::raw("SELECT nome, cognome, utenteID, immagine FROM utente WHERE utenteID = $u"));
            $i++;
        }
        return $returnArray;
    }

    public function show() {
        /* mostro tutti i post con nome associato*/
        $id = Auth::id();
        $utente = Utente::find($id);
        $post = DB::select(DB::raw("SELECT sum(flag) as likes, postID, utenteID, nome, cognome, immagine, any_value(percorso) as percorso, created_at, contenuto "
                . "FROM (SELECT u.utenteID, u.nome, u.cognome, u.immagine, p.postID, m.percorso, r.flag, r.reazioneID, p.contenuto, p.created_at "
                . "FROM utente as u join post as p ON u.utenteID = p.utenteID left join media as m ON p.postID = m.postID left "
                . "join reazione as r ON p.postID=r.postID where p.attivo=1 and u.utenteID IN (select utenteID2 as ID from amicizia "
                . "where utenteID1=$id and stato='accettata' "
                . "union (select utenteID1 as ID from amicizia where utenteID2=$id and stato='accettata') "
                . "union (select DISTINCT utenteID from utente where utenteID=$id))) as sbrega "
                . "GROUP BY postID ORDER BY created_at DESC;"));
        
        $suggeriti = $this->suggestFriend();
        // tutti i like che un utente ha messo (serve per la banana gialla nella home //
        $likes = DB::select(DB::raw("SELECT reazioneID, postID FROM reazione where utenteID=$id and flag=1;"));
        
        return view('home.home', compact('utente','post','likes','amici','suggeriti'));
    }   
}
