<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Utente;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create() {
        
    }

    public function login(Request $request) {
        $this->validate(request(), [
           'email' => 'required',
           'password' => 'required'
        ]);

        $val = 0; //variabile per il remember me
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'attivo' => 1],$val)) {
            return redirect('/dashboard');       
        } else {
            if(DB::table('utente')->where('email', $request->email)->where('attivo','1')->first() != null) {
                return redirect()->back()->withErrors(['errore' => ['MAIL O PASSWORD ERRATA']]);
            }
            else {
                return redirect()->back()->withErrors(['errore' => ['MAIL NON VERIFICATA']]);
            }
        }        
    }

    public function logout() {
        Auth::logout();
        $message = "LOGOUT EFFETTUATO";
        return redirect('/')->with('status',$message);
    }

    //usato per la registrazione
    public function store(Request $request) {

        $this->validate(request(), [
            'nome' => 'required|min:3',
            'cognome' => 'required|min:3',
            'email' => 'required|min:3|unique:utente',
            'password' => 'required|min:3',
        ]);
    	
        $utente = new Utente();
        $utente->nome = request('nome');
        $utente->cognome = request('cognome');
        $utente->dataNascita = request('dataNascita');
        $sesso = request('sesso');
        if($sesso == 'uomo') {
            $utente->sesso = '1';
        }
        else {
            $utente->sesso = '0';
        }
        $utente->codiceFiscale = request('codiceFiscale');
        $utente->email = request('email');
        $utente->password = bcrypt(request('password')); //<--------------- NON MD5 -------------------
        $utente->attivo = '1';
        $utente->telefono = request('telefono');
        $utente->provincia = request('provincia');
        $utente->stato = request('stato');
        $utente->comune = request('comune');
        $utente->via = request('via');
        $utente->numeroCivico = (int)request('civico');
        $utente->save();

        $role_paziente = Role::where('name','Paziente')->first();
        $role_medico = Role::where('name','Medico')->first();
        $role_infermiere = Role::where('name','Infermiere')->first();
        $role_impiegato = Role::where('name','Impiegato')->first();
        $role_amministratore = Role::where('name','Amministratore')->first();
        $ruolo = request('ruolo');

        if($ruolo == 'paziente') {
            $utente->roles()->attach($role_paziente);
        }
        if($ruolo == 'medico') {
            $utente->roles()->attach($role_medico);
        }
        if($ruolo == 'infermiere') {
            $utente->roles()->attach($role_infermiere);
        }
        if($ruolo == 'impiegato') {
            $utente->roles()->attach($role_impiegato);
        }
        if($ruolo == 'amministratore') {
            $utente->roles()->attach($role_amministratore);
        }

        return redirect('/')->with('status','Utente registrato');
    }

    

    public function showLogin() {
        return view('login');
    }

    public function showRegistrazione() {
        return view('registrazione');
    }

    public function show($id) {
        
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
