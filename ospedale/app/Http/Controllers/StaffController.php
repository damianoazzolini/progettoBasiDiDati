<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Utente;
use App\Role;
use App\Staff;

class StaffController extends Controller {
    public function index()  {
        //restituisco tutti i membri dello staff
        $ruolo = Utente::trovaRuolo(Auth::id());
        $queryStaff = DB::table('staff')->select('id')->get();

        $datiStaff = [];
        $ruoliStaff = [];
        
        foreach($queryStaff as $staff) {
            $queryUtente = DB::table('utente')
                ->where('id',$staff->id)
                ->select('nome','cognome','id')
                ->first();

            array_push($datiStaff,$queryUtente);
        }

        return view('elencoStaff',[
            'datiStaff' => $datiStaff,
            'ruolo' => $ruolo]);
    }

    public function create() {
        
    }

    public function store(Request $request) {
        
    }

    public function show($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());

        $query = DB::table('utente')
            ->where('attivo',1)
            ->where('id',$id)
            ->first();

        $queryStaff = DB::table('staff')
            ->where('id',$id)
            ->first();
        
        $reparto = DB::table('reparto')
            ->where('id',$queryStaff->idReparto)
            ->select('nome','descrizione','identificativo')
            ->first();

        return view('mostraStaff',[
            'datiUtente' => $query, 
            'datiStaff' => $queryStaff,
            'reparto' => $reparto,
            'ruolo' => $ruolo]);
    }

    public function edit($id) {
        $ruolo = Utente::trovaRuolo(Auth::id());

        $query = DB::table('utente')
            ->where('attivo',1)
            ->where('id',$id)
            ->first();

        $queryStaff = DB::table('staff')
            ->where('id',$id)
            ->first();
        
        $reparto = DB::table('reparto')
            ->where('id',$queryStaff->idReparto)
            ->select('nome','descrizione','identificativo')
            ->first();

        return view('modificaStaff',[
            'datiUtente' => $query, 
            'datiStaff' => $queryStaff,
            'reparto' => $reparto,
            'ruolo' => $ruolo]);       
    }

    public function update(Request $request, $id) {
        $this->validate(request(), [
            'stipendio' => 'required',
            'nomeReparto' => 'required'
        ]);
        $stipendio = request('stipendio');
        $nomeReparto = request('nomeReparto');
        
        if($nomeReparto != [] && $stipendio > 0) {
            $idReparto = DB::table('reparto')
            ->where('nome',$nomeReparto)
            ->value('id');

            DB::statement("UPDATE staff SET stipendio = $stipendio WHERE id = '$id'"); 
            DB::statement("UPDATE staff SET idReparto = $idReparto WHERE id = '$id'");
            return redirect('/elencoStaff')->with('status','Stipendio e reparto componente staff aggiornato con successo'); 
        }
        else 
            return redirect()->back()->with('status','Reparto inesistente o stipendio incorretto');         
    }

    public function destroy($id) {
        
    }
}
