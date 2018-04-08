<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Utente;

class TabellaUtenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $role_0 = Ruolo::where('nome', 'ruolo0')->first();

        $utente = new Utente();
        $utente->nome = 'Administrator';
        $utente->cognome = 'empty';
        $utente->dataNascita = '1970-01-01';
        $utente->sesso = '0';
        $utente->codiceFiscale = 'empty';
        $utente->email = 'admin@admin.com';
        $utente->password = bcrypt('password');
        $utente->attivo = '1';
        $utente->telefono = 'empty';
        $utente->provincia = 'empty';
        $utente->stato = 'empty';
        $utente->comune = 'empty';
        $utente->via = 'empty';
        $utente->numeroCivico = '0';
        $utente->save();
        $utente->roles()->attach($role_0);
        */

        //ricavo i ruoli
        $role_paziente = Role::where('name','Paziente')->first();
        $role_medico = Role::where('name','Medico')->first();
        $role_infermiere = Role::where('name','Infermiere')->first();
        $role_impiegato = Role::where('name','Impiegato')->first();
        $role_amministratore = Role::where('name','Amministratore')->first();

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
    }
}
