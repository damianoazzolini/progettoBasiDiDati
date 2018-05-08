<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Utente;
use App\Staff;
use App\Reparto;
use App\Paziente;
use App\Sala;

class TabellaUtenteSeeder extends Seeder {
    public function run() {
        //ricavo i ruoli
        $role_paziente = Role::where('name','Paziente')->first();
        $role_medico = Role::where('name','Medico')->first();
        $role_infermiere = Role::where('name','Infermiere')->first();
        $role_impiegato = Role::where('name','Impiegato')->first();
        $role_amministratore = Role::where('name','Amministratore')->first();

        //creo un reparto di default per medici e infermieri
        $reparto = new Reparto();
        $reparto->nome = 'Reparto1';
        $reparto->identificativo = 'Cardiologia';
        $reparto->descrizione = 'Reparto di default per i seed';
        $reparto->save();

        //creo una sala di default per il reparto1
        $sala = new Sala();
        $sala->nome = 'Sala1';
        $sala->idReparto = $reparto->id;
        $sala->descrizione = 'Sala di default per Reparto1';
        $sala->piano = '1';
        $sala->save();
       
        //creo un reparto di default per medici e infermieri
        $amministrazione = new Reparto();
        $amministrazione->nome = 'Amministrazione';
        $amministrazione->identificativo = 'Amministrazione';
        $amministrazione->descrizione = 'Reparto di default per i seed';
        $amministrazione->save();

        //creo 5 utenti, uno per ruolo
        $utente_paziente = new Utente();
        $utente_paziente->nome = 'Paziente';
        $utente_paziente->cognome = 'Paz';
        $utente_paziente->dataNascita = '1970-01-01';
        $utente_paziente->sesso = '0';
        $utente_paziente->codiceFiscale = 'AAA';
        $utente_paziente->email = 'paziente@paziente.com';
        $utente_paziente->password = bcrypt('password');
        $utente_paziente->attivo = '1';
        $utente_paziente->telefono = 'empty';
        $utente_paziente->provincia = 'empty';
        $utente_paziente->stato = 'empty';
        $utente_paziente->comune = 'empty';
        $utente_paziente->via = 'empty';
        $utente_paziente->numeroCivico = '0';
        $utente_paziente->remember_token = 'empty';
        $utente_paziente->save();
        $utente_paziente->roles()->attach($role_paziente);
        $paziente = new Paziente();
        $paziente->id = $utente_paziente->id;
        $paziente->note = 'nessuna nota';
        $paziente->altezza = '180';
        $paziente->peso = '70';
        $paziente->save();

        $utente_medico = new Utente();
        $utente_medico->nome = 'Medico';
        $utente_medico->cognome = 'Med';
        $utente_medico->dataNascita = '1970-01-01';
        $utente_medico->sesso = '0';
        $utente_medico->codiceFiscale = 'BBB';
        $utente_medico->email = 'medico@medico.com';
        $utente_medico->password = bcrypt('password');
        $utente_medico->attivo = '1';
        $utente_medico->telefono = 'empty';
        $utente_medico->provincia = 'empty';
        $utente_medico->stato = 'empty';
        $utente_medico->comune = 'empty';
        $utente_medico->via = 'empty';
        $utente_medico->numeroCivico = '0';
        $utente_medico->remember_token = 'empty';
        $utente_medico->save();
        $utente_medico->roles()->attach($role_medico);
        $staff_medico = new Staff();
        $staff_medico->id = $utente_medico->id;
        $staff_medico->idReparto = $reparto->id;
        $staff_medico->identificativo = 'MED01';
        $staff_medico->stipendio = '2000';
        $staff_medico->save();

        $utente_infermiere = new Utente();
        $utente_infermiere->nome = 'Infermiere';
        $utente_infermiere->cognome = 'Inf';
        $utente_infermiere->dataNascita = '1970-01-01';
        $utente_infermiere->sesso = '0';
        $utente_infermiere->codiceFiscale = 'CCC';
        $utente_infermiere->email = 'infermiere@infermiere.com';
        $utente_infermiere->password = bcrypt('password');
        $utente_infermiere->attivo = '1';
        $utente_infermiere->telefono = 'empty';
        $utente_infermiere->provincia = 'empty';
        $utente_infermiere->stato = 'empty';
        $utente_infermiere->comune = 'empty';
        $utente_infermiere->via = 'empty';
        $utente_infermiere->numeroCivico = '0';
        $utente_infermiere->remember_token = 'empty';
        $utente_infermiere->save();
        $utente_infermiere->roles()->attach($role_infermiere);
        $staff_infermiere = new Staff();
        $staff_infermiere->id = $utente_infermiere->id;
        $staff_infermiere->idReparto = $reparto->id;
        $staff_infermiere->identificativo = 'INF01';
        $staff_infermiere->stipendio = '2000';
        $staff_infermiere->save();

        $utente_impiegato = new Utente();
        $utente_impiegato->nome = 'Impiegato';
        $utente_impiegato->cognome = 'Imp';
        $utente_impiegato->dataNascita = '1970-01-01';
        $utente_impiegato->sesso = '0';
        $utente_impiegato->codiceFiscale = 'DDD';
        $utente_impiegato->email = 'impiegato@impiegato.com';
        $utente_impiegato->password = bcrypt('password');
        $utente_impiegato->attivo = '1';
        $utente_impiegato->telefono = 'empty';
        $utente_impiegato->provincia = 'empty';
        $utente_impiegato->stato = 'empty';
        $utente_impiegato->comune = 'empty';
        $utente_impiegato->via = 'empty';
        $utente_impiegato->numeroCivico = '0';
        $utente_impiegato->remember_token = 'empty';
        $utente_impiegato->save();
        $utente_impiegato->roles()->attach($role_impiegato);
        $staff_impiegato = new Staff();
        $staff_impiegato->id = $utente_impiegato->id;
        $staff_impiegato->idReparto = $amministrazione->id;
        $staff_impiegato->identificativo = 'IMP01';
        $staff_impiegato->stipendio = '2000';
        $staff_impiegato->save();

        $utente_amministratore = new Utente();
        $utente_amministratore->nome = 'Amministratore';
        $utente_amministratore->cognome = 'Admin';
        $utente_amministratore->dataNascita = '1970-01-01';
        $utente_amministratore->sesso = '0';
        $utente_amministratore->codiceFiscale = 'EEE';
        $utente_amministratore->email = 'amministratore@amministratore.com';
        $utente_amministratore->password = bcrypt('password');
        $utente_amministratore->attivo = '1';
        $utente_amministratore->telefono = 'empty';
        $utente_amministratore->provincia = 'empty';
        $utente_amministratore->stato = 'empty';
        $utente_amministratore->comune = 'empty';
        $utente_amministratore->via = 'empty';
        $utente_amministratore->numeroCivico = '0';
        $utente_amministratore->remember_token = 'empty';
        $utente_amministratore->save();
        $utente_amministratore->roles()->attach($role_amministratore);  
        $staff_amministratore = new Staff(); 
        $staff_amministratore->id = $utente_amministratore->id;
        $staff_amministratore->idReparto = $amministrazione->id;
        $staff_amministratore->identificativo = 'ADMIN01';
        $staff_amministratore->stipendio = '2000';
        $staff_amministratore->save();     
    }
}
