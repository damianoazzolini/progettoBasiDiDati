<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Utente;
use App\Role;
use App\PazienteFarmaco;
use App\Farmaco;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function trovaRuolo() {
        $id = Auth::id();
        $ruoloID = DB::table('utente_role')->where('user_id', $id)->value('role_id');
        $ruolo = DB::table('roles')->where('id',$ruoloID)->value('name');
        return $ruolo;
    }
    
    public function show() {
        //$users = DB::table('utente')->get();
        //ATTENZIONE, TIRO SU TUTTI GLI UTENTI, RISCHIO DI BUTTARE GIU IL PROGRAMMA 
        $users = Utente::all();
        $ruolo = $this->trovaRuolo();


        return view('dashboard',['users' => $users,'ruolo' => $ruolo]);
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

    //l'admin cambia i ruoli
    public function assegnaRuolo(Request $request) {

        $user = Utente::where('email',$request['email'])->first();
        $user->roles()->detach();
        if($request['ruolo_paziente']) {
            $user->roles()->attach(Role::where('name','Paziente')->first());
        }
        if($request['ruolo_medico']) {
            $user->roles()->attach(Role::where('name','Medico')->first());
        }
        if($request['ruolo_infermiere']) {
            $user->roles()->attach(Role::where('name','Infermiere')->first());
        }
        if($request['ruolo_impiegato']) {
            $user->roles()->attach(Role::where('name','Impiegato')->first());
        }
        if($request['ruolo_amministratore']) {
            $user->roles()->attach(Role::where('name','Amministratore')->first());
        }

        return redirect()->back();
    }

    public function showProfilo() {
        
    }

    public function showFarmaci() {
        $id = Auth::id();
        $idFarmaco = PazienteFarmaco::where('idPaziente',$id)->get('idFarmaco');
        //per ogni farmaco assunto dal paziente cerco nella lista farmaci
        //forach($idFarmaco  $farmaco) {
        //    $farm = Farmaco::where('id',$farmaco)->first(); //dovrebbe essere uno solo 
        //}
    }
}
