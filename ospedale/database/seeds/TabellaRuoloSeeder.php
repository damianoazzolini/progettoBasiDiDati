<?php

use Illuminate\Database\Seeder;
use App\Ruolo;

class TabellaRuoloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_employee = new Ruolo();
        $role_employee->nome = 'ruolo0';
        $role_employee->descrizione = 'Amministratore: può compiere tutte le operazioni';
        $role_employee->save();

        $role_manager = new Ruolo();
        $role_manager->nome = 'ruolo1';
        $role_manager->descrizione = 'Livello di autorizzazione che corrisponde alle operazioni consentite a un MEDICO';
        $role_manager->save();

        $role_manager = new Ruolo();
        $role_manager->nome = 'ruolo2';
        $role_manager->descrizione = 'Livello di autorizzazione che corrisponde alle operazioni consentite a un INFERMIERE';
        $role_manager->save();

        $role_manager = new Ruolo();
        $role_manager->nome = 'ruolo3';
        $role_manager->descrizione = 'Livello di autorizzazione che corrisponde alle operazioni consentite a un IMPIEGATO';
        $role_manager->save();

        $role_manager = new Ruolo();
        $role_manager->nome = 'ruolo4';
        $role_manager->descrizione = 'Livello di autorizzazione che corrisponde alle operazioni consentite a un PAZIENTE';
        $role_manager->save();
    }
}
