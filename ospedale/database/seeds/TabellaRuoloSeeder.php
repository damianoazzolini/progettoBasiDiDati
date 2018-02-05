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
        $role_employee->nome = 'farmaco_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST farmaco_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'farmaco_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST farmaco_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'farmaco_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST farmaco_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'farmaco_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST farmaco_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'farmaco_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST farmaco_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'farmaco_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST farmaco_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'farmaco_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST farmaco_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'paziente_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST paziente_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'paziente_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST paziente_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'paziente_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST paziente_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'paziente_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST paziente_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'paziente_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST paziente_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'paziente_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST paziente_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'paziente_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST paziente_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'prestazione_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST prestazione_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'prestazione_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST prestazione_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'prestazione_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST prestazione_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'prestazione_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST prestazione_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'prestazione_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST prestazione_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'prestazione_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST prestazione_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'prestazione_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST prestazione_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'referto_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST referto_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'referto_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST referto_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'referto_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST referto_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'referto_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST referto_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'referto_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST referto_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'referto_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST referto_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'referto_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST referto_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'reparto_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST reparto_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'reparto_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST reparto_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'reparto_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST reparto_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'reparto_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST reparto_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'reparto_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST reparto_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'reparto_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST reparto_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'reparto_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST reparto_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'sala_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST sala_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'sala_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST sala_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'sala_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST sala_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'sala_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST sala_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'sala_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST sala_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'sala_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST sala_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'sala_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST sala_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'staff_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST staff_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'staff_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST staff_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'staff_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST staff_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'staff_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST staff_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'staff_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST staff_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'staff_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST staff_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'staff_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST staff_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'utente_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST utente_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'utente_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST utente_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'utente_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST utente_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'utente_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST utente_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'utente_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST utente_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'utente_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST utente_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'utente_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST utente_destroy';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'tipologiaPrestazione_index';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST tipologiaPrestazione_index';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'tipologiaPrestazione_create';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST tipologiaPrestazione_create';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'tipologiaPrestazione_store';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST tipologiaPrestazione_store';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'tipologiaPrestazione_show';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST tipologiaPrestazione_show';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'tipologiaPrestazione_edit';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST tipologiaPrestazione_edit';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'tipologiaPrestazione_update';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST tipologiaPrestazione_update';
        $role_employee->save();

        $role_employee = new Ruolo();
        $role_employee->nome = 'tipologiaPrestazione_destroy';
        $role_employee->descrizione = 'Autorizzazione ad accedere al metodo REST tipologiaPrestazione_destroy';
        $role_employee->save();
    }
}
