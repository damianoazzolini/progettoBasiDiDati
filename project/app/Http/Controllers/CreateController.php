<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Utente;
use Mail;
use App\Mail\Benvenuto;
use App\Mail\Recupero;
use DB;

//per poter utilizzare Auth
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller {

    /*
    public function __construct() {
        $this->middleware('revalidate');
    }
    */

    public function index() {
    	return view('accesso.login');
    }
    
    public function developers() {
        return view('accesso.sviluppatori');
    }

    public function login(Request $request) {
        $this->validate(request(), [
           'email' => 'required',
           'password' => 'required'
        ]);
        
        if($request->remember == "true")
            $val=true;
        else
            $val=false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'attivo' => 1],$val)) {
            return redirect('home');       
        } else {
            if(DB::table('utente')->where('email', $request->email)->where('attivo','1')->first() != null) {
                return redirect()->back()->withErrors(['errore' => ['MAIL O PASSWORD ERRATA']]);
            }
            else {
                return redirect()->back()->withErrors(['errore' => ['MAIL NON VERIFICATA']]);
            }
        }        
    }
    
    
    public function create() {
    	return view('accesso.registrazione');
    }
    
    public function store(Request $request) {
    	/* VALIDAZIONE INPUT LATO SERVER -> TEST */
    	$this->validate(request(), [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'email' => 'required|min:3|unique:utente',
            'password' => 'required|min:3',
            'date' => 'required|min:3', 
            'sex' => 'required', 
    	]);
    	
        $utente = new Utente;
        $utente->nome = request('name');
        $utente->cognome = request('surname');
        $utente->email = request('email');
        $utente->password = bcrypt(request('password')); //<--------------- NON MD5 -------------------
        $utente->attivo = '0';
        $utente->dataNascita = request('date');
        $utente->sesso = request('sex');
        $utente->immagine = '/systemImages/defaultUserImage.svg';
        $utente->codice = substr(md5(uniqid(mt_rand(), true)) , 0, 32);
        $utente->remember_token = 0;

        $utente->save();
        Mail::to($utente->email)->send(new Benvenuto($utente->codice));
        
        /* Upload image */
        if($request->file('image')) {
            $utente = DB::table('utente')->select('utenteID')->where('email', request('email'))->first();
            DB::table('utente')
                ->where('utenteID', $utente->utenteID)
                ->update(['immagine' => '/storage/app/userImages/user'.$utente->utenteID]);
            Storage::put("/userImages/user".$utente->utenteID, file_get_contents($request->file('image')->getRealPath()));
        }
        
        return redirect('/')->with('registration','registrazione');
    }

    public function confirm() {
        $this->validate(request(),[
            'usercode' => 'required|min:3'
        ]);
        /*trovo l'utente*/
        $utente = DB::table('utente')->where('codice', request('usercode'))->first();
        if ($utente==null)
            return redirect('/registrazione/conferma')->with('status','Codice non trovato. Si prega di riprovare'); 
        else {
            /* aggiorno tabella */
            DB::table('utente')
                ->where('codice', request('usercode'))
                ->update(['attivo' => 1]);
            echo $utente->nome;
            return redirect('/')->with('status','validation');
        }
    }

    public function recoversPassword()
    {
        $this->validate(request(),[
            'email' => 'required|min:3'
        ]);
        $utente = DB::table('utente')->where('email', request('email'))->first();
        if ($utente==null)
            return redirect('/recuperaPassword')->with('status','Email inserita non esistente. Si prega di riprovare'); 
        else {
            /* creo una password provvisoria */
            $provvisoria = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
            
            /* Aggiorno la password */
            DB::table('utente')
                ->where('email', request('email'))
                ->update(['codice' => $provvisoria]);
            /* invio email con password provvisoria */
            Mail::to($utente->email)->send(new Recupero($utente->utenteID, $provvisoria));
                     
            return redirect('/')->with('recover', 'Ti abbiamo inviato una mail con password provvisoria');
        }
    }
    public function changePassword() {
        $this->validate(request(),[
            'oldpass' => 'required|min:3',
            'newpass' => 'required|min:3',
            'newpassConfirm' => 'required|min:3'
        ]);
        /* controllo la password */
        $validate = DB::table('utente')->where('codice', request('oldpass'))->first();  
        if ($validate==null){
            return redirect('/recuperaPassword/cambiaPassword')->with('status','La password inserita non è corretta. Si prega di riprovare'); 
        }
        /*trovo l'utente*/
        $utente = DB::table('utente')->where('utenteID', request('usercode'))->first();
        if ($utente==null)
            return redirect('/')->with('status','Errore nella procedura'); 
        else  {
            /*aggiorno tabella */
            DB::table('utente')
                ->where('utenteID', request('usercode'))
                ->update(['password' => bcrypt(request('newpass'))]);
            return redirect('/')->with('changepass','Password aggiornata ');
        }		
    }
    
    
    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
  
}
