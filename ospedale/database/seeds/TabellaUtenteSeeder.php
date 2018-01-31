<?php

use Illuminate\Database\Seeder;
use App\Ruolo;
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
    }
}
