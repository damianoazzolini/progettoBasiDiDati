<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder {
    
    public function run() {
        $role_paziente = new Role();
        $role_paziente->name = "Paziente";
        $role_paziente->description = "Ruolo per il paziente";
        $role_paziente->save();

        $role_medico = new Role();
        $role_medico->name = "Medico";
        $role_medico->description = "Ruolo per il medico";
        $role_medico->save();

        $role_infermiere = new Role();
        $role_infermiere->name = "Infermiere";
        $role_infermiere->description = "Ruolo l'infermiere";
        $role_infermiere->save();

        $role_impiegato = new Role();
        $role_impiegato->name = "Impiegato";
        $role_impiegato->description = "Ruolo l'impiegato";
        $role_impiegato->save();

        $role_amministratore = new Role();
        $role_amministratore->name = "Amministratore";
        $role_amministratore->description = "Ruolo l'amministratore";
        $role_amministratore->save();
    }
}
