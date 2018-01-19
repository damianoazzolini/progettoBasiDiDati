<?php

namespace App\Http\Controllers;

use DB;
use Response;
use App\Utente;
use App\Chat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller {
    
    public function create() {
        return view('chat.chat');
    }
    public function show() {
        $id = Auth::id();
        $utente = Utente::find($id);
        $amici = DB::select(DB::raw("SELECT * from utente where utenteID IN (select utenteID1 from amicizia where utenteID2=$id and stato='accettata' union (select utenteID2 FROM amicizia where utenteID1=$id and stato='accettata'))"));
        
        return view('chat.chat', compact('amici','utente'));
    }
    public function post(Request $request) {
        $id = Auth::id();
        
        if($request->control == "getFriendChat") {
            
            $chatIdentifier1 = $request->chatID1;
            $chatIdentifier2 = $request->chatID2;
            $chat = DB::select(DB::raw("SELECT chatID, DATE_FORMAT(`created_at`, '%d/%m/%Y %H:%i') as created_at, chatIdentifier, receiverID, senderID, text from chat where (chatIdentifier='$chatIdentifier1' OR chatIdentifier='$chatIdentifier2');"));
            
            
            if($chat == null) {
                return Response::json("none");
            } else {
                return Response::json($chat);
            }
            
        } else if($request->control == "sendMessage") {
            
            $chat = new Chat;
            $chat->chatIdentifier = $request->chatID;
            $chat->senderID = $id;
            $chat->receiverID = $request->receiverID;
            $chat->text = $request->text;
            $chat->save();
            
        } else if($request->control == "getNewMessages") {
            
            $chatIdentifier1 = $request->chatID1;
            $chatIdentifier2 = $request->chatID2;
            $lastID=$request->lastID;
            
            $chat = DB::select(DB::raw("SELECT * from chat where (chatIdentifier='$chatIdentifier1' OR chatIdentifier='$chatIdentifier2') and chatID>=$lastID;"));
            
            if($chat == null) {
                return Response::json("none");
            } else {
                return Response::json($chat);
            }
        }
    }
    
}
