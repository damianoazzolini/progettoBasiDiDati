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

    public function store(Request $request) {
        //
    }

    public function registrazione(Request $request) {
        $utente = new Utente();
        //salvo i vari campi
        $utente->save();

        //per assegnare un rulo di default
        $utente->roles()->attach(Role::where('name','Paziente')->first());
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

    public function showLogin() {
        return view('login');
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
